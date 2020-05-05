<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Session;
use App\Utilisateur;


class ModifMdpOublier extends Controller
{

    public function getForm()
    {
        //Déclaration des constantes
        $constants = Config::get('constants');

        $cle = $_GET["cle"]; //La clé de l'utilisateur spécifié en URL

        $utilisateur = Utilisateur::where('mdp_oublier', $cle)->first();

        if(isset($utilisateur))
        {
          // redirection vers la vue de modification du mdp
          return view('modifMdpOublier', compact('cle'));
        }
        else
        {
            $erreur = $constants["CLE_INVALIDE"];
            //Sinon, redirection vers la page login avec l'erreur
            return view('login',compact('erreur','constants'));

        }

    }

    public function postForm(Request $request)
    {

      //Déclaration des constantes
      $constants = Config::get('constants');





        $cle = $request->input('cle'); //La clé de l'utilisateur
        $utilisateur = Utilisateur::where('mdp_oublier', $cle)->first(); // on récupère l'utilisateur auquel correspond la clé
        $password = $request->input('password');//Nouveau Mot de passe donné dans le formulaire
        $password_confirmation = $request->input('confPassword');//Confirmation du mot de passe donné dans le formulaire
        if(isset($cle) && !empty($cle))
        {
          //Définition de l'erreur en tant que VALID par défaut
          $erreur = $constants["VALID"];
          //Si le mot de passe et sa confirmation son bien enregistrés
          if(isset($password) && isset($password_confirmation))
          {

              //Si le mot de passe donné et sa confirmation concordent
              if($password == $password_confirmation)
              {
                  //Hash puis affectation du mot de passe donné
                  $utilisateur->password = hash('tiger192,3', $password);
                  //Enregistrement en base de données
                    $utilisateur->save();
              }
              else
              {
                  //Sinon, la variable erreur prend la valeur NOT_SAME_PASSWORD
                    $erreur = $constants["NOT_SAME_PASSWORD"];
              }
          }
        }
        else{
            // si la clé fournit ne correspond a aucune en bdd
            $erreur = $constants["CLE_INVALIDE"];
          }

      //S'il n'y a pas d'erreur
      if($erreur == $constants["VALID"])
      {
          //Enregistrement en base de données
          $utilisateur->save();
          //Redirection vers la page accueil
          return redirect('/');
      }
      else
      {
          //Sinon, il y a une erreur et on redirige vers la page modifMdpOublier
          return view('modifMdpOublier',compact('erreur','constants'));
      }


  }
}
