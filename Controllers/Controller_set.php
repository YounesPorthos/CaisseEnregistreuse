<?php
use \Models\Model;
use Utils\Article;
require_once("./Models/Model.php");
require_once("./Utils/Article.php");

 class Controller_set extends Controller{


    public function action_add(){
// verifie les conditions d'ajout
        if(isset($_COOKIE['Role'])) {
            if ($_COOKIE['Role'] == "Admin" || $_COOKIE['Role'] == "Membre") {
                if (
                    // ajouter une condition pour le role
                    isset($_POST['nomP']) && !preg_match("/^ *$/", $_POST['nomP']) &&
                    isset($_POST['quantite']) && preg_match("/^[0-9]+$/", $_POST['quantite']) &&
                    isset($_POST['prix']) && preg_match("/^[0-9]+\.?[0-9]*$/", $_POST['prix']) &&
                    isset($_FILES['image']) && preg_match("/^image/",$_FILES['image']['type'])

                ) {
                    // Ajout de l'image
                    $dir = "Content/image";
                    $tmp_name = $_FILES["image"]['tmp_name'];
                    $nom = basename($_FILES["image"]['name']);
                    $chemin = "$dir/$nom";
                    move_uploaded_file($tmp_name, $chemin);

                    $info = [];
                    $m = Model::getModel();
                    $cle = ['nomP', 'quantite', 'prix'];
                    foreach ($cle as $marqueur) {
                        $info[$marqueur] = $_POST[$marqueur];
                    }
                    $info['chemin'] = $chemin;
                    $m->setProduit($info);
                    $data = [
                        "Ajout" => true
                    ];
                    $this->render("add", $data);
                } else {
                    $data = [
                        "Ajout" => false
                    ];
                    $this->render("add", $data);
                }
            }
            else{
                header('Location: index.php?controller=list&action=catalogue');
            }
        }

    }

    public function action_inscription(){
        if(! isset($_COOKIE['id'])){
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
                setcookie("id",$_POST['idU'],time() + 3600, "/");
                setcookie("Role",$m->getRole($_POST['idU']), time() + 3600, "/");
                header('Location: index.php?controller=list&action=catalogue');

            }

            else{
                $data = [
                    "Ajout" => false
                ];
                $this->render("inscription",$data);
            }

        }

    }

    public function action_inscriptionMembre(){
        if(isset($_COOKIE['Role']) && $_COOKIE['Role'] == "Admin"){
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
        session_start();
        $m = Model::getModel();
        if(isset($_GET['Somme'])){
            $infoV = [];
            $infoV['Somme'] = $_GET['Somme'];
            // si nous avons un idClient on l'ajoute dans les infos de vente sinon on met "null"
            if(isset($_GET['idCl'])){
                $infoV['idU'] = $_GET['idCl'];
            }
            $tabArticle = $_SESSION['Articles']->getPanier();
            $somme = 0;
            foreach ($tabArticle as $artPan){
                $m->updateQuantite($artPan['Compteur'],$artPan['id']);
                $somme += $artPan['Compteur'];
            }
            $infoV['Qte'] = $somme;
            // ajout de la vente dans la base de données
            $m->setVente($infoV);


            header('Location: ./index.php?controller=list&action=panier&reset=Reset');

        }
    }

    public function action_default(){
        $this->action_add();
    }

}


?>