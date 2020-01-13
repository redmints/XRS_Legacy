<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Utilisateur;
use Config;

class Ide extends Controller
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
            //Redirection vers la vue ide
            return view('ide', compact('utilisateur'));
        }
        else
        {
            //Sinon, on redirige vers la page de connexion
            return view('login');
        }
    }

    public function postForm()
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
    }
}
