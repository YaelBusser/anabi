<?php
session_start();
require('bdd.php');
    if(isset($_POST['btnInscription']))
    {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $email2 = htmlspecialchars($_POST['email2']);
        $mdp = sha1($_POST['mdp']);
        $mdp2 = sha1($_POST['mdp2']);
        if(!empty($pseudo) AND !empty($email) AND !empty($email2) AND !empty($mdp) AND !empty($mdp2))
        {
            $_SESSION['pseudo_inscription'] = $pseudo;
            if(strlen($pseudo) <= 16 )
            {    
                if($email == $email2)
                {
                    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                    $requete_email = $bdd -> prepare('SELECT email FROM membres WHERE email = ?');
                    $requete_email -> execute(array($email));
                    $email_doublon = $requete_email -> rowCount();
                    if($email_doublon == 0)
                    {
                        if($mdp == $mdp2)
                        {
                            $requete_pseudo = $bdd -> prepare('SELECT pseudo FROM membres WHERE pseudo = ? ');
                            $requete_pseudo -> execute(array($pseudo));
                            $pseudo_exist = $requete_pseudo -> rowCount();
                            if($pseudo_exist ==  0)
                            {
                                $creation_compte = $bdd -> prepare('INSERT INTO membres(pseudo, email, mdp, jeux, sexualite, date_naissance) VALUES(?, ?, ?, ?, ?, ?)');
                                $creation_compte -> execute(array($pseudo, $email, $mdp, $_POST['jeux'], $_POST['sexualite'], $_POST['date_naissance']));
                                header('Location: creation_compte.php');
                            }
                            else
                            {
                                $error = "<p style='color: red; font-family: bello;'>Le pseudo est déjà pris, dommage :) !</p>";
                            }
                        }
                        else
                        {
                            $error = "<p style='color: red; font-family: bello;'>Votre mot de passe n'est pas le même !</p>";
                        }
                    }
                    else
                    {
                        $error = "<p style='color: red; font-family: bello;'>L'email est déjà utilisé mais vous pouvez uniquement vous connecter avec votre pseudo !</p>";
                    }
                }
                else
                {
                    $error = "<p style='color: red; font-family: bello;'> Votre adresse email ne correspond pas avec celle de confirmation ;) </p>"; 
                }
            }
            else
            {
                $error = "<p style='color: red; font-family: bello;'> Votre pseudo doit comporter uniquement 16 caractères ! </p>"; 
                $alertPseudo = "";
            }
        }
        else
        {
            $error = "<p style='color: red; font-family: bello;'>Tous les champs doivent être remplis !</p>";
        }
    }
?>
<DOCTYPE html>
<html>
    <head>
        <title>🎮Anabi • Inscription🎮</title>
        <?php include('head.php');?>
    </head>
<body>
    <div class="connexion" style="
    box-shadow: 0.2vw 0.2vw 0.5vw black;
    ">
                <span style="color: black; font-family: bello; font-size: 3vw; margin-left: 8vw;">Anabi<br></span>
                <h1 style="
                color: #a6a6a6; 
                font-size: 0.6vw; 
                font-family: amikobold; 
                margin-left: 3vw;
                padding: 2vw;
                ">
                Inscrivez-vous pour pouvoir discuter avec vos amis et partager une expérience de gaming incroyable !
    </h1>
            <form method="POST" name="inscription" action="">
            <div 
                style="
                display: flex;
                flex-direction: column;
                align-items: center;
                ">
                <br>
                        <div style="
                        display: flex;
                        ">
                            <input type="text" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)){echo $pseudo;} ?>" placeholder="Nom d'utilisateur" style=
                            'width: 10vw; 
                            heigth: 10vw; 
                            height:  1.3vw;
                            color: #6600ff;
                            font-size: 0.8vw;
                            border: 1px solid rgba(102, 0, 255, 0);
                            '>
                            <?php 
                                if(isset($alertPseudo))
                                {
                                    echo '<img src="images/error.png" style="width: 1.5vw; height: 1.5vw;">';
                                }
                            ?>
                        </div>
                            <br>
                            <div style="
                            display: flex;
                            ">
                            <input type="email" id="email" name="email" value="<?php if(isset($email)){echo $email;} ?>" placeholder="E-mail" style='
                            width: 10vw; 
                            heigth: 10vw; 
                            height:  1.3vw;
                            color: #6600ff;
                            font-size: 0.8vw;
                            border: 1px solid rgba(102, 0, 255, 0);
                            '>
                            <?php 
                                if(isset($alertG))
                                {
                                    echo '<img src="images/error.png" style="width: 1.5vw; height: 1.5vw;">';
                                }
                            ?>
                            </div>
                            <br>
                            <div style="
                            display: flex;
                            ">
                            <input type="email" id="email2" name="email2" value="<?php if(isset($email2)){echo $email2;} ?>" placeholder="Confirmation E-mail" style='
                            width: 10vw; 
                            heigth: 10vw; 
                            color: #6600ff;
                            height: 1.3vw;
                            font-size: 0.8vw;
                            border: 1px solid rgba(102, 0, 255, 0);
                            '>
                            <?php 
                                if(isset($alertG))
                                {
                                    echo '<img src="images/error.png" style="width: 1.5vw; height: 1.5vw;">';
                                }
                            ?>
                            </div>
                            <br>
                            <div style="
                            display: flex;
                            ">
                            <input type="password" id="mdp" name="mdp" placeholder="Mot de Passe" style='
                            width: 10vw; 
                            heigth: 10vw; 
                            height: 1.5vw;
                            font-size: 0.8vw;
                            border: 1px solid rgba(102, 0, 255, 0);
                            '>
                            <?php 
                                if(isset($alertG))
                                {
                                    echo '<img src="images/error.png" style="width: 1.5vw; height: 1.5vw;">';
                                }
                            ?>
                            </div>
                            <br>
                            <div style="
                            display: flex;
                            ">
                            <input type="password" id="mdp2" name="mdp2" placeholder="Confirmation Mot de Passe" style='
                            width: 10vw; 
                            heigth: 10vw; 
                            height: 1.5vw;
                            font-size: 0.8vw;
                            border: 1px solid rgba(102, 0, 255, 0);
                            '>
                            <?php 
                                if(isset($alertG))
                                {
                                    echo '<img src="images/error.png" style="width: 1.5vw; height: 1.5vw;">';
                                }
                            ?>
                            </div>
                            <br>
                            <div style="
                            display: flex;
                            ">
                            <span style="
                            font-family: amikobold;
                            font-size: 0.8vw;
                            margin-left: 2.1vw;
                            color: rgba(0,0,0,0.7);
                            ">Style de jeux:
                            <select name="jeux" id="jeux" style="
                            width: 6.5vw;
                            font-size: 0.7vw;
                            border: 1px solid rgba(102, 0, 255, 0.5);
                            border-radius: 1vw 1vw 1vw 1vw;
                            ">
                                <option value="Action/Aventure">Action/Aventure</option>
                                <option value="FPS">FPS/Jeux de tirs</option>
                                <option value="Sports">Sports</option>
                                <option value="RPG/Aventure">RPG/Aventure</option>
                                <option value="Course">Course</option>
                                <option value="Gestion">Gestion</option>
                                <option value="Combat">Combat</option>
                                <option value="Simulation">Simulation</option>
                                <option value="Plateforme">Plateforme</option>
                            </select>
                            </span>
                            <?php 
                                if(isset($alertG))
                                {
                                    echo '<img src="images/error.png" style="width: 1.5vw; height: 1.5vw;">';
                                }
                            ?>
                            </div>
                            <br>
                            <div style="
                            display: flex;
                            ">
                            <span style="
                            font-family: amikobold;
                            font-size: 0.8vw;
                            margin-left: -3.55vw;
                            color: rgba(0,0,0,0.7);
                            ">Sexe:
                            <select name="sexualite" id="sex" style="
                            width: 4vw;
                            font-size: 0.7vw;
                            border: 1px solid rgba(102, 0, 255, 0.5);
                            border-radius: 1vw 1vw 1vw 1vw;
                            ">
                                <option value="Homme">Homme ♂</option>
                                <option value="Homosexuel">Femme ♀</option>
                            </select>
                            </span>
                            <?php 
                                if(isset($alertG))
                                {
                                    echo '<img src="images/error.png" style="width: 1.5vw; height: 1.5vw;">';
                                }
                            ?>
                            </div>
                            <br>
                            <div style="
                            display: flex;
                            ">
                           <span style="
                            font-family: amikobold;
                            font-size: 0.8vw;
                            margin-left: 5vw;
                            color: rgba(0,0,0,0.7);
                            ">Date de naissance:
                                <input type="date" name="date_naissance" style="
                                width: 6vw;
                                font-size: 0.6vw;
                                border: 1px solid rgba(0,0,0,0)
                                ">
                            </span>
                            <?php 
                                if(isset($alertG))
                                {
                                    echo '<img src="images/error.png" style="width: 1.5vw; height: 1.5vw;">';
                                }
                            ?>
                            </div>
                            <br>
                            <input type="submit" value="S'inscrire" name="btnInscription" style="
                            
                            width: 10.2vw;
                        height: 1.5vw;
                        border: 1px solid rgba(102, 0, 255, 1);
                        background-color: rgb(194, 153, 255);
                        color: white;
                        font-size: 0.8vw;
                        border-radius: 0.3vw 0.3vw 0.3vw 0.3vw;
                        cursor: pointer;
                            ">

            </form>
            <div align="center">
            <?php 
                            
            if(isset($error)) 
            { 
            echo $error;
            } 
                            
            ?>
            </div>
        </div>
    </div>
    <div 
        style="
        font-size: 0.5vw;
        width: 23vw;
        border: 0.01vw solid rgba(166, 166, 166, 0.3);
        margin-top: 2vw;
        margin-left: 35vw;
        padding: 1vw;
        box-shadow: 0.2vw 0.2vw 0.5vw black;
        "
        >

        <h1 style="color: black; margin-left: 3.8vw; font-size: 0.8vw; font-family: bello">Vous avez un compte ? <a href="connexion.php"> <span style="color: #6600ff;">Connectez-vous</span></a></h1>

        </div>
</body>
</html>