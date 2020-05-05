<?php

namespace App\Http\Controllers;


class FileSystem extends Controllers{

    private $port;
    private $nomProjet;
    private $loginConnexion = "root";
    private $mdpConnexion = "f4212b127a";
    private $connexion;


    public FileSystem($dockerPort,$nomDuProjet){
        $port = $dockerPort;
        $nomProjet = $nomDuProjet;
        $connexion = ssh2_connect( "xeyrus.com", $port );
        ssh2_auth_password( $connexion, $loginConnexion, $mdpConnexion );
    }

    public deplacer($src, $dst){

        $cmd="mv ".$src." ".$dst.";echo $?";

        $stream = ssh2_exec($connexion,$cmd);

        stream_set_blocking($stream,true);
        $stream_out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
        $output = stream_get_contents($stream_out);


        commandeValide($output);


    }

    public renommer($src, $new){
        $cmd="mv ".$src." ".$new.";echo $?";

        $stream = ssh2_exec($connexion,$cmd);

        stream_set_blocking($stream,true);
        $stream_out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
        $output = stream_get_contents($stream_out);


        commandeValide($output);


    }

    public nouveauFichier($nom){

        $cmd="touch ".$nom.";echo $?";


        $stream = ssh2_exec($connection, $cmd);
        stream_set_blocking($stream,true);
        $stream_out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
        $output = stream_get_contents($stream_out);


        commandeValide($output);

    }

    public supprimerFichier($nom){

        $cmd="rm ".$nom.";echo $?";

        $stream = ssh2_exec($connection, $cmd);
        stream_set_blocking($stream,true);
        $stream_out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
        $output = stream_get_contents($stream_out);


        commandeValide($output);

    }

    public nouveauDossier($nom){

        $cmd="mkdir ".$nom.";echo $?";


        $stream = ssh2_exec($connection, $cmd);
        stream_set_blocking($stream,true);
        $stream_out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
        $output = stream_get_contents($stream_out);


        commandeValide($output);


    }

    public supprimerDossier($nom){

        $cmd="rm -fr ".$nom.";echo $?";


        $stream = ssh2_exec($connection, $cmd);
        stream_set_blocking($stream,true);
        $stream_out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
        $output = stream_get_contents($stream_out);


        commandeValide($output);

    }

    public commandeValide($cmdRetour){

        if($cmdRetour == 0){
            echo "Commande réussie";
        }
        else{
            echo "Commande incorrecte";
        }

    }

    public close(){
        ssh2_disconnect($connexion);
    }





}




























?>
