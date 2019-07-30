<?php
    session_start();
    include('bdd.php');
    if(isset($_POST['btnMdp']))
    {
        $requete = $bdd -> prepare('SELECT * FROM membres WHERE id = ?');
        $requete -> execute(array($_SESSION['id']));
        $user = $requete -> fetch();
        if($user['mdp'] == sha1($_POST['mdpActuel']))
        {
            $_SESSION['ok'] = 'ok';
            header('Location: update_mdp2.php');
        }
        else
        {
            $error = '<p style="color: red">Le mot de passe est incorrect !</p>';
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css.css">
    <title><?php echo $_SESSION['pseudo']; ?></title>
</head>
<body>
    <?php

    include('menuPHP.php');

    ?>
    <h1 class="centre">Changer de mot de passe</h1>
  <form method="POST">
      <table align="center">
            <tr>
                    <td>
                        Entrez votre mot de passe actuel
                    </td>

                    <td>
                        <input type="password" name="mdpActuel" placeholder="">
                    </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="btnMdp">
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?php if(isset($error)){echo $error;} ?>
                </td>
            </tr>
    </table>
</form>
</body>
</html>