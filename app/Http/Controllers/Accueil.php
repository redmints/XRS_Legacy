<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Utilisateur;

class Accueil extends Controller
{
    public function getForm()
    {
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

    }
}
