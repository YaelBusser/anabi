<?php
    session_start();
    include('bdd.php');
    if(!empty($_POST['Btnminiature']))
    {
        $nom_miniature = strtolower($_FILES['miniature']['name']);
        $chemin_temp = $_FILES['miniature']['tmp_name'];
        $chemin_miniature = 'miniatures';
        $extension = array('png','jpg','jpeg','gif');
        $size = 2097152;
        if($_FILES['miniature']['size'] < $size)
        {
            if(!empty($chemin_temp))
            {
                $img = explode('.', $nom_miniature);
                $extension_miniature = $img[1];
                $nom_miniature = $_SESSION['id'];
                if(in_array($extension_miniature, $extension))
                {
                    $array_mime = array('image/png','image/jpeg','image/x-icon','image/gif');
                    $mime_test = mime_content_type($chemin_temp);
                    if(in_array($mime_test, $array_mime))
                    {
                        move_uploaded_file($chemin_temp, ''.$chemin_miniature.'/'.$nom_miniature.'.'.$extension_miniature.'');
                        $requete_miniature = $bdd -> prepare('UPDATE membres SET miniature = ? WHERE id = ?');
                        $requete_miniature -> execute(array(''.$nom_miniature.'.'.$extension_miniature.'',$_SESSION['id']));
                    }
                    else
                    {
                        echo 'Erreur mime ! ';
                    }
                }
                else
                {
                    echo 'Veuillez choisir une couverture au format png, jpg, jpeg ou gif !';
                }
                
            }
        }
        else
        {
            echo 'Votre photo de profil ne doit pas dépasser les 2 Mo !';
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
        <h1 id="pp" style="
        color: black; 
        font-size: 0.8vw; 
        margin-top: -0.65vw; 
        margin-left: -0.05vw; 
        padding: 1vw; 
        border-left: 2.3px solid black;
        "><a href="modif_avatar.php"><span style="color: white;">Changer de photo de couverture</span></a></h1>
    </div>
        <div style="
        width: 35%;
        margin-top: 5%;
        border: 1px solid rgba(0,0,0,0.1);
        background-color: rgba(0,0,0,0.5);
        ">
            <form method="post" action="" enctype="multipart/form-data">
                <input type="file" name="miniature">
                <input type="submit" name="Btnminiature">
            </form>
</body>
</html>