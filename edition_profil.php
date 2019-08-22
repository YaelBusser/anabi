<?php
    session_start();
    include('bdd.php');
    if(isset($_POST['edition']))
    {
        $requete_pseudo = $bdd -> prepare('SELECT pseudo FROM membres WHERE pseudo = ?');
        $requete_pseudo -> execute(array($_POST['pseudo']));
        $pseudo_exist = $requete_pseudo -> rowCount();
        if($pseudo_exist == 0 || $_POST['pseudo'] == $_SESSION['pseudo'])
        {
            $requete_email = $bdd -> prepare('SELECT email FROM membres WHERE email = ?');
            $requete_email -> execute(array($_POST['email']));
            $email_exist = $requete_email -> rowCount();
            if($email_exist == 0 || $_POST['email'] == $_SESSION['email'])
            {
                $rq = $bdd -> prepare('UPDATE demande_amis SET pseudo1 = ?');
                $rq -> execute(array($_POST['pseudo']));

                $requete = $bdd -> prepare('UPDATE membres SET pseudo = ?, email = ?, jeux = ?, bio = ? WHERE id = ?');
                $requete -> execute(array($_POST['pseudo'], $_POST['email'], $_POST['jeux'], $_POST['bio'], $_SESSION['id']));
                
                $requete_membres = $bdd-> prepare('SELECT * FROM membres WHERE id = ?');
                $requete_membres -> execute(array($_SESSION['id']));
                $user = $requete_membres -> fetch();
                $_SESSION['id'] = $user['id'];
                $_SESSION['pseudo'] = $user['pseudo'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['jeux'] = $user['jeux'];
                $_SESSION['sexualite'] = $user['sexualite'];
                $_SESSION['age'] = $user['age'];
                header('Location: profil.php?id='.$_SESSION['id'].'');
            }
            else
            {
                $error = 'Cette addresse mail est déjà prise !';
            }
        }
        else
        {
            $error = 'Ce pseudo existe déjà !';
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php include('head.php');?>
    <title>🎮Anabi • <?php echo $_SESSION['pseudo']; ?>🎮</title>
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
        #mdp:hover
        {
            border-left: 2.3px solid rgba(0,0,0,0.1);
        }
        #pp:hover
        {
            border-left: 2.3px solid rgba(0,0,0,0.1);
        }
        </style>
        <h1 style="font-size: 1vw; margin-top: -0.05vw; border-left: 2.3px solid black; padding: 1vw; margin-left: -0.05vw;"><a href="edition_profil.php"><span style="color: white;">Modifier le Profil</span></a></h1>
        <h1 id="mdp" style="
        color: white; 
        font-size: 0.8vw; 
        margin-top: -0.65vw; 
        margin-left: -0.05vw;
        padding: 1vw; 
        "><a href="update_mdp.php"><span style="color: white;">Changer de mot de passe</span></a></h1>
        <h1 id="pp" style="
        color: white; 
        font-size: 0.8vw; 
        margin-top: -0.65vw; 
        margin-left: -0.05vw;
        padding: 1vw; 
        "><a href="modif_avatar.php"><span style="color: white;">Changer de photo de profil</span></a></h1>
        <h1 id="pp" style="
        color: white; 
        font-size: 0.8vw; 
        margin-top: -0.65vw; 
        margin-left: -0.05vw;
        padding: 1vw; 
        "><a href="modif_theme.php"><span style="color: white;">Changer de thème</span></a></h1>
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
        <form method="POST">
                        <table align="center">
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
                                <td style="color: white; font-size: 0.8vw;" align="right">
                                    Nom d'utilisateur
                                </td>
                                <td>
                                    <input type="text" name="pseudo" style='
                                    width: 10vw; 
                                    height: 1.2vw; 
                                    margin-left: 15%;
                                    font-size: 0.8vw;
                                    color: white;
                                    background-color: rgba(0,0,0,0);
                                    border: 1px solid rgba( 0, 0, 0, 0);
                                    ' value="<?php echo $_SESSION['pseudo']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td style="color: white; font-size: 0.8vw;" align="right">
                                    Adresse E-mail
                                </td>
                                <td>
                                <input type="email" name="email" style='
                                width: 10vw; 
                                height: 1.2vw; 
                                margin-left: 15%;
                                font-size: 0.8vw;
                                color: white;
                                background-color: rgba(0,0,0,0);
                                border: 1px solid rgba( 0, 0, 0, 0);
                                ' value="<?php echo $_SESSION['email']?>">
                                </td>
                            </tr>
                            <tr>
                                <td style="color: white; font-size: 0.8vw;" align="right">
                                    Style de jeux
                                </td>
                                <td>
                                <select name="jeux" style="
                                margin-left: 15%;
                                font-size: 0.8vw;
                                color: white;
                                background-color: rgba(0,0,0,0);
                                border: 1px solid rgba( 0, 0, 0, 0);
                                -webkit-appearance: none;
                                ">
                                                <option value="<?php echo $_SESSION['jeux'] ?>"><?php echo $_SESSION['jeux'] ?></option>
                                                <option value="Action/Aventure">Action/Aventure</option>
                                                <option value="FPS/Jeux de tirs">FPS/Jeux de tirs</option>
                                                <option value="Sports">Sports</option>
                                                <option value="RPG/Aventure">RPG/Aventure</option>
                                                <option value="Course">Course</option>
                                                <option value="Gestion">Gestion</option>
                                                <option value="Combat">Combat</option>
                                                <option value="Simulation">Simulation</option>
                                                <option value="Plateforme">Plateforme</option>
                                            </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: white; font-size: 0.8vw;" align="right">
                                    Sexe 
                                </td>
                                <td>
                                            <span style="
                                            margin-left: 15%;
                                            font-size: 0.8vw;
                                            -webkit-appearance: none;
                                            border: 1px solid rgba( 0, 0, 0, 0);
                                            color: rgba(0,0,0,0.4);
                                            cursor: default;
                                            font-family: bello;
                                            ">
                                                <?php echo $_SESSION['sexualite'] ?>

                                            </span>
                                        </td>
                            </tr>
                            <tr>
                                <td style="color: white; font-size: 0.8vw;" align="right">
                                    Date de naissance 
                                </td>
                                <td>
                                    <?php 
                                        $requete_date = $bdd -> prepare('SELECT * FROM membres WHERE id = ?');
                                        $requete_date -> execute(array($_SESSION['id']));
                                        $date_naissance = $requete_date -> fetch();

                                        $naissance = new DateTime($date_naissance['date_naissance']);
                                        $naissance = $naissance -> format('d/m/Y');

                                        echo '<span style="
                                        color: white;
                                        font-family: bello; 
                                        font-size: 0.7vw;
                                        margin-left: 15%;
                                        cursor: default;
                                        color: rgba(0,0,0,0.6);
                                        ">'.$naissance.'</span>';
                                    ?>
                                </td>
                            </tr>
                            <tr style="color: white;">
                                    <td align="right" style="font-size: 0.8vw;">Bio</td>
                                    <td>
                                    <?php 
                                        
                                        $requete_bio = $bdd -> prepare('SELECT * FROM membres WHERE id = ?');
                                        $requete_bio -> execute(array($_SESSION['id']));
                                        $bio = $requete_bio -> fetch();

                                    ?>
                                            <textarea style="
                                                border: 1px solid rgba(0,0,0,0);
                                                resize: none;
                                                color: white;
                                                font-size: 0.7vw;
                                                width: 10vw;
                                                height: 2vw;
                                                background-color: rgba(0,0,0,0);
                                                margin-left: 15%;
                                                "
                                                name="bio"
                                                ><?php echo $bio['bio'];;?>
                                            </textarea>
                                    </td>
                            </tr>
                            <td></td>
                            <td><br>
                                <input type="submit" style="
                                width: 5vw;
                                border: 1px solid rgba(0,0,0,0.5);
                                background-color: rgba(0,0,0,0.3);
                                color: white;
                                font-size: 0.8vw;
                                border-radius: 0.3vw 0.3vw 0.3vw 0.3vw;
                                cursor: pointer;
                                margin-left: 13%;
                                
                                " name="edition" value="Modifier">
                            </td>
                            </tr>
                            </tr>
                            <tr>
                                    <td></td>
                                    <td>
                                        <p style="color: red;"><?php if(isset($error)){ echo $error; } ?></p>
                                    </td>
                            </tr>
                        </table>
    </div>
</div>
</form>
</body>
</html>