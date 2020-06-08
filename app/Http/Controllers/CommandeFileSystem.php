<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FileSystem;

class CommandeFileSystem extends Controller{


  public function getForm(Request $request)
  {

    $action = $request->input('action'); //l'action à effectuer
    $nom = $request->input('nom'); // nom
    $new = $request->input('new'); // nouveau nom
    $src = $request->input('src'); // source
    $dst = $request->input('dst'); // destination
    $pathFichier = $request->input('pathFichier');
    $data = $request->input('data');
    $test= $request->input('test');
    $port = $request->input('port');
    $nomProjet= $request->input('nomProjet');
    $utilisateur = $request->input('utilisateur');
    $mdp = $request->input('mdp');
    $fi = new FileSystem;
    $fi->FileSystem($port,$nomProjet,$utilisateur,$mdp);


    if(!empty($action)){ // si l'action n'est pas vide et l'utilisateur pas inconnu





      if(!empty($test)){

        if($action == "testls") // testls
        {

          $fi->dir2json($test); // on appel la méthode ls


        }

      }






      if (!empty($src) && !empty($dst)) { // si on a une source et une destination

        if($action == "deplacer") // si l'action est deplacer
        {

          $fi->deplacer($src, $dst); // on appel la méthode déplacer


        }

      }

      if (!empty($src) && !empty($new)) { // si on a une source et un nouveau nom

        if($action == "renommer") // si l'action est renommer
        {

          $fi->renommer($src, $new); // on appel la fonction renommer

        }
      }

      if (!empty($nom)){ // si on a le nom

        if($action == "nouveau-fichier") // si l'action est nouveau fichier
        {

          $fi->nouveauFichier($nom); // on appel la méthode nouveau fichier

        }

        else if($action == "supprimer-fichier") // si l'action est supprimer fichier
        {

          $fi->supprimerFichier($nom); // on appel la méthode supprimer fichier

        }

        else if($action == "nouveau-dossier") // si l'action est nouveau dossier
        {

          $fi->nouveauDossier($nom); // on appel la méthode nouveau dossier

        }

        else if($action == "supprimer-dossier") // si l'action est supprimer dossier
        {

          $fi->supprimerDossier($nom); // on appel la méthode supprimer dossier

        }

      }

      if(!empty($pathFichier)){

        if(!empty($data)){

          if($action == "ecrire-fichier"){

            $fi->ecrireFichier($pathFichier, $data);

          }
        }

        if($action == "lire-fichier"){

          return $fi->lireFichier($pathFichier);

        }
      }
      //return view('ide');
  }

  }

  public function postForm(Request $request)
  {







  }


}
