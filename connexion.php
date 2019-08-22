<?php
session_start();
    require('bdd.php');
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
                header('Location: profil.php?id='.$_SESSION['id'].'');
            }
            else
            {
                $error = "<p style='color: red; font-family: bello;'>Le pseudo ou le mot de passe est incorrect !</p>";
                $errorAlert = "";
            }
        }
        else
        {
            $error = "<p style='color: red; font-family: bello;'>Tous les champs doivent être complétés !</p>";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>🎮Anabi • Connexion🎮</title>
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
            
        <form method="POST">
        <div style="
        display: flex; 
        flex-direction: column;
        align-items: center;
        ">
                
                <div style="
                display: flex;
                ">
                    <input name="pseudo" type="text" placeholder="Nom d'utilisateur" id="pseudo" style='
                    
                    width: 10vw;
                    height: 1.3vw;
                    font-size: 0.8vw;
                    border: 1px solid rgba(102, 0, 255, 0);
                    color: #6600ff;
                    background-color: rgba(255,255,255,0);
                    ' 
                    value="<?php if(!empty($_POST['pseudo'])){echo $_POST['pseudo'];} ?>">
                    <?php 
                        if(isset($errorAlert))
                        {
                            echo '<img src="images/error.png" style="width: 1.5vw; height: 1.5vw;">';
                        }
                    ?>
                </div>
                <br>
                <div style="
                display: flex;
                ">
                        <input name="mdp" id="mdp" type="password" placeholder="Mot de Passe" style='
                        width: 10vw; 
                        height: 1.3vw;
                        font-size: 0.8vw;
                        border: 1px solid rgba(102, 0, 255, 0);
                        background-color: rgba(255,255,255,0);
                        '>
                    <?php 
                        if(isset($errorAlert))
                        {
                            echo '<img src="images/error.png" style="width: 1.5vw; height: 1.5vw;">';
                        }
                    ?>
                    </div>
                        <br>
                        <input name="btnConnexion" type="submit" style="
                        width: 10.2vw;
                        height: 1.5vw;
                        border: 1px solid rgba(102, 0, 255, 1);
                        background-color: rgb(194, 153, 255);
                        color: white;
                        font-size: 0.8vw;
                        border-radius: 0.3vw 0.3vw 0.3vw 0.3vw;
                        cursor: pointer;
                        " value="Connexion">
                        <br>
                        <?php if(isset($error)){echo $error;}?>
        </div>
</div>
        </form>
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

        <h1 style="color: black; margin-left: 3.5vw; font-size: 0.8vw; font-family: bello">Vous n'avez pas de compte ? <a href="inscription.php"> <span style="color: #6600ff;">Inscrivez-vous</span></a></h1>

        </div>
</body>
</html>