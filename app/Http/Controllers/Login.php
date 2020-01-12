<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilisateur;
use Session;
use Config;

class Login extends Controller
{
    public function getForm()
    {
        $constants = Config::get('constants');
        $id_utilisateur = Session::get('id_utilisateur');
        if(isset($id_utilisateur))
        {
            Session::forget('id_utilisateur');
        }
        return view('login');
    }

    public function postForm(Request $request)
    {
        $constants = Config::get('constants');
        $erreur = $constants["VALID"];
        $email = $request->input('email');
        $password = $request->input('password');

        $utilisateur = Utilisateur::where('email', $email)->first();
        if($password == $utilisateur["password"])
        {
            Session::put('id_utilisateur', $utilisateur["id"]);
            return view('accueil', compact('utilisateur', 'constants'));
        }
        else
        {
            $erreur = $constants["INVALID_PASSWORD"];
        }
        return view('login', compact('erreur', 'constants'));
    }
}
