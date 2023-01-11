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
            $req = $this->bd->prepare("SELECT roleP From Utilisateur WHERE idU = :id");
            $req->bindValue(":id",$id);
            $req->execute();
            $tab = $req->fetch(PDO::FETCH_NUM);
            return $tab[0];
        }

        public function setProduit($infoP){
            $req = $this->bd->prepare("INSERT INTO produits (idProduit,nomP,quantite,prix,image)VALUES (DEFAULT,:nomP,:quantite,:prix,:chemin)");
            $cle = ['nomP','quantite','prix','chemin'];
            foreach($cle as $marqueur){
                $req->bindValue(':' . $marqueur, $infoP[$marqueur]);
            }
            $req->execute();
        }

        public function setClient($infoC){
            $req = $this->bd->prepare("INSERT INTO Utilisateur VALUES (:idU,:prenom,:nom,:mdp,:roleP)");
            $infoC['roleP'] = "Client";
            $cle = ['idU','prenom','nom','mdp','roleP'];
            foreach($cle as $marqueur){
                $req->bindValue(':'.$marqueur, $infoC[$marqueur]);
            }
            $req->execute();
        }

        public function getInfos($id){
            $req = $this->bd->prepare("SELECT * From Utilisateur WHERE idU = :id");
            $req->bindValue(":id",$id);
            $req->execute();
            $tab = $req->fetch(PDO::FETCH_ASSOC);
            return $tab;
        }
        public function setMembre($infoM){
            $req = $this->bd->prepare("INSERT INTO Utilisateur VALUES (:idU,:prenom,:nom,:mdp,:roleP)");
            $infoM['roleP'] = "Membre";
            $cle = ['idU','prenom','nom','mdp','roleP'];
            foreach($cle as $marqueur){
                $req->bindValue(':'.$marqueur, $infoM[$marqueur]);
            }
            $req->execute();
        }
        public function setVente($infoV){
            $req = $this->bd->prepare('INSERT INTO Ventes VALUES (DEFAULT,now(),:idU,:Somme,:quantite)');
            $cle = ['idU','Somme'];
            if($infoV['idU'] == -1){
                $req->bindValue(":idU",NULL);
            }
            else{
                $req->bindValue(":idU",$infoV['idU']);
            }
            $req->bindValue(":Somme",$infoV['Somme']);
            $req->bindValue(":quantite",$infoV['Qte']);
            $req->execute();
        }

        public function getProduits(){
            $req = $this->bd->prepare("SELECT * FROM Produits");
            $req->execute();
            $tab = $req->fetchAll(PDO::FETCH_ASSOC);
            return $tab;
        }

        public function inDatabase($id){
            $req = $this->bd->prepare("SELECT roleP From Utilisateur WHERE idU = :id");
            $req->bindValue(":id",$id);
            $req->execute();
            return $req->fetch(PDO::FETCH_NUM) !== false;
        }

        public function getPassword($id){
            $req = $this->bd->prepare("SELECT mdp From Utilisateur WHERE idU = :id");
            $req->bindValue(":id",$id);
            $req->execute();
            $tab = $req->fetch(PDO::FETCH_NUM);
            return $tab[0];
        }

        public function updateQuantite($newQuant,$id){
            $req = $this->bd->prepare("UPDATE Produits SET quantite = quantite - :newQuant WHERE idProduit = :id");
            $req->bindValue(":newQuant",$newQuant);
            $req->bindValue(":id",$id);
            $req->execute();
        }

        public function getInfoVentesMensuel(){
            $reqAnn = $this->bd->prepare("SELECT YEAR(now())");
            $reqAnn->execute();
            $annee = $reqAnn->fetch(PDO::FETCH_NUM);

            $reqMois = $this->bd->prepare("SELECT MONTH(now())");
            $reqMois->execute();
            $mois = $reqAnn->fetch(PDO::FETCH_NUM);

            $req = $this->bd->prepare("SELECT prix,DateV,qte FROM Ventes WHERE DateV REGEXP '^$annee[0]-$mois[0]'");
            $req->execute();

            return $req->fetchAll(PDO::FETCH_ASSOC);



        }

        public function updateProduit($infoP,$id){ // à utiliser
            $req = $this->bd->prepare("UPDATE produits SET nomP = :nomP, quantite = :quantite, prix = :prix WHERE idProduit = :id");
            $cle = ['nomP','quantite','prix'];
            foreach ($cle as $marqueur){
                $req->bindValue(':'.$marqueur,$infoP[$marqueur]);
            }
            $req->bindValue(':id',$id);
            $req->execute();

        }


    }


?>