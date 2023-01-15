<?php require "view_beginVertical.php"; ?>

<ul>
    <h1>HUB MEMBRE BDE</h1>
    <li><a href="index.php?controller=list&action=catalogue">Catalogue</a></li>
    <li><a href="index.php?controller=list&action=panier&reset=Reset">Panier</a></li>
    <li><a href="index.php?controller=set&action=add">Ajout Article</a></li>

    <?php if($_COOKIE['Role'] == "Admin") : ?>
        <li><a href="index.php?controller=affichage&action=inscrM">Ajout Membre</a></li>
    <?php endif ?>
</ul>



<?php require "view_end.php";?>


