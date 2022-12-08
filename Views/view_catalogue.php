<?php require "view_begin.php"; // affichage provisoire à changer plus tard?>

<h1>CATALOGUE</h1>

<table>
    <tr>
        <th> Nom </th> <th> quantite </th> <th>prix</th>
    </tr>
<?php foreach($catalogue as $val) : ?>

    <tr>
        <td> <?= $val['nomP']?></td> 
        <td> <?= $val['Quantite'] ?></td> 
        <td> <?= $val['prix'] ?></td>
    </tr>



<?php endforeach ?>

<?php require "view_end.php"?>