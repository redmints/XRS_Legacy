<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Session;
use App\Utilisateur;
use App\M_Projet;
use App\Droit;

class NouveauProjet extends Controller
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
            //Redirection vers la vue accueil
            return view('nouveau-projet', compact('utilisateur', 'constants'));
        }
        else
        {
            return view('login');
        }
    }

    public function postForm(Request $request)
    {
        //Déclaration des constantes
        $constants = Config::get('constants');

        $nom = $request->input('nom');
        $type = $request->input('optionsRadios');

        if($type == "option1")
        {
            $type = $constants["TYPE_PROJET"];
        }
        else
        {
            $type = $constants["TYPE_CLASSROOM"];
        }

        $projet = new M_Projet;
        $projet->nom = $nom;
        $projet->id_port = '1';
        $projet->type = $type;
        $projet->save();

        //Récupération de l'id utilisateur
        $id_utilisateur = Session::get('id_utilisateur');

        $droit = new Droit;
        $droit->id_utilisateur = $id_utilisateur;
        $droit->id_projet = $projet->id;
        $droit->role = $constants["ROLE_ADMIN"];
        $droit->save();

        return redirect('/');
    }
}
