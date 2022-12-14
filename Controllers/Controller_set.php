<?php
use \Models\Model;
use Utils\Article;
require_once("./Models/Model.php");
 class Controller_set extends Controller{


    public function action_add(){
// verifie les conditions d'ajout

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
            isset($_POST['idU']) && ! preg_match("/^ *$/", $_POST['idU']) &&
            isset($_POST['prenom']) && ! preg_match("/^ *$/", $_POST['prenom']) &&
            isset($_POST['nom']) && ! preg_match("/^ *$/", $_POST['nom']) &&
            isset($_POST['mdp']) && preg_match("/^.{6}.*$/", $_POST['mdp'])

        ){
            $info = [];
            $m = Model::getModel();
            $cle = ['idU','prenom','nom','mdp'];
            foreach($cle as $marqueur){
                $info[$marqueur] = $_POST[$marqueur];
            }
            $info['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT); // crypte le mot de passe
            var_dump($info['mdp']);
            $m->setClient($info);
            $data = [
                "Role" => $m->getRole($_POST['idU']) // accès au infos du client à ajouter
            ];
            //session à ajouter (rend sur le catalogue avec sa session)
            session_start();
            $_SESSION['id'] = $_POST['idU'];
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

    public function action_inscriptionMembre(){
        if(isset($_SESSION['Role']) && $_SESSION['Role'] == "Admin"){
            if(
                isset($_POST['idU']) && ! preg_match("/^ *$/", $_POST['idU']) &&
                isset($_POST['prenom']) && ! preg_match("/^ *$/", $_POST['prenom']) &&
                isset($_POST['nom']) && ! preg_match("/^ *$/", $_POST['nom']) &&
                isset($_POST['mdp']) && preg_match("/^.{6}.*$/", $_POST['mdp'])

            ){
                $info = [];
                $m = Model::getModel();
                $cle = ['idU','prenom','nom','mdp'];
                foreach($cle as $marqueur){
                    $info[$marqueur] = $_POST[$marqueur];
                }
                $info['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT); // crypte le mot de passe
                var_dump($info['mdp']);
                $m->setMembre($info);

                echo "<p style='color: green'>Ajout reussi</p>";
                $this->render("hub");
            }
            else{
                echo "<p style='color: red'>Echec Ajout</p>";
                $this->render("hub");
            }
        }
        else{
            echo "<script> alert('Pas admin')</script>";
        }
    }

    public function action_vente(){
        $m = Model::getModel();
        if(isset($_GET['Somme'])){
            $infoV = [];
            $infoV['Somme'] = $_GET['Somme'];
            // si nous avons un idClient on l'ajoute dans les infos de vente sinon on met "null"
            if(isset($_GET['idCl'])){
                $infoV['idU'] = $_GET['idCl'];
            }

            // ajout de la vente dans la base de données
            $m->setVente($infoV);

            // creation d'une instance de d'article
            //require_once("./Utils/Article.php");
            /* $Ar = new Article();

            $data= [
                "Articles" => $Ar->getArticles(),
                "Panier" => $Ar->getPanier(),
                "Somme" => $Ar->getSomme(),
            ]; */
            header('Location: ./index.php?controller=list&action=panier&reset=Reset');

        }
    }

    public function action_default(){
        $this->action_add();
    }

}


?>