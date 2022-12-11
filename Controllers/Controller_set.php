<?php
use \Models\Model;
use Utils\Article;
require_once("./Models/Model.php");
 class Controller_set extends Controller{


    public function action_add(){
        if(
            // ajouter une condition pour le role
            isset($_POST['nomP']) && ! preg_match("/^ *$/",$_POST['nomP']) &&
            isset($_POST['quantite']) && preg_match("/^[0-9]+$/",$_POST['quantite']) &&
            isset($_POST['prix']) && preg_match("/^[0-9]+\.?[0-9]*$/", $_POST['prix'])
        ){
            $info = [];
            $m = Model::getModel();
            $cle = ['nomP','quantite','prix'];
            foreach($cle as $marqueur){
                $info[$marqueur] = $_POST[$marqueur];
            }
            $m->setProduit($info);
            $data = [
                "Ajout" => true
            ];
            $this->render("add",$data);
        }
        else{
            $data = [
                "Ajout" => false
            ];
            $this->render("add",$data);
        }
    }

    public function action_inscription(){
        if(
            isset($_POST['idPer']) && ! preg_match("/^ *$/", $_POST['idPer']) &&
            isset($_POST['prenom']) && ! preg_match("/^ *$/", $_POST['prenom']) &&
            isset($_POST['nom']) && ! preg_match("/^ *$/", $_POST['nom']) &&
            isset($_POST['mdp']) && preg_match("/^.{6}.*$/", $_POST['mdp'])

        ){
            $info = [];
            $m = Model::getModel();
            $cle = ['idPer','prenom','nom','mdp'];
            foreach($cle as $marqueur){
                $info[$marqueur] = $_POST[$marqueur];
            }
            $info['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
            var_dump($info['mdp']);
            $m->setClient($info);
            $data = [
                "Role" => $m->getRole($_POST['idPer']) // accès au infos du client à ajouter
            ];
            //session à ajouter (rend sur le catalogue avec sa session)
            session_start();
            $_SESSION['id'] = $_POST['idPer'];
            $_SESSION['role'] = 'Client';
            $this->render("client",$data);
        }

        else{
            $data = [
                "Ajout" => false
            ];
            $this->render("inscription",$data);
        }

    }

    public function action_vente(){
        $m = Model::getModel();
        if(isset($_GET['Somme'])){
            $infoV = [];
            $infoV['Somme'] = $_GET['Somme'];
            if(isset($_GET['idPer'])){
                $infoV['idPer'] = $_GET['idPer'];
            }
            else{
                $infoV['idPer'] = null;
            }
            $m->setVente($infoV);
            require_once("./Utils/Article.php");
            $Ar = new Article();

            $data= [
                "Articles" => $Ar->getArticles(),
                "Panier" => $Ar->getPanier(),
                "Somme" => $Ar->getSomme(),
            ];
            $this->render("panier",$data);
        }
    }

    public function action_default(){
        $this->action_add();
    }

}


?>