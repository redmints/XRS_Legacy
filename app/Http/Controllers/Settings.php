<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Session;
use App\Utilisateur;

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

                return view('settings', compact('utilisateur'));
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
    }
}
