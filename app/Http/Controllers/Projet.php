<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Utilisateur;
use App\M_Projet;
use App\Droit;
use Config;

class Projet extends Controller
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
            //Récupération des infos de l'utilisateur
            $utilisateur = Utilisateur::where('id', $id_utilisateur)->first();

            if(isset($_GET["id_projet"]) && !empty($_GET["id_projet"]))
            {
                $id_projet = $_GET["id_projet"];
                $projet = M_Projet::where('id', $id_projet)->first();
                $droit = Droit::where('id_utilisateur', $id_utilisateur)->where('id_projet', $id_projet)->first();
                $droit_createur = Droit::where('id_projet', $projet->id)->where('role', $constants["ROLE_ADMIN"])->first();
                $createur = Utilisateur::where('id', $droit_createur->id_utilisateur)->first();
                //Redirection vers la vue projet
                return view('projet', compact('utilisateur', 'projet', 'droit', 'createur', 'constants'));
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

    public function postForm()
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
    }
}
