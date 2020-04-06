<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Session;
use App\Utilisateur;
use App\M_Projet;
use App\Droit;

class NouveauProjet extends Controller
{
    public function getForm()
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
        //Récupération de l'id utilisateur
        $id_utilisateur = Session::get('id_utilisateur');
        //Si l'utilisateur est connecté, on récupère les infos de ses projets
        if(isset($id_utilisateur))
        {
            //Récupération des infos de l'utilisateur
            $utilisateur = Utilisateur::where('id', $id_utilisateur)->first();
            //Redirection vers la vue accueil
            return view('nouveau-projet', compact('utilisateur', 'constants'));
        }
        else
        {
            //Sinon, on le redirige vers la page de connexion
            return view('login');
        }
    }

    public function postForm(Request $request)
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
        //Récupération de l'id utilisateur
        $id_utilisateur = Session::get('id_utilisateur');
        //Récupération des infos de l'utilisateur
        $utilisateur = Utilisateur::where('id', $id_utilisateur)->first();

        $nom = $request->input('nom'); //Récupération de la valeur du nom du projet
        $type = $request->input('optionsRadios'); //Récupération de la valeur du type du projet

        //Si l'utilisateur a choisi la première option
        if($type == "option1")
        {
            //C'est que c'est un projet
            $type = $constants["TYPE_PROJET"];
        }
        else
        {
            //Sinon, c'est une classroom
            $type = $constants["TYPE_CLASSROOM"];
        }

        //Maintenant qu'on a toutes les infos pour la création du projet
        $projet = new M_Projet; //On instancie un objet de type Projet
        $projet->nom = $nom; //On lui affecte son nom
        $projet->id_port = '1'; //Le port par défaut de son docker

        //On vérifie que l'utilisateur est bien un enseignant
        if($utilisateur->status == $constants["STATUS_ENSEIGNANT"])
        {
            $projet->type = $type; //Son type
        }
        else
        {
            $projet->type = $constants["TYPE_PROJET"];
        }

        $projet->save(); //Et on enregistre en bdd

        //Création du droit admin sur le projet
        $droit = new Droit; //Instanciation d'un objet de type droit
        $droit->id_utilisateur = $id_utilisateur; //Affectation de l'utilisateur
        $droit->id_projet = $projet->id; //Affectation du projet
        $droit->role = $constants["ROLE_ADMIN"]; //Puis on dit que c'est l'admin
        $droit->save(); //On fini par sauvegarder en bdd
	$this->createMachineFile($projet->id);
	shell_exec('cd /var/www/XRS_Ide/docker && ./build.sh '.$projet->id);
        //Redirection vers l'accueil des projets
        return redirect('/');
    }

    public function createMachineFile($name)
    {
	$template = fopen("/var/www/XRS_Ide/docker/template.machine","r");
	$machine = fopen("/var/www/XRS_Ide/docker/".$name.".machine", "w");
	while(! feof($template))
	{
	    $line = fgets($template);
	    fwrite($machine, $line);
	}
	fclose($template);
    }
}
