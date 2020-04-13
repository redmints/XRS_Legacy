<?php

namespace App\Http\Controllers;

use Symfony\Component\Process\Process;
use Illuminate\Http\Request;
use App\Utilisateur;
use App\M_Projet;
use DateTime;

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

    public function setKeepAlive(Request $request)
    {
        $id_projet = $request->input("id_projet");
        $projet = M_Projet::where("id", $id_projet)->first();
        $projet->touch();
    }

    public function shutdown()
    {
        $projets = M_Projet::all();
        foreach($projets as $projet)
        {
            $now = new DateTime("now");
            $keep_alive = $projet->updated_at;
            $interval = $keep_alive->diff($now);
            $minutes = ($interval->format('%i'));
            $heures = ($interval->format('%h'));
            $jours = ($interval->format('%d'));
            $mois = ($interval->format('%m'));
            $annees = ($interval->format('%y'));
            if(($minutes <= 10) && ($heures == 0) && ($jours == 0) && ($mois == 0) && ($annees == 0) && $projet->port != 0)
            {
                echo $projet->id." : Présent<br>";
            }
            else
            {
                echo $projet->id." : Absent...";
                if($projet->port != 0)
                {
                    echo " arrêt de l'instance...";
                    //Arrêt de l'instance
                    $process = new Process(['../docker/stop.sh', $projet->id]);
                    $return_code = $process->run();
                    if($return_code == 0)
                    {
                        $projet->port = 0;
                        $projet->timestamps = false;
			$projet->save();
                        echo " instance arrêtée avec succès<br>";
                    }
                    else
                    {
                        echo "Erreur lors de l'arrêt de l'instance<br>";
                    }
                }
                else
                {
                    echo " instance déjà arrêtée<br>";
                }
            }
        }
    }

    public function dir2json(Request $request)
    {
        $dir = $request->input("dir");
        $port = $request->input("port");
        $connection = \ssh2_connect('xeyrus.com', $port);
        ssh2_auth_password($connection, 'root', 'f4212b127a');

        $sftp = ssh2_sftp($connection);
        $sftp_fd = intval($sftp);

        echo convert("ssh2.sftp://".$sftp_fd.$dir);
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
    				else if(is_dir($dir."/".$content)) $a[$content] = convert($dir."/".$content);
                }
            }
            closedir($handler);
        }
        return json_encode($a);
    }
}
