<?php
    session_start();
    include('bdd.php');
    include('menuPHP.php');
    if($_GET['age'] == 1 )
    { 
        $ageAn = 'an';
    } 
    else 
    {
        $ageAn = 'ans';
    }
    $requete_amis_exist = $bdd -> prepare('SELECT * FROM demande_amis WHERE demande = ? AND pseudo1 = ? AND pseudo2 = ?');
    $requete_amis_exist -> execute(array(1, $_SESSION['pseudo'], $_GET['pseudo']));
    $q_amis_exist = $requete_amis_exist -> rowCount();

    $requete_amis_exist_vraiment = $bdd -> prepare('SELECT * FROM demande_amis WHERE pseudo1 = ? AND pseudo2 = ?');
    $requete_amis_exist_vraiment -> execute(array($_SESSION['pseudo'], $_GET['pseudo']));
    $count_amis_exist_vraiment = $requete_amis_exist_vraiment -> rowCount();

    if($count_amis_exist_vraiment == 0)
    {
        if(isset($_POST['demande_amis']))
        {
                        $requete_amis = $bdd -> prepare('INSERT INTO demande_amis(pseudo1, pseudo2, demande) VALUES(?, ?, ?) ');
                        $requete_amis -> execute(array($_SESSION['pseudo'], $_GET['pseudo'], 1));
        }
    }
    $requete_id = $bdd -> prepare('SELECT * FROM demande_amis WHERE pseudo1 = ? AND pseudo2 = ?');
    $requete_id -> execute(array($_SESSION['pseudo'], $_GET['pseudo']));
    $q_id = $requete_id -> fetch();
    if($count_amis_exist_vraiment == 1)
    {
        if(isset($_POST['demande_amis']))
        {
            $requete_amis_encore = $bdd -> prepare('UPDATE demande_amis SET demande = ? WHERE id = ?');
            $requete_amis_encore -> execute(array(1, $q_id['id']));
        }
        if(isset($_POST['enlever_amis']))
        {
            $delete_amis = $bdd -> prepare('UPDATE demande_amis SET demande = ? WHERE id = ?');
            $delete_amis -> execute(array(0, $q_id['id']));
        }
    }
    if($_GET['id'] == $_SESSION['id_recherche'] && 
    $_GET['pseudo'] == $_SESSION['pseudo_recherche'] &&
     $_GET['email'] == $_SESSION['email_recherche'] && 
     $_GET['jeux'] == $_SESSION['jeux_recherche'] && 
     $_GET['sexe'] == $_SESSION['sexe_recherche'] && 
     $_GET['age'] == $_SESSION['age_recherche'])
    {
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css.css">
        <link rel="icon" type="icon" href="images/petit.png">
    </head>
    <body>
    <h1 class="centre"><?php echo 'Profil de '.$_GET['pseudo'].'';?></h1>
    <table align="center">
        <tr>
            <td class="td">
                Pseudo:
            </td>
            <td>
                <?php echo $_GET['pseudo'];?>
            </td>
        </tr>
        <tr>
            <td class="td">
                Email:
            </td>
            <td>
                <?php echo $_GET['email'];?>
            </td>
        </tr>
        <tr>
            <td class="td">
                Style de jeux:
            </td>
            <td>
                <?php echo $_GET['jeux'];?>
            </td>
        </tr>
        <tr>
            <td class="td">
                Sexe:
            </td>
            <td>
                <?php echo $_GET['sexe'];?>
            </td>
        </tr>
        <tr>
            <td class="td">
                Age :
            </td>
            <td>
                 <?php echo $_GET['age']; ?> <?php echo $ageAn ?>
            </td>
        </tr>
        <form method="POST" action="">
        <tr>
            <td></td>
            <td>
             <input type="submit" name="demande_amis" value="Demander en amis">
        </tr>
        <tr>
            <td></td>
            <td>
            <?php if(isset($_POST['demande_amis']))
            {    
            ?>
                <input type="submit" name="enlever_amis" value="Retirer des amis"></td>
            <?php
            }
            ?>
            
        </tr>
        <tr>
            <td></td>
            <td><?php if(isset($error)){ echo $error; } ?></td>
        </tr>
    </form>
    <?php
    }
    else
    {
        echo '<h1 align="center" style="color: red;">Erreur dans l\'url, valeurs de variables modifiées !</h1>';
    }
    ?>
    </body>
</html>