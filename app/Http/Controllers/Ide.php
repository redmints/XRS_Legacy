<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Utilisateur;

class Ide extends Controller
{
    public function getForm()
    {
        $id_utilisateur = Session::get('id_utilisateur');
        if(isset($id_utilisateur))
        {
            $utilisateur = Utilisateur::where('id', $id_utilisateur)->first();
            return view('ide', compact('utilisateur'));
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
