<?php require "view_begin.php" ?>

<form action="index.php?controller=set&action=add" method="post" enctype="multipart/form-data">
    <input type="text" name="nomP" placeholder="Nom du produit">
    <input type="text" name="quantite" placeholder="Quantité de depart">
    <input type="text" name="prix" placeholder="Prix">
    <input type="file" name="image">
    <input type="submit" value="Ajouter le Produit">
</form>
<?php require "view_end.php"?>