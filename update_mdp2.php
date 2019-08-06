<?php
    session_start();
    include('bdd.php');
    if(isset($_POST['z']))
    {
        if(!empty($_POST['mdp'] AND !empty($_POST['mdp2'])))
        {
            if($_POST['mdp'] == $_POST['mdp2'])
            {
                $requete = $bdd -> prepare('UPDATE membres SET mdp = ? WHERE id = ?');
                $requete -> execute(array(sha1($_POST['mdp']), $_SESSION['id']));
                $error2 = '<p style="color: green">Votre mot de passe a bien été changé !</p>';
            }
            else
            {
                $error2 = '<p style="color: red">Vos mots de passe ne correspondent pas !</p>';
            }
        }
        else 
        {
            $error2 = '<p style="color: red">Veuillez remplir tous les champs !</p>';
        }
    }
    if(isset($_SESSION['ok']))
    {
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('head.php');?>
    <title><?php echo $_SESSION['pseudo']; ?></title>
</head>
<body>
    <?php

    include('menuPHP.php');

    ?>
    <form method="POST"><br><br>
    <table align="center">
            <tr>
                <td>
                    Entrez le nouveau mot de passe :
                </td>
                <td>
                    <input type="password" name="mdp">
                </td>
            </tr>
            <tr>
                <td>
                    Confirmez le mot de passe :
                </td>
                <td>
                    <input type="password" name="mdp2">
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="z">
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php if(isset($error2)){ echo $error2; } ?></td>
            </tr>

    </table>
</form>
<?php 
    }
    else
    {
        echo '<h1 style="color: red; text-align: center;">AHAHAHAH petit malin ;)</h1>';
    }
?>
</body>
</html>