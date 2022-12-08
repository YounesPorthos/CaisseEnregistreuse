<?php require "view_begin.php" ?>

<form action="index.php?controller=set&action=add" method="post">
    <input type="text" name="nomP" placeholder="Nom du produit">
    <input type="text" name="quantite" placeholder="Quantité de depart">0
    <input type="text" name="prix" placeholder="Prix">
    <input type="submit">
</form>
<p> <?= $Ajout === true ? "Ajout reussi" : "Ajout echoué" ?> </p>
<?php require "view_end.php"?>