<?php

use Utils\Article;
use \Models\Model;
require_once("./Models/Model.php");
require_once("Controller.php");
    class Controller_list extends Controller{

        public function action_catalogue(){
            $m = Model::getModel();
            $data = [
                "title" => "Catalogue",
                "catalogue" => $m->getProduits()
            ];
            $this->render('catalogue',$data);
        }
        public function action_panier(){
            require_once("./Utils/Article.php");
            session_start();
            //Si il n'y a pas une instance d'article ou qu'on ait appuyé sur le bouton reset on créer une instance d'article stocké dans une session
            if(! isset($_SESSION['Articles']) or isset($_GET['reset'])){
                $_SESSION['Articles'] = new Article();
            }

            $tab = $_SESSION['Articles']->getArticles();

            if(isset($_GET['nom'])){
                // si un article a été selectionné on vérifie si il est possible de l'ajouter dans le panier
                if(! $_SESSION['Articles']->addArticle($_GET['nom'],$_GET['id'])){
                    echo "<h1> Invalide </h1>";
                }
            }
            // si l'identifiant entrée est valide on l'ajoute dans une session
            if(isset($_GET['idCl'])){
                $m = Model::getModel();
                if($m->inDatabase($_GET['idCl'])){
                    echo "<p> EXISTE </p>";
                    $_SESSION['idCl'] = $_GET['idCl'];
                }
                else{
                    $_SESSION['idCl'] = null;
                }
            }
            else{
                $_SESSION['idCl'] = null;
            }
            // stocke dans les données les valeurs mise à jour
            $data= [
                "Articles" => $tab,
                "Panier" => $_SESSION['Articles']->getPanier(),
                "Somme" => $_SESSION['Articles']->getSomme(),
                "idClient" => $_SESSION['idCl']
                ];

            $this->render("panier",$data);
        }
        public function action_default(){
            $this->action_panier();
        }
    }



?>