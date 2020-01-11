<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilisateur;
use Session;

class Login extends Controller
{
    public function getForm()
    {
        $id_utilisateur = Session::get('id_utilisateur');
        if(isset($id_utilisateur))
        {
            Session::forget('id_utilisateur');
        }
        return view('login');
    }

    public function postForm(Request $request)
    {
        $erreur = 0;
        $email = $request->input('email');
        $password = $request->input('password');

        $utilisateur = Utilisateur::where('email', $email)->first();
        if($password == $utilisateur["password"])
        {
            Session::put('id_utilisateur', $utilisateur["id"]);
            return view('accueil', compact('utilisateur'));
        }
        else
        {
            $erreur = 4;
        }
        return view('login', compact('erreur'));
    }
}
