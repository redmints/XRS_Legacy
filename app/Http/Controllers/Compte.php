<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Session;
use App\Utilisateur;


class Compte extends Controller
{

    public function getForm()
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
        //Récupération de l'id utilisateur
        $id_utilisateur = Session::get('id_utilisateur');

        if(isset($id_utilisateur))
        {
            //Récupération des infos de l'utilisateur
            $utilisateur = Utilisateur::where('id', $id_utilisateur)->first();
            //Redirection vers la vue modificationCompte
            return view('modificationCompte',compact('utilisateur', 'constants'));

        }
        else
        {
            //Sinon, redirection vers la page de connexion
            return redirect('login');

        }




    }

    public function postForm(Request $request)
    {

        //Déclaration des constantes
        $constants = Config::get('constants');
        //Récupération de l'id utilisateur
        $id_utilisateur = Session::get('id_utilisateur');
        //Récupération des infos de l'utilisateur
        $utilisateur = Utilisateur::where('id', $id_utilisateur)->first();


        $prenom = $request->input('prénom');//Prénom donné dans le formulaire
        $nom = $request->input('nom');//Nom donné dans le formulaire
        $email = $request->input('email');//Email donné dans le formulaire
        $password = $request->input('password');//Nouveau Mot de passe donné dans le formulaire
        $password_confirmation = $request->input('confPassword');//Confirmation du mot de passe donné dans le formulaire
        $img =$request->imgavatar; // Image donner dans le formulaire

        //Définition de l'erreur en tant que VALID par défaut
        $erreur = $constants["VALID"];

        //Si le prénom est bien enregistré
        if(isset($prenom))
        {
            //Si le prénom enregistré diffère du prénom actuel connu pour cet utilisateur
            if($prenom != $utilisateur->prenom)
            {
                //Affectation du prénom doné
                $utilisateur->prenom = $prenom;
                //Enregistrement en base de données
                $utilisateur->save();
            }
        }

        //Si le nom est bien enregistré
        if(isset($nom))
        {
            //Si le nom enregistré diffère du nom actuel connu pour cet utilisateur
            if($nom != $utilisateur->nom)
            {
                //Affectation du nom donné
                $utilisateur->nom =$nom;
                //Enregistrement en base de données
                $utilisateur->save();
            }
        }

        //Si l'Email est bien enregistré
        if(isset($email))
        {
            //Si l'Email enregistré diffère de l'Email actuel connu pour cet utilisateur
            if($email != $utilisateur->email)
            {
                //Affectation de l'Email
                $utilisateur->email = $email;
                //Enregistrement en base de données
                $utilisateur->save();
            }
        }

        //Si le mot de passe et sa confirmation son bien enregistrés
        if(isset($password) && isset($password_confirmation))
        {
            //Si le mot de passe donné et sa confirmation concordent
            if($password == $password_confirmation)
            {
                //Hash puis affectation du mot de passe donné$avatar
                $utilisateur->password = hash('tiger192,3', $password);
            }
            else
            {
                //Sinon, la variable erreur prend la valeur NOT_SAME_PASSWORD
                $erreur = $constants["NOT_SAME_PASSWORD"];
            }
        }

        if(isset($img)){
          // on récupère le nom de l'image
          $avatar=$request->imgavatar->getClientOriginalName();

          // Si l'image de l'avatar est differente de celle connu actuellement
          if($avatar != $utilisateur->avatar){

            // On recupère la taille du fichier
            $size = $request->imgavatar->getSize();

            // Si il n'est pas trop volumineu
            if($size <= 1000000){

              // on récupère l'extension du fichier
              $extension = $request->imgavatar->getClientOriginalExtension();

              //liste des extensions autorisé
              $extensions_autorisees=array('jpg','jpeg','gif','png');

              // Si l'extention correspond a celle autorisées
              if(in_array($extension,$extensions_autorisees)){

                // on récupère le chemin de l'image
                $path= $request->imgavatar->getRealPath();
                // On déplace l'image qui était enregistré dans un dossier temporaire vers le dossier img
                //move_uploaded_file($path, 'dist/img'.$avatar);
                $file=$request->file('imgavatar');

                $file->move('dist/img',$avatar);
                // On attribut le nom de l'img dans la bd
                $utilisateur->avatar = $avatar;
                // on enregistre
                $utilisateur->save();
              }

              else {
                $erreur = $constants["EXTENSION_ERROR"];
              }
           }
           else{

             $erreur = $constants["SIZE_ERROR"];
           }
          }
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
            //Sinon, il y a une erreur et on redirige vers la page modificationCompte
            return view('modificationCompte',compact('erreur','constants','utilisateur'));
        }





    }

}





























 ?>
