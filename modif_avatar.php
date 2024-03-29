<?php
    session_start();
    include('bdd.php');
    if(!empty($_POST['send']))
    {
        $nom_avatar = strtolower($_FILES['avatar']['name']);
        $chemin_temp = $_FILES['avatar']['tmp_name'];
        $chemin_avatar = 'avatars';
        $extension = array('png','jpg','jpeg','gif');
        $size = 2097152;
        if($_FILES['avatar']['size'] < $size)
        {
            if(!empty($chemin_temp))
            {
                $img = explode('.', $nom_avatar);
                $extension_avatar = $img[1];
                $nom_avatar = $_SESSION['id'];
                if(in_array($extension_avatar, $extension))
                {
                    $array_mime = array('image/png','image/jpeg','image/x-icon','image/gif');
                    $mime_test = mime_content_type($chemin_temp);
                    if(in_array($mime_test, $array_mime))
                    {
                        move_uploaded_file($chemin_temp, ''.$chemin_avatar.'/'.$nom_avatar.'.'.$extension_avatar.'');
                        $requete_avatar = $bdd -> prepare('UPDATE membres SET avatar = ? WHERE id = ?');
                        $requete_avatar -> execute(array(''.$nom_avatar.'.'.$extension_avatar.'',$_SESSION['id']));
                    }
                    else
                    {
                        echo 'Erreur mime ! ';
                    }
                }
                else
                {
                    echo 'Veuillez choisir un avatar au format png, jpg, jpeg ou gif !';
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
        border-left: 2.3px solid black;
        "><a href="modif_avatar.php"><span style="color: white;">Changer de photo de profil</span></a></h1>
        <h1 id="pc" style="
        color: white; 
        font-size: 0.8vw; 
        margin-top: -0.65vw; 
        margin-left: -0.05vw;
        padding: 1vw; 
        "><a href="modif_miniature.php"><span style="color: white;">Changer de Photo de couverture</span></a></h1>
    </div>
        <div style="
        width: 35%;
        margin-top: 5%;
        border: 1px solid rgba(0,0,0,0.1);
        background-color: rgba(0,0,0,0.5);
        ">
        <img src="<?php echo $_avatar ?>" style="
        width: 7vw;
        height: 7vw;
        border-radius: 50%;
        margin-left: 30%;
        ">
            <form method="post" action="" enctype="multipart/form-data">
                <div style="
                display: flex;
                flex-direction: column;
                ">
                    <input type="file" name="avatar" style="
                        width: 15vw;
                        border: 1px solid rgba(0,0,0,0.5);
                        background-color: rgba(0,0,0,0.3);
                        color: white;
                        font-size: 0.8vw;
                        border-radius: 0.3vw 0.3vw 0.3vw 0.3vw;
                        cursor: pointer;
                        margin-left: 15%;
                    ">
                    <input type="submit" name="send" value="Changer" style="
                        width: 5vw;
                        margin-top: 5%;
                        margin-bottom: 5%;
                        border: 1px solid rgba(0,0,0,0.5);
                        background-color: rgba(0,0,0,0.3);
                        color: white;
                        font-size: 0.8vw;
                        border-radius: 0.3vw 0.3vw 0.3vw 0.3vw;
                        cursor: pointer;
                        margin-left: 34%;
                    ">
                </div>
            </form>
</body>
</html>