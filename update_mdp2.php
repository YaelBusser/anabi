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
    <div style="
    display: flex;
    margin-left: 30%;
    ">
    <div style="
    width: 20%;
    margin-top: 5%;
    background-color: rgba(0,0,0,0.5);
    ">
        <style>
        #profil:hover
        {
            border-left: 2.3px solid rgba(0,0,0,0.2);
        }
        #pp:hover
        {
            border-left: 2.3px solid rgba(0,0,0,0.2);
        }
        </style>
        <h1 id="profil"style="
        color: white;
        font-size: 1vw; 
        margin-top: -0.05vw;
        margin-left: -0.05vw; 
        padding: 1vw;
        "><a href="edition_profil.php"><span style="color: white;">Modifier le Profil</span></a></h1>
        <h1 style="
        color: white; 
        font-size: 0.8vw; 
        margin-top: -0.65vw; 
        margin-left: -0.05vw; 
        padding: 1vw; 
        border-left: 2.3px solid black;
        "><a href="update_mdp.php"><span style="color: white;">Changer de mot de passe</span></a></h1>
        <h1 id="pp" style="
        color: white; 
        font-size: 0.8vw; 
        margin-top: -0.65vw; 
        margin-left: -0.05vw; 
        padding: 1vw; 
        "><a href="modif_avatar.php"><span style="color: white;">Changer de photo de profil</span></a></h1>
    </div>
    <div style="
    width: 35%;
    margin-top: 5%;
    border: 1px solid rgba(0,0,0,0.1);
    background-color: rgba(0,0,0,0.5);
    ">
    <form method="POST">
    <table>
    <tr>
                                <td><img src="<?php echo $_avatar; ?>" style="
                                width: 2vw; 
                                height: 2vw; 
                                border-radius: 50%; 
                                " align="right"></td>
                                <td style="
                                color: white;
                                font-size: 1.3vw;
                                "><span style="margin-left: 1vw;"><?php echo $_SESSION['pseudo']; ?></span></td>
                            </tr>
            <tr>
                <td style="color: white; font-size: 0.5vw;" align="right">
                    <label for="mdp1">Nouveau mot de passe :</label>
                </td>
                <td>
                    <input id="mdp1" type="password" placeholder="Nouveau mot de passe" name="mdp" style="
                        width: 9vw;
                        font-size: 0.7vw;
                        border: 1px solid rgba(0,0,0,0);
                        margin-left: 13%;
                    ">
                </td>
            </tr>
            <tr>
                <td style="color: white; font-size: 0.5vw;" align="right">
                    <label for="mdp2">Confirmer le mot de passe :</label>
                </td>
                <td>
                    <input id="mdp2" type="password" placeholder="Confirmer le mot de passe" name="mdp2" style="
                        width: 9vw;
                        font-size: 0.7vw;
                        border: 1px solid rgba(0,0,0,0);
                        margin-left: 13%;
                    ">
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="z" style="
                        width: 5vw;
                        border: 1px solid rgba(102, 0, 255, 1);
                        background-color: rgb(194, 153, 255);
                        color: white;
                        font-size: 0.8vw;
                        border-radius: 0.3vw 0.3vw 0.3vw 0.3vw;
                        cursor: pointer;
                        margin-left: 13%;
                    " value="Confirmer">
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