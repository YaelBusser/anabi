<?php
    session_start();
    include('bdd.php');
    $requete_theme = $bdd -> prepare('SELECT * FROM theme WHERE pseudo = ?');
    $requete_theme -> execute(array($_SESSION['pseudo']));
    $q_theme = $requete_theme -> fetch();
    if(!empty($q_theme['wallpaper']))
    {
        if(isset($_POST['wallpaper1']))
        {
            $theme = $bdd -> prepare('UPDATE theme SET pseudo = ?, wallpaper = ? WHERE pseudo = ?');
            $theme -> execute(array($_SESSION['pseudo'],'1.jpg', $_SESSION['pseudo']));
        }
        if(isset($_POST['wallpaper2']))
        {
            $theme = $bdd -> prepare('UPDATE theme SET pseudo = ?, wallpaper = ? WHERE pseudo = ?');
            $theme -> execute(array($_SESSION['pseudo'],'2.jpg', $_SESSION['pseudo']));
        }
    }
    else
    {
        if(isset($_POST['wallpaper1']))
        {
            $theme = $bdd -> prepare('INSERT INTO theme(pseudo, wallpaper) VALUES(?, ?)');
            $theme -> execute(array($_SESSION['pseudo'],'1.jpg'));
        }
        if(isset($_POST['wallpaper2']))
        {
            $theme = $bdd -> prepare('INSERT INTO theme(pseudo, wallpaper) VALUES(?, ?)');
            $theme -> execute(array($_SESSION['pseudo'],'2.jpg'));
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
    <?php include('head.php');?>
</head>
<body>
    <?php include('menuPHP.php');?>

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
        #mdp:hover
        {
            border-left: 2.3px solid rgba(0,0,0,0.2);
        }
        #profil:hover
        {
            border-left: 2.3px solid rgba(0,0,0,0.2);
        }
        #pp:hover 
        {
            border-left: 2.3px solid rgba(0,0,0,0.2);
        }
        </style>
        <h1 id="profil" style="
        color: black; 
        font-size: 1vw; 
        margin-top: -0.05vw;
        margin-left: -0.05vw;
        padding: 1vw;
        "><a href="edition_profil.php"><span style="color: white;">Modifier le Profil</span></a></h1>
        <h1 id="mdp" style="
        color: black; 
        font-size: 0.8vw; 
        margin-top: -0.65vw; 
        margin-left: -0.05vw;
        padding: 1vw; 
        "><a href="update_mdp.php"><span style="color: white;">Changer de mot de passe</span></a></h1>
        <h1 id="pp" style="
        color: black; 
        font-size: 0.8vw; 
        margin-top: -0.65vw; 
        margin-left: -0.05vw; 
        padding: 1vw; 
        "><a href="modif_avatar.php"><span style="color: white;">Changer de photo de profil</span></a></h1>
        <h1 id="theme" style="
        color: white; 
        font-size: 0.8vw; 
        margin-top: -0.65vw; 
        margin-left: -0.05vw;
        padding: 1vw; 
        border-left: 2.3px solid black;
        "><a href="modif_theme.php"><span style="color: white;">Changer de thème</span></a></h1>
    </div>
        <div style="
        width: 35%;
        margin-top: 5%;
        border: 1px solid rgba(0,0,0,0.1);
        background-color: rgba(0,0,0,0.5);
        ">
        
            <form method="post" action="" enctype="multipart/form-data">
                <div style="
                display: flex;
                ">
                    <img src="wallpaper/1.jpg" style="width: 5vw">
                    <input type="submit" name="wallpaper1">
                    <img src="wallpaper/2.jpg" style="width: 5vw">
                    <input type="submit" name="wallpaper2">
                </div>
            </form>
</body>
</html>