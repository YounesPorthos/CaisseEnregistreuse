<?php 
    namespace Models;

    use PDO;
    class Model{
        private $bd;

        private static $instance = null;

        private function __construct(){
            include "Credentials.php";
            $this->bd = new PDO($dsn, $login, $mdp);
            $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->bd->query("SET names 'utf8'");
        }

        public static function getModel()
        {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function getRole($id){
            $req = $this->bd->prepare("SELECT roleP From Personnes WHERE idPer = :id");
            $req->bindValue(":id",$id);
            $req->execute();
            $tab = $req->fetch(PDO::FETCH_NUM);
            return $tab[0];
        }

        public function setProduit($infoP){
            $req = $this->bd->prepare("INSERT INTO produits VALUES (DEFAULT,:nomP,:quantite,:prix)");
            $cle = ['nomP','quantite','prix'];
            foreach($cle as $marqueur){
                $req->bindValue(':' . $marqueur, $infoP[$marqueur]);
            }
            $req->execute();
        }

        public function setClient($infoC){
            $req = $this->bd->prepare("INSERT INTO Personnes VALUES (:idPer,:prenom,:nom,:mdp,:roleP)");
            $infoC['roleP'] = "Client";
            $cle = ['idPer','prenom','nom','mdp','roleP'];
            foreach($cle as $marqueur){
                $req->bindValue(':'.$marqueur, $infoC[$marqueur]);
            }
            $req->execute();
        }

        public function setMembre($infoM){
            $req = $this->bd->prepare("INSERT INTO Personne VALUES (:idPer,:prenom,:nom,:mdp,:roleP)");
            $infoM['roleP'] = "Membre";
            $cle = ['idPer','prenom','nom','mdp','roleP'];
            foreach($cle as $marqueur){
                $req->bindValue(':'.$marqueur, $infoM[$marqueur]);
            }
            $req->execute();
        }
        public function setVente($infoV){
            $req = $this->bd->prepare('INSERT INTO Ventes VALUES (DEFAULT,now(),:idPer,:Somme)');
            $cle = ['idPer','Somme'];

            foreach ($cle as $marqueur){
                $req->bindValue(':'.$marqueur,$infoV[$marqueur]);
            }
            $req->execute();
        }

        public function getProduits(){
            $req = $this->bd->prepare("SELECT * FROM Produits");
            $req->execute();
            $tab = $req->fetchAll(PDO::FETCH_ASSOC);
            return $tab;
        }

        public function inDatabase($id){
            $req = $this->bd->prepare("SELECT roleP From Personnes WHERE idPer = :id");
            $req->bindValue(":id",$id);
            $req->execute();
            return $req->fetch(PDO::FETCH_NUM) !== false;
        }

        public function getPassword($id){
            $req = $this->bd->prepare("SELECT mdp From Personnes WHERE idPer = :id");
            $req->bindValue(":id",$id);
            $req->execute();
            $tab = $req->fetch(PDO::FETCH_NUM);
            return $tab[0];
        }


    }


?>