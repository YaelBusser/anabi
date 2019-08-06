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
        <?php include('head.php');?>
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