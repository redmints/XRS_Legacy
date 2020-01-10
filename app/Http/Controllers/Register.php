<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Register extends Controller
{
    public function getForm()
    {
        return view('register');
    }

    public function postForm()
    {

    }
}
