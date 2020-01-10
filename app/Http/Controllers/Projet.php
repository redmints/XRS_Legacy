<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Projet extends Controller
{
    public function getForm()
    {
        return view('projet');
    }

    public function postForm()
    {

    }
}
