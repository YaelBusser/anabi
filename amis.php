<?php
session_start();
    require('bdd.php');
    $requete_amis = $bdd -> prepare('SELECT * FROM demande_amis WHERE pseudo1 = ? AND demande = ?');
    $requete_amis -> execute(array($_SESSION['pseudo'], 1));
    $q_amis = $requete_amis -> fetchAll();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Anabi || Accueil</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css.css">
        <link rel="icon" type="icon" href="images/petit.png">
    </head>
<body>
<table align="center">
<tr>
    <td>
        <h1>Mes amis :</h1>
    </td>
</tr>
    <?php 
    include('menuPHP.php');
    foreach($q_amis as $amis)
    {   
            echo '<tr><td> -'.$amis['pseudo2'].'</td></tr>';
    }
    ?>
    </table>
</body>
</html>