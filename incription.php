<?php
session_start();
    include('bdd.php');
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
                                $creation_compte = $bdd -> prepare('INSERT INTO membres(pseudo, email, mdp, jeux, sexualite, age) VALUES(?, ?, ?, ?, ?, ?)');
                                $creation_compte -> execute(array($pseudo, $email, $mdp, $_POST['jeux'], $_POST['sexualite'], $_POST['age']));
                                $pseudo = $_COOKIE[$pseudo];
                                header('Location: creation_compte.php');
                            }
                            else
                            {
                                $error = "<p style='color: red;'>Le pseudo est déjà pris, dommage :) !</p>";
                            }
                        }
                        else
                        {
                            $error = "<p style='color: red;'>Votre mot de passe n'est pas le même !</p>";
                        }
                    }
                    else
                    {
                        $error = "<p style='color: red;'>L'email est déjà utilisé mais vous pouvez uniquement vous connecter avec votre pseudo !</p>";
                    }
                }
                else
                {
                    $error = "<p style='color: red;'> Votre adresse email ne correspond pas avec celle de confirmation ;) </p>"; 
                }
            }
            else
            {
                $error = "<p style='color: red;'> Votre pseudo doit comporter uniquement 16 caractères ! </p>"; 
            }
        }
        else
        {
            $error = "<p style='color: red;'>Tous les champs doivent être remplis !</p>";
        }
    }
?>
<DOCTYPE html>
<html>
    <head>
        <title>Anabi || Inscription</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css.css">
        <link rel="icon" type="icon" href="images/petit.png">
    </head>
<body>
    <?php

        include('menu.html')

    ?>
    <h1 class="h1Inscription">Inscription</h1>
    <div align="center">
        <form method="POST" name="inscription" action="">
            <table class="sizeInscription">
                <tr>
                    <td>
                       <label for="pseudo"> Votre Pseudo</label>
                    </td>
                    <td>
                        <input type="text" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)){echo $pseudo;} ?>" placeholder="Votre pseudo" style='width: 10vw; heigth: 10vw; height:  1.5vw;'>
                    </td>
                </tr> 
                <tr>
                <td>
                   <label for="email"> Votre Email</label>
                </td>
                    <td>
                        <input type="email" id="email" name="email" value="<?php if(isset($email)){echo $email;} ?>" placeholder="Votre email" style='width: 10vw; heigth: 10vw; height:  1.5vw;'>
                    </td>
                </tr>
                    <tr>
                    <td>
                        <label for="email2">Confirmez votre Email</label>
                </td>
                    <td>
                        <input type="email" id="email2" name="email2" value="<?php if(isset($email2)){echo $email2;} ?>" placeholder="Confirmez votre email" style='width: 10vw; heigth: 10vw; height:  1.5vw;'>
                    </td>
                </tr>
              
                <tr>
                <td>
                   <label for="mdp"> Votre Mot de Passe</label>
                </td>
                    <td>
                        <input type="password" id="mdp" name="mdp" placeholder="Votre Mot de Passe" style='width: 10vw; heigth: 10vw; height:  1.5vw;'>
                    </td>
                </tr>
                    <tr>
                    <td>
                   <label for="mdp2"> Confirmez votre mot de passe</label>
                </td>
                    <td>
                        <input type="password" id="mdp2" name="mdp2" placeholder="Confirmez votre Mot de Passe" style='width: 10vw; heigth: 10vw; height:  1.5vw;'>
                    </td>
                </tr>
                <tr>
                    <td>
                       <label for="jeux"> Vos types de jeux : </label>
                    </td>
                    <td>
                        <select name="jeux" id="jeux">
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
                    </td>
                </tr>
                <tr>
                    <td>
                       <label for="sex"> Votre sexe :</label>
                    </td>
                    <td>
                        <select name="sexualite" id="sex">
                            <option value="Homme">Homme</option>
                            <option value="Homosexuel">Femme</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                       <label for="age"> Votre âge :</label>
                    </td>
                    <td>
                        <select name="age" id="age">
                            <option value="1">1 an</option>
                            <option value="2">2 ans</option>
                            <option value="3">3 ans</option>
                            <option value="4">4 ans</option>
                            <option value="5">5 ans</option>
                            <option value="6">6 ans</option>
                            <option value="7">7 ans</option>
                            <option value="8">8 ans</option>
                            <option value="9">9 ans</option>
                            <option value="10">10 ans</option>
                            <option value="11">11 ans</option>
                            <option value="12">12 ans</option>
                            <option value="13">13 ans</option>
                            <option value="14">14 ans</option>
                            <option value="15">15 ans</option>
                            <option value="16">16 ans</option>
                            <option value="17">17 ans</option>
                            <option value="18">18 ans</option>
                            <option value="19">19 ans</option>
                            <option value="20">20 ans</option>
                            <option value="21">21 ans</option>
                            <option value="22">22 ans</option>
                            <option value="23">23 ans</option>
                            <option value="24">24 ans</option>
                            <option value="25">25 ans</option>
                            <option value="26">26 ans</option>
                            <option value="27">27 ans</option>
                            <option value="28">28 ans</option>
                            <option value="29">29 ans</option>
                            <option value="30">30 ans</option>
                            <option value="31">31 ans</option>
                            <option value="32">32 ans</option>
                            <option value="34">33 ans</option>
                            <option value="35">34 ans</option>
                            <option value="36">35 ans</option>
                            <option value="37">36 ans</option>
                            <option value="38">37 ans</option>
                            <option value="39">38 ans</option>
                            <option value="40">39 ans</option>
                            <option value="41">40 ans</option>
                            <option value="42">41 ans</option>
                            <option value="43">42 ans</option>
                            <option value="44">43 ans</option>
                            <option value="45">44 ans</option>
                            <option value="46">45 ans</option>
                            <option value="47">46 ans</option>
                            <option value="48">47 ans</option>
                            <option value="49">48 ans</option>
                            <option value="50">49 ans</option>
                            <option value="51">50 ans</option>
                            <option value="52">51 ans</option>
                            <option value="53">52 ans</option>
                            <option value="54">53 ans</option>
                            <option value="55">54 ans</option>
                            <option value="56">55 ans</option>
                            <option value="57">56 ans</option>
                            <option value="58">57 ans</option>
                            <option value="59">58 ans</option>
                            <option value="60">59 ans</option>
                            <option value="61">60 ans</option>
                            <option value="62">61 ans</option>
                            <option value="63">62 ans</option>
                            <option value="64">63 ans</option>
                            <option value="65">64 ans</option>
                            <option value="66">65 ans</option>
                            <option value="67">66 ans</option>
                            <option value="68">67 ans</option>
                            <option value="69">68 ans</option>
                            <option value="70">69 ans</option>
                            <option value="71">70 ans</option>
                            <option value="72">71 ans</option>
                            <option value="73">72 ans</option>
                            <option value="74">73 ans</option>
                            <option value="75">74 ans</option>
                            <option value="76">75 ans</option>
                            <option value="77">76 ans</option>
                            <option value="78">77 ans</option>
                            <option value="79">78 ans</option>
                            <option value="80">79 ans</option>
                            <option value="81">80 ans</option>
                            <option value="82">81 ans</option>
                            <option value="83">82 ans</option>
                            <option value="84">83 ans</option>
                            <option value="85">84 ans</option>
                            <option value="86">85 ans</option>
                            <option value="87">86 ans</option>
                            <option value="88">87 ans</option>
                            <option value="89">88 ans</option>
                            <option value="89">89 ans</option>
                            <option value="90">90 ans</option>
                            <option value="91">91 ans</option>
                            <option value="92">92 ans</option>
                            <option value="93">93 ans</option>
                            <option value="94">94 ans</option>
                            <option value="95">95 ans</option>
                            <option value="96">96 ans</option>
                            <option value="97">97 ans</option>
                            <option value="98">98 ans</option>
                            <option value="99">99 ans</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><br>
                        <input type="submit" value="Confirmer l'inscription" name="btnInscription">
                    </td>
                </tr>
            </table>
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
</body>
</html>