<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cle;
use App\Utilisateur;
use Config;

class Register extends Controller
{
    public function getForm()
    {
        $constants = Config::get('constants');
        return view('register');
    }

    public function postForm(Request $request)
    {
        $constants = Config::get('constants');
        $erreur = $constants["VALID"];
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
                    $erreur = $constants["NOT_SAME_PASSWORD"];
                }
            }
            else
            {
                $erreur = $constants["INVALID_KEY"];
            }
        }
        else
        {
            $erreur = $constants["INVALID_EMAIL"];
        }

        if($erreur == $constants["VALID"])
        {
            return view('login', compact('erreur', 'constants'));
        }
        else
        {
            return view('register', compact('erreur', 'constants'));
        }
    }
}
