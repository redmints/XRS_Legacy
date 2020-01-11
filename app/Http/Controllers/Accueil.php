<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class Accueil extends Controller
{
    public function getForm()
    {
        $id_utilisateur = Session::get('id_utilisateur');
        if(isset($id_utilisateur))
        {
            return view('accueil');
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
