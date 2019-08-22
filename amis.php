<?php
session_start();
    require('bdd.php');
    $requete_amis = $bdd -> prepare('SELECT * FROM demande_amis WHERE accept = ? AND pseudo1 = ? OR pseudo2 = ?');
    $requete_amis -> execute(array(1 ,$_SESSION['pseudo'], $_SESSION['pseudo']));
    $nb_amis = $requete_amis -> rowCount();
       
?>
<!DOCTYPE html>
<html>
    <head>
        <title>🎮Anabi • Amis🎮</title>
        <?php include('head.php');?>
    </head>
<body>
<?php
    include('menuPHP.php');
?>
    <div style="
    width: 15vw;
    margin-left: 15vw;
    margin-top: 1vw;
    ">
    <div style="
    display: flex;
    flex-direction: column;
    ">
        <h1 style="
        color: black;
        text-align: center;
        font-family: bello;
        font-size: 2vw;
        border: 1px solid black;
        ">Amis</h1>

        <div style="
            border: 1px solid black;
            margin-top: -1vw;
        ">
        <?php 
                $amies = $bdd -> prepare('SELECT * FROM demande_amis WHERE pseudo2 = ? AND accept = ? OR pseudo1 = ? AND accept = ?');
                $amies -> execute(array($_SESSION['pseudo'], 1, $_SESSION['pseudo'], 1));
                $amiss = $amies -> fetchAll();
                foreach($amiss as $amis)
                {
                    if($amis['pseudo1'] == $_SESSION['pseudo'])
                    {
                        $pseudo = $amis['pseudo2'];
                        $requete_pseudo = $bdd -> prepare('SELECT * FROM membres WHERE pseudo = ?');
                        $requete_pseudo -> execute(array($pseudo));
                        $q_pseudo = $requete_pseudo -> fetch();
                    }
                    if($amis['pseudo2'] == $_SESSION['pseudo'])
                    {
                        $pseudo = $amis['pseudo1'];
                        $requete_pseudo = $bdd -> prepare('SELECT * FROM membres WHERE pseudo = ?');
                        $requete_pseudo -> execute(array($pseudo));
                        $q_pseudo = $requete_pseudo -> fetch();
                    }
                    $avatar_amis = $bdd -> prepare('SELECT * FROM membres WHERE pseudo = ?');
                    $avatar_amis -> execute(array($pseudo));
                    $avatar = $avatar_amis -> fetch();
                    
                    if(!empty($avatar['avatar']))
                    {
                        $_avatar = 'avatars/'.$avatar['avatar'].'';
                    }
                    else
                    {
                        $_avatar = 'images/profil.png';
                    }
                    echo '<span style="
                    color: black
                    ">
                    <div style="display: flex">
                    <a style=" 
                    color: black;
                    margin-left: 0.5vw;
                    font-size: 0.8vw;
                    font-family: amikobold;
                    border-bottom: 0.05vw solid black;
                    width: 15vw;
                    margin-left: -0.05vw;
                    margin-top: 0.5vw;
                    "
                    href="profil_principal_amis.php?pseudo2='.$q_pseudo['pseudo'].'&pseudo1='.$_SESSION['pseudo'].'&email='.$q_pseudo['email'].'&jeux='.$q_pseudo['jeux'].'&sexe='.$q_pseudo['sexualite'].'
                    "> 
                    <img src="'.$_avatar.'" style="width: 2vw; height: 2vw; border-radius: 50%;">
                    '.$q_pseudo['pseudo'].'
                    </a>
                    </span>
                    
                    <form method="POST" action="">
                    <input type="submit" style="width: 1.25vw; margin-left: 2vw; color: black" name="supp'.$amis['pseudo2'].'" value="X">
                </form>
                    
                    </div>
                    ';
                    if(isset($_POST['supp'.$amis['pseudo2'].'']))
                    {
                        $requete_supp = $bdd -> prepare('UPDATE demande_amis SET demande = ?, accept = ?, refuse = ? WHERE pseudo2 = ? AND pseudo1 = ? OR pseudo2 = ? AND pseudo1 = ?');
                        $requete_supp -> execute(array(0, 0, 0, $amis['pseudo2'], $amis['pseudo1'], $amis['pseudo1'], $amis['pseudo2']));

                    }
                    
                }
                ?>
                </div>
                </div>
            </div>
                
                
                
                
                
                
                
                
                
                
                
                
                <h1 style="color: black">Demandes d'amis envoyées :</h1>
                <?php
                    $requete_amis_send = $bdd -> prepare('SELECT * FROM demande_amis WHERE pseudo1 = ? AND demande = ?');
                    $requete_amis_send -> execute(array($_SESSION['pseudo'], 1));
                    $requete_amis_sendd = $requete_amis_send -> fetchAll();
                    foreach($requete_amis_sendd as $q_send)
                    {
                            echo '<p>'.$q_send['pseudo2'].'</p>';
                    }
                ?>
                </div>
                        <h1 style="color: black;">Demandes d'amis reçus :</h1>
                        <?php
                        $none = '';
                        $requete_attente_amis = $bdd -> prepare('SELECT * FROM demande_amis WHERE pseudo2 = ? AND demande = ?');
                        $requete_attente_amis -> execute(array($_SESSION['pseudo'], 1));
                        $q_attente_amis = $requete_attente_amis -> fetchAll();
                        if($q_attente_amis > 0)
                        {
                            foreach($q_attente_amis as $attente_amis)
                            {
                                $accept = $bdd -> prepare('SELECT * FROM demande_amis WHERE pseudo1 = ? AND pseudo2 = ?');
                                $accept -> execute(array($attente_amis['pseudo1'], $_SESSION['pseudo']));
                                $acceptt = $accept -> fetch();
                                if(isset($_POST['accept'.$attente_amis['pseudo1'].'']))
                                {
                                    $q_accept = $bdd -> prepare('UPDATE demande_amis SET demande = ?, accept = ?, refuse = ? WHERE pseudo1 = ? AND pseudo2 = ?');
                                    $q_accept -> execute(array(0, 1, 0, $acceptt['pseudo1'], $acceptt['pseudo2']));
                                    $accept_chat = $bdd -> prepare('UPDATE chat SET accept = ? WHERE pseudo1 = ? AND pseudo2 = ? OR pseudo1 = ? AND pseudo2 = ?');
                                    $accept_chat -> execute(array(1, $acceptt['pseudo1'], $acceptt['pseudo2'], $acceptt['pseudo2'], $acceptt['pseudo1']));
                                   
                                    $amies = $bdd -> prepare('SELECT * FROM demande_amis WHERE pseudo2 = ? AND accept = ? OR pseudo1 = ? AND accept = ?');
                                    $amies -> execute(array($_SESSION['pseudo'], 1, $_SESSION['pseudo'], 1));
                                    $amiss = $amies -> fetchAll();
                                    foreach($amiss as $amis)
                                    {
                                        if($amis['pseudo1'] == $_SESSION['pseudo'])
                                        {
                                            $pseudo = $amis['pseudo2'];
                                        }
                                        if($amis['pseudo2'] == $_SESSION['pseudo'])
                                        {
                                            $pseudo = $amis['pseudo1'];
                                        }    
                                        $liste = $bdd -> prepare('INSERT INTO chat_amis(pseudo1, pseudo2, rang) VALUES(?, ?, ?)');
                                        $liste -> execute(array($_SESSION['pseudo'], $pseudo, 1));
                                    }
                                }
                                if(isset($_POST['refuse'.$attente_amis['pseudo1'].'']))
                                {
                                    $q_refuse = $bdd -> prepare('UPDATE demande_amis SET demande = ?, refuse = ?, accept = ?  WHERE pseudo1 = ? AND pseudo2 = ?');
                                    $q_refuse -> execute(array(0, 1, 0, $acceptt['pseudo1'], $acceptt['pseudo2']));
                                }
                                $requete_attente_amiss = $bdd -> prepare('SELECT * FROM demande_amis WHERE pseudo2 = ? AND pseudo1 = ? AND demande = ?');
                                $requete_attente_amiss -> execute(array($_SESSION['pseudo'], $attente_amis['pseudo1'], 1));
                                $q_attente_amiss = $requete_attente_amiss -> rowCount();
                                if($q_attente_amiss == 1)
                                {
                                    echo '<span>'.$attente_amis['pseudo1'].' vous a demandé en amis !</span>
                                    <form method="POST" action="" align="center">
                                        <input type="submit" style="font-size: 1vw;" name="accept'.$attente_amis['pseudo1'].'" value="accepter">
                                        <input type="submit" style="font-size: 1vw;" name="refuse'.$attente_amis['pseudo1'].'" value="refuser">
                                    </form>
                                    </p>';
                                }
                            }
                        }
                        $requete_attente_amiss = $bdd -> prepare('SELECT * FROM demande_amis WHERE pseudo2 = ? AND demande = ?');
                        $requete_attente_amiss -> execute(array($_SESSION['pseudo'], 1));
                        $q_attente_amiss = $requete_attente_amiss -> rowCount();
                        if($q_attente_amiss == 0)
                        {
                            echo '<p style="color: black">Vous n\'avez reçus aucune demande d\'amis !</p>';
                        }
                        ?>
</body>
</html>