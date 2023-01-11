<?php require "view_begin.php"; // affichage provisoire à changer plus tard?>


    <link rel="stylesheet" href="Content/style/catalogue.css">
<div id="Catalogue">
<?php foreach($catalogue as $val) : ?>

    <div class="Boite" style="background: url( <?= $val['image']?>) no-repeat center center; background-size: contain;">
        <div class="infoBoite">
            <span class="nomA"><?= $val['nomP']?></span>
            <span class="prix"><?= $val['prix']?>€</span>
        </div>
    </div>

<?php endforeach ?>
</div>
<?php require "view_end.php"?>