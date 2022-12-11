<?php require_once "view_begin.php" ?>

<h1>Catalogue</h1>

<table>
    <tr>
        <th> Nom </th> <th> quantite </th> <th>prix</th>
    </tr>
    <?php foreach ($Articles as $cle => $val) : ?>
        <tr>
            <td> <a href="?prix=<?= $val['prix'] ?>&quantite=<?= $val['Quantite'] ?>&nom=<?= $val['nomP']?>&id=<?= $val['idProduit']?>"> <?= $val['nomP']?> </a></td>
            <td>
                <?= $val['Quantite'] ?>
            </td>
            <td> <?= $val['prix'] ?></td>
        </tr>
    <?php endforeach ?>
    <form>
        <input type="submit" value="Reset" name="reset">
    </form>
</table>

<ul>
    <?php foreach($Panier as $art) :?>
        <li><?= $art["nom"] . "    "?><?= $art["Compteur"] ?></li>
    <?php endforeach ?>
</ul>

<h1>SOMME</h1>
<?= $Somme ?>

<a href="../index.php?controller=set&action=vente&Somme=<?= $Somme ?>"><button>Valider</button></a>

<?php require_once "view_end.php" ?>
