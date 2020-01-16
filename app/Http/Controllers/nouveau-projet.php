<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class nouveau-projet extends Controller
{
    public function getForm()
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
        return view('nouveau-projet');
    }

    public function postForm()
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
    }
}
