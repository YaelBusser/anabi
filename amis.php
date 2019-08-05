<?php
session_start();
    require('bdd.php');
    $requete_amis = $bdd -> prepare('SELECT * FROM demande_amis WHERE pseudo1 = ? AND demande = ?');
    $requete_amis -> execute(array($_GET['pseudo'], 1));
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
            $requete_search = $bdd -> prepare('SELECT * FROM membres WHERE pseudo = ? ');
            $requete_search -> execute(array($amis['pseudo2']));
            $q_exist = $requete_search -> fetch();
            echo '<tr><td><a href="profil_principal_amis.php?id='.$q_exist['id'].'&pseudo2='.$q_exist['pseudo'].'&pseudo1='.$_GET['pseudo'].'&email='.$q_exist['email'].'&jeux='.$q_exist['jeux'].'&sexe='.$q_exist['sexualite'].'&age='.$q_exist['age'].'"> -'.$amis['pseudo2'].'</a></td></tr>';
    }
    ?>
    </table>
</body>
</html>