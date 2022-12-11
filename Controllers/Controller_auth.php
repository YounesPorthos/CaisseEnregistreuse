<?php

use Utils\Article;
use \Models\Model;
require_once("./Models/Model.php");
require_once("Controller.php");
class Controller_auth extends Controller
{

    public function action_authentification(){
        if(isset($_POST['id']) && isset($_POST['mdp'])){
            $m = Model::getModel();
            if($m->inDatabase($_POST['id'])){
                if(password_verify($_POST['mdp'],$m->getPassword($_POST['id']))){

                    $data = [
                        "Role" => $m->getRole($_POST['id']) // accès au infos du client à ajouter
                    ];
                    //session à ajouter (rend sur l'espace client avec sa session)
                    session_start();
                    $_SESSION['id'] = $_POST['id'];
                    $_SESSION['role'] = $m->getRole($_POST['id']);
                    $this->render("client", $data); // ne rend pas sur la vue "client" juste en guise de test
                }
                else{
                    echo "Mot de passe incorrect";
                    $this->render("connexion");
                }
            }
            else{
                echo "L'identifiant n'existe pas";
                $this->render("connexion");
            }

        }
    }
    public function action_default()
    {
        $this->action_authentification();
    }
}