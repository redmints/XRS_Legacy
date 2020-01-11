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
        $email_verification = Utilisateur::where('email', $email)->first();
        if(!isset($email_verification))
        {
            if(isset($cle))
            {
                $id_utilisateur = $cle["id_utilisateur"];
                if($password == $password_confirmation)
                {
                    $utilisateur = Utilisateur::where('id', $id_utilisateur)->first();
                    $utilisateur->email = $email;
                    $utilisateur->password = $password;
                    $utilisateur->save();

                    $cle = Cle::where('valeur', $cle["valeur"])->delete();
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
        }
        else
        {
            $erreur = 3;
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
