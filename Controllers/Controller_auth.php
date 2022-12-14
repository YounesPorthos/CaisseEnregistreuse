<?php

use Utils\Article;
use \Models\Model;
require_once("./Models/Model.php");
require_once("Controller.php");
class Controller_auth extends Controller
{

    public function action_authentification(){
        if(isset($_POST['id']) && isset($_POST['mdp'])){ // Vérifie si un identifiant et un mot de passe sont présent
            $m = Model::getModel();
            if($m->inDatabase($_POST['id'])){
                // Si l'identifiant existe dans la base on verifie ensuite si le mot de passe correspond
                if(password_verify($_POST['mdp'],$m->getPassword($_POST['id']))){
                    session_start();
                    $_SESSION['id'] = $_POST['id'];
                    $_SESSION['role'] = $m->getRole($_POST['id']);
                    if($_SESSION['role'] == "Client"){
                        $data = [
                            "Role" => $m->getRole($_POST['id'])
                            // accès au infos du client à ajouter (Rend dans des vues differents en fonction du role)
                        ];
                        $this->render("client",$data);
                    }
                    elseif($_SESSION['role'] == "Membre" || $_SESSION['role'] == "Admin"){
                        $data = [
                            "Role" => $m->getRole($_POST['id'])
                            // accès au infos du client à ajouter (Rend dans des vues differents en fonction du role)
                        ];
                        $this->render("hub",$data);
                    }
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