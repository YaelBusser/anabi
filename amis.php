<?php
session_start();
    require('bdd.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Anabi || Amis</title>
        <?php include('head.php');?>
    </head>
<body>
<?php
    include('menuPHP.php');
?>
<table align="center">
<tr>
    <td>
        <h1>Demandes d'amis envoyées :</h1>
        <?php
            $requete_amis_send = $bdd -> prepare('SELECT * FROM demande_amis WHERE pseudo1 = ? AND demande = ?');
            $requete_amis_send -> execute(array($_SESSION['pseudo'], 1));
            $requete_amis_sendd = $requete_amis_send -> fetchAll();
            foreach($requete_amis_sendd as $q_send)
            {
                    echo '<p>'.$q_send['pseudo2'].'</p>';
            }
        ?>
    </td>
<tr>
    <td>
        <h1>Demandes d'amis reçues :</h1>
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
                    $none = 'display: none;';
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
                    echo '<p>'.$attente_amis['pseudo1'].' <span style="color: green;">vous a demandé en amis !</span>
                    <form method="POST" action="">
                        <input type="submit" name="accept'.$attente_amis['pseudo1'].'" value="accepter">
                        <input type="submit" name="refuse'.$attente_amis['pseudo1'].'" value="refuser">
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
            echo '<p style="color: red">Vous n\'avez reçus aucune demande d\'amis !</p>';
        }
        ?>
    </td>
</tr>
<tr>
    <td>
        <h1>Mes amis :</h1>
    </td>
</tr>
<tr>
<td>
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
        echo '<a href="profil_principal_amis.php?pseudo2='.$q_pseudo['pseudo'].'&pseudo1='.$_SESSION['pseudo'].'&email='.$q_pseudo['email'].'&jeux='.$q_pseudo['jeux'].'&sexe='.$q_pseudo['sexualite'].'&age='.$q_pseudo['age'].'">'.$pseudo.'</a>
        <form method="POST" action="">
            <input type="submit" name="supp'.$amis['pseudo1'].'" value="Supprimer cet ami !">
        </form>
        ';
        if(isset($_POST['supp'.$amis['pseudo1'].'']))
        {
            $requete_supp = $bdd -> prepare('UPDATE demande_amis SET demande = ?, accept = ?, refuse = ? WHERE pseudo2 = ? AND pseudo1 = ? OR pseudo2 = ? AND pseudo1 = ?');
            $requete_supp -> execute(array(0, 0, 0, $amis['pseudo2'], $amis['pseudo1'], $amis['pseudo1'], $amis['pseudo2']));

        }
        
    }
    ?>
    </td>
    </table>
</body>
</html>