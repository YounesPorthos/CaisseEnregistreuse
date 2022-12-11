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
            if(! isset($_SESSION['Articles']) or isset($_GET['reset'])){
                $_SESSION['Articles'] = new Article();
            }

            $tab = $_SESSION['Articles']->getArticles();

            if(isset($_GET['nom'])){
                if(! $_SESSION['Articles']->addArticle($_GET['nom'],$_GET['id'])){
                    echo "<h1> Invalide </h1>";
                }
            }

            $data= [
                "Articles" => $tab,
                "Panier" => $_SESSION['Articles']->getPanier(),
                "Somme" => $_SESSION['Articles']->getSomme(),
                ];

            $this->render("panier",$data);
        }
        public function action_default(){
            $this->action_panier();
        }
    }



?>