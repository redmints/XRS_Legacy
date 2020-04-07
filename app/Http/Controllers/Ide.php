<?php

namespace App\Http\Controllers;

use Symfony\Component\Process\Process;
use Illuminate\Http\Request;
use Session;
use App\Utilisateur;
use Config;
use App\M_Projet;
use App\Droit;

class Ide extends Controller
{
    public function getForm()
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
        //Définition de l'erreur
        $erreur = 0;
        //Récupération de l'id utilisateur
        $id_utilisateur = Session::get('id_utilisateur');
        //Si l'utilisateur est connecté
        if(isset($id_utilisateur))
        {
            //Récupération des infos de l'utilisateur
            $utilisateur = Utilisateur::where('id', $id_utilisateur)->first();
            //Et si l'id du projet est spécifié
            if(isset($_GET["id_projet"]) && !empty($_GET["id_projet"]))
            {
                //Récupération des infos de l'utilisateur
                $utilisateur = Utilisateur::where('id', $id_utilisateur)->first();
                //De l'id du projet
                $id_projet = $_GET["id_projet"];
                //Récupération des infos du projet en bdd
                $projet = M_Projet::where('id', $id_projet)->first();
                //Si le projet existe
                if(isset($projet))
                {
                    //On récupère les droits que l'utilisateur a sur ce projet
                    $droit = Droit::where('id_utilisateur', $id_utilisateur)->where('id_projet', $id_projet)->first();
                    //Si l'utilisateur est spécifié dans les droits du projet
                    if(isset($droit))
                    {
                        //On récupère les droits du créateur du projet
                        $droit_createur = Droit::where('id_projet', $projet->id)->where('role', $constants["ROLE_ADMIN"])->first();
                        //Puis on en déduit ses infos
                        $createur = Utilisateur::where('id', $droit_createur->id_utilisateur)->first();
                        //Si la machine est éteinte
                        if($projet->port == 0)
                        {
                            //Allocation du port à utiliser
                            $port = 0; //Port par défaut
                            for($i = 49152; $i < 65535; $i++)
                            {
                                $dbPort = M_Projet::where('port', $i)->first();
                                if(!isset($dbPort))
                                {
                                    $port = $i;
                                    break;
                                }
                            }
                            //Démarrage de l'instance
                            $process = new Process(['../docker/run.sh', $projet->id, $port]);
                            $process->run();
                            //On met à jour le port en bdd
                            $projet->port = $port;
                            $projet->save();
                        }
                        //Redirection vers la vue ide
			$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
                        return view('ide', compact('utilisateur', 'projet', 'unwanted_array'));
                    }
                    else
                    {
                        //L'utilisateur n'a pas les droits sur le projet
                        $erreur = $constants["ACCESS_DENIED"];
                    }
                }
                else
                {
                    //Le projet spécifié est introuvable
                    $erreur = $constants["INVALID_PROJECT"];
                }
            }
            else
            {
                //Aucun projet n'est spécifié
                $erreur = $constants["INVALID_PROJECT"];
            }
        }
        else
        {
            //Sinon, on redirige vers la page de connexion
            return view('login');
        }
        //On redirige l'utilisateur vers la page d'acceuil avec son erreur
        return redirect('/?erreur='.$erreur);
    }

    public function postForm()
    {
        //Déclaration des constantes
        $constants = Config::get('constants');
    }
}
