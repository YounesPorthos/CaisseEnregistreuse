<?php
use \Models\Model;
require_once("./Models/Model.php");
class Controller_affichage extends Controller
{

    public function action_add(){
        if(isset($_COOKIE['Role'])) {
            if ($_COOKIE['Role'] == "Admin" || $_COOKIE['Role'] == "Membre") {
                $this->render("add");
            }
        }
        else{
            header('Location: index.php?controller=list&action=catalogue');
        }
    }

    public function action_connexion(){
        if(isset($_COOKIE['id'])){
            if($_COOKIE['Role'] == "Client"){
                header('Location: index.php?controller=list&action=catalogue');
            }
            elseif($_COOKIE['Role'] == "Admin" || $_COOKIE['Role'] == "Membre"){
                $this->render("hub");
            }
        }
        else{
            $this->render("connexion");
        }
    }

    public function action_inscr(){
        if(! isset($_COOKIE['id'])){
            $this->render("inscription");
        }
        else{
            if($_COOKIE['Role'] == "Client"){
                header('Location: index.php?controller=list&action=catalogue');
            }
            elseif($_COOKIE['Role'] == "Admin" || $_COOKIE['Role'] == "Membre"){
                $this->render("hub");
            }
        }
    }

    public function action_client(){
        if(isset($_COOKIE['id'])){

            if($_COOKIE['Role'] == "Client"){
                $m = Model::getModel();
                $data = [
                    "infoClient" => $m->getInfos($_COOKIE['id']),
                    "points" => $m->getPoints($_COOKIE['id']),
                    "Achats" => $m->getHistoriqueAchat($_COOKIE['id'])
                ];

                $this->render("client",$data);
            }
            elseif($_COOKIE['Role'] == "Admin" || $_COOKIE['Role'] == "Membre"){
                header('Location: index.php?controller=affichage&action=hub');
            }
        }
        else{
            $this->render("connexion");
        }
    }
    public function action_inscrM(){
        if(isset($_COOKIE['Role']) && $_COOKIE['Role'] == "Admin"){
            $this->render("inscriptionMembre");
        }
        else{
            if($_COOKIE['Role'] == "Client"){
                header('Location: index.php?controller=list&action=catalogue');
            }
            elseif($_COOKIE['Role'] == "Membre"){
                $this->render("hub");
            }
        }
    }
    public function action_panier(){
        if(isset($_COOKIE['Role'])) {
            if ($_COOKIE['Role'] == "Admin" || $_COOKIE['Role'] == "Membre") {
                $this->render("panier");
            }
        }
        else{
            header('Location: index.php?controller=list&action=catalogue');
        }
    }
    public function action_hub(){
        if(isset($_COOKIE['Role'])) {
            if ($_COOKIE['Role'] == "Admin" || $_COOKIE['Role'] == "Membre") {
                $this->render("hub");
            }
        }
        else{
            header('Location: index.php?controller=list&action=catalogue');
        }
    }



    public function action_default()
    {
        $this->action_catalogue();
    }
}