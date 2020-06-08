<?php

namespace App\Http\Controllers;




class FileSystem extends Controller{

    private $port;
    private $nomProjet;
    private $utilisateur;
    private $mdpConnexion;
    private $connexion;


    public function FileSystem($dockerPort,$nomDuProjet, $user, $mdp){
        $this->port = $dockerPort;
        $this->nomProjet = $nomDuProjet;
        $this->utilisateur = $user;
        $this->mdpConnexion = base64_decode($mdp);
        $conn = ssh2_connect("localhost", $this->port );
        $this->connexion=$conn;
        ssh2_auth_password( $conn, $this->utilisateur, $this->mdpConnexion );
    }

    public function deplacer($src, $dst){

        $cmd="mv ".$src." ".$dst;

        $stream = ssh2_exec($this->connexion,$cmd);

        stream_set_blocking($stream,true);
        $stream_out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
        $output = stream_get_contents($stream_out);


    }

    public function renommer($src, $new){
        $cmd="mv ".$src." ".$new;

        $stream = ssh2_exec($this->connexion,$cmd);

        stream_set_blocking($stream,true);
        $stream_out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
        $output = stream_get_contents($stream_out);


    }

    public function nouveauFichier($nom){

        $cmd='echo " ">  '.$nom;


        $stream = ssh2_exec($this->connexion, $cmd);
        stream_set_blocking($stream,true);
        $stream_out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
        $output = stream_get_contents($stream_out);

    }

    public function supprimerFichier($nom){

        $cmd="rm ".$nom;

        $stream = ssh2_exec($this->connexion, $cmd);
        stream_set_blocking($stream,true);
        $stream_out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
        $output = stream_get_contents($stream_out);

    }

    public function nouveauDossier($nom){

        $cmd="mkdir ".$nom;


        $stream = ssh2_exec($this->connexion, $cmd);
        stream_set_blocking($stream,true);
        $stream_out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
        $output = stream_get_contents($stream_out);


    }

    public function supprimerDossier($nom){

        $cmd="rm -fr ".$nom;


        $stream = ssh2_exec($this->this->this->connexion, $cmd);
        stream_set_blocking($stream,true);
        $stream_out = ssh2_fetch_stream($stream,SSH2_STREAM_STDIO);
        $output = stream_get_contents($stream_out);

    }

    public function lireFichier($pathFichier){

        $sftp = ssh2_sftp($this->connexion);
        $stream=fopen("ssh2.sftp://$sftp".$pathFichier,"r");
        $read = fread($stream,filesize("ssh2.sftp://$sftp".$pathFichier));
        fclose($stream);

        if($read != "FALSE"){

            return $read;
        }

    }

    public function ecrireFichier($pathFichier,$data){
        $sftp = ssh2_sftp($this->connexion);
        $stream=fopen("ssh2.sftp://$sftp".$pathFichier,"w");
        $write = fwrite($stream,$data);
        fclose($stream);

    }


    public function close(){
        ssh2_disconnect($this->connexion);
    }


    public function dir2json($dirList)
    {

        $sftp = ssh2_sftp($this->connexion);
        $sftp_fd = intval($sftp);
        return ($this->convert("ssh2.sftp://$sftp_fd".$dirList));
    }



    public function convert($dir)
    {
        $a = [];
        if($handler = opendir($dir))
        {
            while (($content = readdir($handler)) !== FALSE)
            {
                if ($content != "." && $content != ".." && $content != "Thumb.db")
                {
                    if(is_file($dir."/".$content)) $a[] = $content;
                    else if(is_dir($dir."/".$content)) $a[$content] = $this->convert($dir."/".$content);
                }
            }
            closedir($handler);
        }
        return json_encode($a);
    }


}




























?>
