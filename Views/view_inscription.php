<?php require "view_begin.php" ?>

    <form action="../index.php?controller=set&action=inscription" method="post">
        <input type="text" name="idU" placeholder="Identifiant">
        <input type="text" name="nom" placeholder="nom">
        <input type="text" name="prenom" placeholder="prenom">
        <input type="password" name="mdp" placeholder="Mot de Passe">
        <input type="submit">
    </form>
<?php require "view_end.php"?>