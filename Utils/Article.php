<?php

namespace Utils;

use \Models\Model;

require_once("./Models/Model.php");
class Article
{
    private $articles;
    private $panier;
    private $somme;

    public function __construct(){
        $m = Model::getModel();
        $this->articles = $m->getProduits();
        $this->panier = [];
        $this->somme = 0;
    }

    public function getArticles(){
        return $this->articles;
    }
    public function getPanier(){
        return $this->panier;
    }

    public function getSomme(){
        return $this->somme;
    }
    public function estVide($cle){
        return $this->articles[$cle]['Quantite'] == 0;
    }

    public function panierEstVide(){ // verification si l'on souhaite enlever un produit du panier
        return empty($this->panier);
    }

    public function addArticle($nom,$cle){
        $cle -=1;
        if(! $this->estVide($cle)){
            if(! isset($this->panier[$nom])){
                $tab = [
                    "nom" => $nom,
                    "Compteur" => 1
                ];
                $this->panier[$nom] = $tab;
            }
            else {
                $this->panier[$nom]["Compteur"] += 1;
            }
            $this->articles[$cle]['Quantite'] -= 1;
            $this->somme += $this->articles[$cle]['prix'];
            return true;
        }

    }




}