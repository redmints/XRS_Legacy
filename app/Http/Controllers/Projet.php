<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Utilisateur;
use App\M_Projet;
use App\Droit;
use Config;

class Projet extends Controller
{
    public function getForm()
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
        //Définition de l'erreur
        $erreur = 0;
        //Récupération de l'id utilisateur
        $id_utilisateur = Session::get('id_utilisateur');
        //Si l'utilisateur est connecté
        if(isset($id_utilisateur))
        {
            //Et si l'id du projet est spécifié
            if(isset($_GET["id_projet"]) && !empty($_GET["id_projet"]))
            {
                //Récupération des infos de l'utilisateur
                $utilisateur = Utilisateur::where('id', $id_utilisateur)->first();
                //De l'id du projet
                $id_projet = $_GET["id_projet"];
                //Récupération des infos du projet en bdd
                $projet = M_Projet::where('id', $id_projet)->first();
                //Si le projet existe
                if(isset($projet))
                {
                    //On récupère les droits que l'utilisateur a sur ce projet
                    $droit = Droit::where('id_utilisateur', $id_utilisateur)->where('id_projet', $id_projet)->first();
                    //Si l'utilisateur est spécifié dans les droits du projet
                    if(isset($droit))
                    {
                        //On récupère les droits du créateur du projet
                        $droit_createur = Droit::where('id_projet', $projet->id)->where('role', $constants["ROLE_ADMIN"])->first();
                        //Puis on en déduit ses infos
                        $createur = Utilisateur::where('id', $droit_createur->id_utilisateur)->first();
                        //Redirection vers la vue projet
                        return view('projet', compact('utilisateur', 'projet', 'droit', 'createur', 'constants'));
                    }
                    else
                    {
                        //L'utilisateur n'a pas les droits sur le projet
                        $erreur = $constants["ACCESS_DENIED"];
                    }
                }
                else
                {
                    //Le projet spécifié est introuvable
                    $erreur = $constants["INVALID_PROJECT"];
                }
            }
            else
            {
                //Aucun projet n'est spécifié
                $erreur = $constants["INVALID_PROJECT"];
            }
        }
        else
        {
            //Sinon, redirection vers la page de connexion
            return redirect('login');
        }

        //On redirige l'utilisateur vers la page d'acceuil avec son erreur
        return redirect('/?erreur='.$erreur);
    }

    public function postForm()
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
    }
}
