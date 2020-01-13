<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Utilisateur;
use App\Droit;
use App\Projet;
use Config;

class Accueil extends Controller
{
    public function getForm()
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
        //Récupération de l'id utilisateur
        $id_utilisateur = Session::get('id_utilisateur');
        //Si l'utilisateur est connecté, on récupère les infos de ses projets
        if(isset($id_utilisateur))
        {
            //Récupération des infos de l'utilisateur
            $utilisateur = Utilisateur::where('id', $id_utilisateur)->first();
            //Récupération des infos concernant ses droits
            $droits = Droit::where('id_utilisateur', $id_utilisateur)->get();
            //Initialisation du tableau de retour de valeurs
            $data = [];
            //Pour chaque projet dans lequel il joue un rôle, on récupère les infos
            for($i = 0; $i < sizeof($droits); $i++)
            {
                //Préparation des variables
                $droit = $droits[$i]; //Droits sur le projet de l'itération
                //Récupération des infos du projet de l'itération
                $projet = Projet::where('id', $droits[$i]["id_projet"])->first();
                //Puis récupération des droits du créateur pour avoir son id
                $droit_createur = Droit::where('id_projet', $projet["id"])->where('role', '1')->first();
                //Pour enfin finir par avoir les infos du créateur
                $createur = Utilisateur::where('id', $droit_createur["id_utilisateur"])->first();

                //Affectation dans le tableau final
                $iteration = array(); //Déclaration du tableau de l'itération
                $iteration["id"] = $projet["id"]; //Id du projet
                $iteration["nom"] = $projet["nom"]; //Nom du projet
                $iteration["role"] = $droit["role"]; //Rôle que l'on joue
                $iteration["createur"] = $createur["prenom"]." ".$createur["nom"]; //Nom du créateur
                $data[$i] = $iteration; //Ajout au tableau de retour
            }
            //Redirection vers la vue accueil
            return view('accueil', compact('utilisateur', 'data'));
        }
        else
        {
            //Sinon, on redirige vers la page de connexion
            return view('login');
        }
    }

    public function postForm()
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
    }
}
