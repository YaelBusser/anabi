<?php
include('bdd.php');
session_start();
        if($_GET['id'] == $_SESSION['id'])
        {
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
    
    <?php
        include('menuPHP.php');
    ?>
    <?php
        }
    ?>
</body>
</html>