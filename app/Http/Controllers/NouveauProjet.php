<?php

namespace App\Http\Controllers;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
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
        $projet->port = '0'; //Le port par défaut de son docker

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

        $unwanted_array = $constants["UNWANTED_ARRAY"];
    	$variables = array("PACKAGES" => "python3", "USERNAME" => preg_replace("/[^a-zA-Z0-9]+/", "", strtolower(strtr($utilisateur->prenom, $unwanted_array )).strtolower(strtr($utilisateur->nom, $unwanted_array ))), "PASSWORD" => strtolower($utilisateur->unix_password));
    	$this->createMachineFile($projet->id, $variables);
    	$process = new Process(['../docker/build.sh', $projet->id]);
    	$return_code = $process->run();
        if($return_code == 0)
        {
            //Création du droit admin sur le projet
            $droit = new Droit; //Instanciation d'un objet de type droit
            $droit->id_utilisateur = $id_utilisateur; //Affectation de l'utilisateur
            $droit->id_projet = $projet->id; //Affectation du projet
            $droit->role = $constants["ROLE_ADMIN"]; //Puis on dit que c'est l'admin
            $droit->save(); //On fini par sauvegarder en bdd
        	//Redirection vers l'accueil des projets
            return redirect('/');
        }
        else
        {
            return redirect('/?erreur='.$constants["BUILD_ERROR"]);
        }
    }

    public function createMachineFile($name, $variables)
    {
    	$template = fopen("../docker/template","r");
    	$machine = fopen("../docker/".$name.".machine", "w");
    	while(! feof($template))
    	{
    	    $line = fgets($template);
    	    foreach($variables as $key => $value)
    	    {
                $line = str_replace("{{".$key."}}",$value, $line);
    	    }
    	    fwrite($machine, $line);
    	}
    	fclose($template);
    }
}
