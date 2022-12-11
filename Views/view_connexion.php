
<?php require "view_begin.php" ?>

    <form action="../index.php?controller=auth&action=authentification" method="post">
        <input type="text" name="id" placeholder="Identifiant">
        <input type="password" name="mdp" placeholder="Mot de Passe">
        <input type="submit">
    </form>
<?php require "view_end.php"?>