<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Session;
use App\Utilisateur;
use App\Droit;
use App\M_Projet;

class Settings extends Controller
{
    public function getForm()
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
        //Récupération de l'id utilisateur
        $id_utilisateur = Session::get('id_utilisateur');
        //Si l'utilisateur est connecté
        if(isset($id_utilisateur))
        {
            if(isset($_GET["id_projet"]) && !empty($_GET["id_projet"]))
            {
                //Récupération des infos de l'utilisateur
                $utilisateur = Utilisateur::where('id', $id_utilisateur)->first();
                $id_projet = $_GET["id_projet"];
                $projet = M_Projet::where('id', $id_projet)->first();

                $droits = Droit::where('id_projet', $projet->id)->get();
                $data = [];
                for($i = 0; $i < sizeof($droits); $i++)
                {
                    $droit = $droits[$i]; //Droits sur le projet de l'itération
                    $developpeur = Utilisateur::where('id', $droit["id_utilisateur"])->first();
                    $iteration = array(); //Déclaration du tableau de l'itération
                    $iteration["nom"] = $developpeur->nom;
                    $iteration["prenom"] = $developpeur->prenom;
                    $iteration["email"] = $developpeur->email;
                    $iteration["role"] = $droit["role"];
                    $data[$i] = $iteration;
                }
                return view('settings', compact('utilisateur', 'projet', 'data', 'constants'));
            }
            else
            {
                return redirect('/');
            }
        }
        else
        {
            //Sinon, redirection vers la page de connexion
            return view('login');
        }
    }

    public function postForm(Request $request)
    {
        //Déclaration des constantes
        $constants = Config::get('constants');

        $email = $request->input('email'); //Email donné dans le formulaire
        $utilisateur = Utilisateur::where('email', $email)->first();
        if(isset($utilisateur))
        {
            if(isset($_GET["id_projet"]) && !empty($_GET["id_projet"]))
            {
                $droit = new Droit;
                $droit->id_utilisateur = $utilisateur->id;
                $droit->id_projet = $_GET["id_projet"];

                $role = $request->input('optionsRadios');

                if($role == "option1")
                {
                    $role = $constants["ROLE_ADMIN"];
                }
                else
                {
                    $role = $constants["ROLE_DEV"];
                }

                $droit->role = $role;
                $droit->save();
                return redirect('settings?id_projet='.$_GET["id_projet"]);
            }
            else
            {
                return redirect('/');
            }
        }
        else
        {
            return redirect('/');
        }
    }
}
