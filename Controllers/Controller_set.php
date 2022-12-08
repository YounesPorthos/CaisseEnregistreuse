<?php 

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
            $m->setClient($info);
            $data = [
                "Ajout" => true
            ];
            //session à ajouter (rend sur le catalogue avec sa session)
            $this->render("catalogue",$data);
        }
        else{
            $data = [
                "Ajout" => false
            ];
            $this->render("inscription",$data);
        }

    }

    public function action_vente(){
        
    }

    public function action_default(){
        $this->action_add();
    }

}


?>