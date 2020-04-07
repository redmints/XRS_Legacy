<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilisateur;
use Session;
use Config;
use Hash;

class Login extends Controller
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
            //On le déconnecte
            Session::forget('id_utilisateur');
        }
        //Puis on redirige vers la page de connexion
        return view('login');
    }

    public function postForm(Request $request)
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
        //Définition de l'erreur en tant que VALID par défaut
        $erreur = $constants["VALID"];
        $email = $request->input('email'); //Email donné dans le formulaire
        $password = $request->input('password'); //Password donné dans le formulaire

        //On récupère l'utilisateur avec son email
        $utilisateur = Utilisateur::where('email', $email)->first();
        //Si son password correspond avec celui dans la base de données
        if(hash('tiger192,3', $password) == $utilisateur["password"])
        {
            //On lui ouvre une session
            Session::put('id_utilisateur', $utilisateur["id"]);
            //Puis on redirige sur la page d'accueil
            return redirect('/');
        }
        else
        {
            //Sinon, la variable erreur prend la valeur INVALID_PASSWORD
            $erreur = $constants["INVALID_PASSWORD"];
        }
        //Redirection vers la page de connexion avec l'erreur correspondante
        return view('login', compact('erreur', 'constants'));
    }
}
