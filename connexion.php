<?php
session_start();
    include('bdd.php');
    if(isset($_POST['btnConnexion']))
    {
        $pseudo = $_POST['pseudo'];
        $mdp = sha1($_POST['mdp']);
        if(!empty($pseudo) AND !empty($mdp))
        {
            $requete_membres = $bdd -> prepare('SELECT pseudo, mdp FROM membres WHERE pseudo = ? AND mdp = ?');
            $requete_membres -> execute(array($pseudo, $mdp));
            $pseudo_exist = $requete_membres -> rowCount();
            if($pseudo_exist == 1)
            {
                $requete_user = $bdd -> prepare('SELECT * FROM membres WHERE pseudo = ?');
                $requete_user -> execute(array($pseudo));
                $user = $requete_user -> fetch(); 
                $_SESSION['id'] = $user['id'];
                $_SESSION['pseudo'] = $user['pseudo'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['mdp'] = $user['mdp'];
                $_SESSION['jeux'] = $user['jeux'];
                $_SESSION['sexualite'] = $user['sexualite'];
                $_SESSION['age'] = $user['age'];
                header('Location: profil.php');
            }
            else
            {
                $error = "<p style='color: red;'>Le pseudo ou le mot de passe est incorrect !</p>";
            }
        }
        else
        {
            $error = "<p style='color: red;'>Tous les champs doivent être complétés !</p>";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Anabi || Connexion</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css.css">
        <link rel="icon" type="icon" href="images/petit.png">
    </head>
<body>
    <?php

        include('menu.html')

    ?>
    <h1 align="center">Connexion</h1>
<form method="POST">
    <table align="center">
        <tr>
           <td> 
               <label for="pseudo">Votre pseudo</label>
            </td>

            <td>  
              <input name="pseudo" type="text" placeholder="Votre pseudo" id="pseudo" style='width: 10vw; heigth: 10vw; height:  1.5vw;' 
              value="<?php if(!empty($_POST['pseudo'])){echo $_POST['pseudo'];} ?>">
            </td>
        </tr>

        <tr>
            <td>
                <label for="mdp"> Votre mot de pase</label>
            </td>

            <td>
                <input name="mdp" id="mdp" type="password" placeholder="Votre Mot de Passe" style='width: 10vw; heigth: 10vw; height:  1.5vw;'>
            </td>
        </tr>
        <tr>
            <td></td>
            <td align="center"><br>
                <input name="btnConnexion" type="submit" value="Se connecter">
            </td>
        </tr>
        <tr>
            <td></td>
            <td align='center'>
                <?php if(isset($error)){echo $error;}?>
            </td>
        </tr>
    </table>
</form>
</body>
</html>