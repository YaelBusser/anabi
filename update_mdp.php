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
            $error = '<p style="color: red; font-family: bello;">Le mot de passe est incorrect !</p>';
        }
    }
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
                <table style="margin-left: 15%;">
                <tr>
                                <td>
                                    <img src="<?php echo $_avatar; ?>" style="
                                        width: 2vw; 
                                        height: 2vw; 
                                        border-radius: 50%; 
                                        " align="right">
                                </td>

                                <td style="
                                color: white;
                                font-size: 1.3vw;
                                ">
                                    <span style="margin-left: 1vw;">
                                        <?php echo $_SESSION['pseudo']; ?>
                                    </span>
                                </td>
                            </tr>
                        <tr>
                                <td style="color: white; font-size: 0.5vw;">
                                   <label for="mdp">Mot de passe actuel</label>
                                </td>

                                <td>
                                    <input id="mdp" type="password" name="mdpActuel" style="
                                    width: 8vw;
                                    font-size: 0.7vw;
                                    border: 1px solid rgba(0,0,0,0);
                                    color: white;
                                    margin-left: 13%;
                                    "
                                    placeholder="Mot de passe actuel"
                                    >
                                </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" name="btnMdp" style="
                                width: 5vw;
                                border: 1px solid rgba(0,0,0,0.5);
                                background-color: rgba(0,0,0,0.3);
                                color: white;
                                font-size: 0.8vw;
                                border-radius: 0.3vw 0.3vw 0.3vw 0.3vw;
                                cursor: pointer;
                                margin-left: 13%;
                                " value="Entrer">
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