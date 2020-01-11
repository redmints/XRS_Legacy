<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cle;
use App\Utilisateur;

class Register extends Controller
{
    public function getForm()
    {
        return view('register');
    }

    public function postForm(Request $request)
    {
        $erreur = 0;
        $cle = $request->input('cle');
        $email = $request->input('email');
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');

        $cle = Cle::where('valeur', $cle)->first();
        if(isset($cle))
        {
            $id_utilisateur = $cle["id_utilisateur"];
            if($password == $password_confirmation)
            {
                $utilisateur = Utilisateur::where('id', $id_utilisateur)->first();
                $utilisateur->email = $email;
                $utilisateur->password = $password;
                $utilisateur->save();
            }
            else
            {
                $erreur = 1;
            }
        }
        else
        {
            $erreur = 2;
        }
        if($erreur == 0)
        {
            return view('login', compact('erreur'));
        }
        else
        {
            return view('register', compact('erreur'));
        }
    }
}
