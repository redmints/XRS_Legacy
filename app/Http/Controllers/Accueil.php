<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Utilisateur;
use Config;

class Accueil extends Controller
{
    public function getForm()
    {
        $constants = Config::get('constants');
        $id_utilisateur = Session::get('id_utilisateur');
        if(isset($id_utilisateur))
        {
            $utilisateur = Utilisateur::where('id', $id_utilisateur)->first();
            return view('accueil', compact('utilisateur'));
        }
        else
        {
            return view('login');
        }
    }

    public function postForm()
    {
        $constants = Config::get('constants');
    }
}
