<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cle;
use App\Utilisateur;
use Config;
use Hash;

class Register extends Controller
{
    public function getForm()
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
        //Redirection vers la vue register
        return view('register');
    }

    public function postForm(Request $request)
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
        //Définition de l'erreur en tant que VALID par défaut
        $erreur = $constants["VALID"];

        $cle = $request->input('cle'); //Cle donnée dans le formulaire
        $email = $request->input('email'); //Email donné dans le formulaire
        $password = $request->input('password'); //Password donné dans le formulaire
        $password_confirmation = $request->input('password_confirmation'); //Password donné dans le formulaire

        //On essaie de récupérer la clé donnée dans la base de données
        $cle = Cle::where('valeur', $cle)->first();
        //On essaie également de récupérer l'email donné
        $email_verification = Utilisateur::where('email', $email)->first();
        //Si l'email n'est pas encore enregistré
        if(!isset($email_verification))
        {
            //Si la clé est bien enregistrée
            if(isset($cle))
            {
                //Récupération de l'id utilisateur
                $id_utilisateur = $cle["id_utilisateur"];
                //Vérification des mots de passes identiques
                if($password == $password_confirmation)
                {
                    //Création du nouvel utilisateur
                    $utilisateur = Utilisateur::where('id', $id_utilisateur)->first();
                    $utilisateur->email = $email; //Affectation de l'email donné
                    $utilisateur->password = hash('tiger192,3', $password); //Hash puis affectation du password donné
                    //Enregistrement en base de données
                    $utilisateur->save();
                    //Puis effacement de la clé utilisée pour s'inscrire
                    $cle = Cle::where('valeur', $cle["valeur"])->delete();
                }
                else
                {
                    //Sinon, la variable erreur prend la valeur NOT_SAME_PASSWORD
                    $erreur = $constants["NOT_SAME_PASSWORD"];
                }
            }
            else
            {
                //Sinon, la variable erreur prend la valeur INVALID_KEY
                $erreur = $constants["INVALID_KEY"];
            }
        }
        else
        {
            //Sinon, la variable erreur prend la valeur INVALID_EMAIL
            $erreur = $constants["INVALID_EMAIL"];
        }

        if($erreur == $constants["VALID"])
        {
            //Si il n'y a pas d'erreur, on redirige vers la page de connexion
            return view('login', compact('erreur', 'constants'));
        }
        else
        {
            //Sinon, on redirige vers la page d'inscription avec l'erreur en question
            return view('register', compact('erreur', 'constants'));
        }
    }
}
