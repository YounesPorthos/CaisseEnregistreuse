<?php require "view_begin.php"; ?>

<ul>
    <h1>HUB MEMBRE BDE</h1>
    <li><a href="../index.php?controller=list&action=catalogue">Catalogue</a></li>
    <li><a href="../index.php?controller=list&action=panier">Panier</a></li>
    <li><a href="../index.php?controller=set&action=add">Ajout Article</a></li>
    <li><a href="../index.php?controller=set&action=inscription">Inscription</a></li>
    <?php if($Role == "Admin") : ?>
        <li><a href="Views/view_inscriptionMembre.php">Ajout Membre</a></li>
    <?php endif ?>
</ul>



<?php require "view_end.php";?>


