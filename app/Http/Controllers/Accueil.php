<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Accueil extends Controller
{
    public function getForm()
    {
        return view('accueil');
    }

    public function postForm()
    {

    }
}
