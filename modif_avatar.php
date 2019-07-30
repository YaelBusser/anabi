<?php
    session_start();
    include('bdd.php');
    if(isset($_POST['btn']))
    {
        if(!empty($_POST['avatar']))
        {
            header('content-type: image/png');
            $avatar = imagecreatefrompng($_FILES['avatar']['name']);
            $requete = $bdd -> prepare('INSERT INTO membres(avatar) VALUES(?)');
            $requete -> execute(array($avatar));
           
        }
        else
        {
            $error = '<p style="color: red;"> Veuillez sélectionner un avatar !</p>';
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css.css">
</head>
<body>

    <?php

        include('menuPHP.php');

    ?><br><br>
    <form method="POST">
        <table align="center">
            <tr>
                <td>
                    avatar :
                </td>

                <td>
                    <input type="file" name="avatar">
                </td>
            </tr>
            <tr>
                <td>

                </td>

                <td align="center"><br><br>

                    <input type="submit" name="btn" value="Mofidier">

                </td>
            </tr>
            <tr>
                <td>
                
                </td>

                <td>

                    <?php if(isset($error)){ echo $error; } ?>

                </td>
            </tr>
        </table>
    </form>

</body>
</html>