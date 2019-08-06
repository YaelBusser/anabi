<?php

    include('bdd.php');
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('head.php');?>
</head>
<body>
<?php

    include('menu.php');
    echo '<p style="color: green; text-align: center;"> Félicitations '.$_SESSION['pseudo_inscription'].', votre compte a été créé avec succès !</p>'


?>
</body>
</html>