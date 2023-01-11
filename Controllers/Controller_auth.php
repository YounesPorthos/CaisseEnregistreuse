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
                    setcookie("id",$_POST['id'],time() + 3600, "/");
                    setcookie("Role",$m->getRole($_POST['id']), time() + 3600, "/");
                    if($m->getRole($_POST['id']) == "Client"){
                        $data = [
                            "Role" => $m->getRole($_POST['id'])
                            // accès au infos du client à ajouter (Rend dans des vues differents en fonction du role)
                        ];
                        header('Location: index.php?controller=affichage&action=client');
                    }
                    elseif($m->getRole($_POST['id']) == "Membre" || $m->getRole($_POST['id']) == "Admin"){
                        $data = [
                            "Role" => $m->getRole($_POST['id'])
                            // accès au infos du client à ajouter (Rend dans des vues differents en fonction du role)
                        ];
                        header('Location: index.php?controller=affichage&action=hub');
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
    public function action_deconnexion(){
        setcookie("id","", time() - 3600,"/");
        setcookie("Role","",time() - 3600, "/");
        header('Location: index.php?controller=list&action=catalogue');
    }
    public function action_default()
    {
        $this->action_authentification();
    }
}