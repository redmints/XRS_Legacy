<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilisateur;

class Utils extends Controller
{
    public function getUtilisateurs(Request $request)
    {
        $pattern = $request->input("term");

        $utilisateurs = [];
        if ($pattern != "")
        {
            $utilisateurs = Utilisateur::where("nom", "ILIKE", "%{$pattern}%")
                                        ->orWhere("prenom", "ILIKE", "%{$pattern}%")
                                        ->orWhere("email", "ILIKE", "%{$pattern}%")
                                        ->take(100)
                                        ->get();
        }

        $utilisateursRenvoyees = [];
        foreach ($utilisateurs as $utilisateur)
        {
            $utilisateursRenvoyees[] = [
                "id" => $utilisateur->id,
                "text" => $utilisateur->nom." ".$utilisateur->prenom." (".$utilisateur->email.")"
            ];
        }

        return response()->json($utilisateursRenvoyees);
    }
}
