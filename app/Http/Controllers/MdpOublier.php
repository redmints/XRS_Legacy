<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilisateur;
use Session;
use Config;
use Hash;
use Illuminate\Support\Facades\Mail;

class MdpOublier extends Controller
{


    public function getForm()
    {
      //Déclaration des constantes
      $constants = Config::get('constants');
      //Définition de l'erreur en tant que VALID par défaut
      $erreur = $constants["VALID"];
      return view('mdpOublier',compact('erreur','constants'));

    }

      public function postForm(Request $request)
      {
        //Déclaration des constantes
        $constants = Config::get('constants');
        //Définition de l'erreur en tant que VALID par défaut
        $erreur = $constants["VALID"];
        $email = $request->input('email'); //Email donné dans le formulaire

        //On récupère l'utilisateur avec son email
        $utilisateur = Utilisateur::where('email', $email)->first();

        if(isset($utilisateur)){
          // génération d'une cle
          $cle='';
          $longueur=20;
          $listeCar = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $max = mb_strlen($listeCar, '8bit') - 1;
          for ($i = 0; $i < $longueur; ++$i) {
              $cle .= $listeCar[random_int(0, $max)];
          }
          // on affecte cette clé a l'utilisateur en bd
          $utilisateur->mdp_oublier=$cle;

          // envoie la view mail par mail a l'utilisateur elle contient un lien avec la clé générer
          Mail::send('mail', ['cle' => $cle, 'email' => $email], function ($message) use ($email)
          {

            $message->from('xeyrus@gmail.com', 'Admin');

            $message->to($email);


            });



        }
        else {
          // si le mail est inconnu
          $erreur = $constants["UNKNOWN_MAIL"];
        }

        //S'il n'y a pas d'erreur
        if($erreur == $constants["VALID"])
        {
            //Enregistrement en base de données
            $utilisateur->save();
            //Redirection vers la page login
            return view('login',compact('erreur','constants'));
        }
        else
        {
            //Sinon, il y a une erreur et on redirige vers la meme page avec l'erreur
            return view('mdpOublier',compact('erreur','constants'));
        }
      }


}
