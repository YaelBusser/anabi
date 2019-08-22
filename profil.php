<?php
    session_start();
    require('bdd.php');
    if(!empty($_POST['edition']))
    {
        header('Location: edition_profil.php');
    }
    $requete_amis = $bdd -> prepare('SELECT * FROM demande_amis WHERE accept = ? AND pseudo1 = ? OR accept = ? AND pseudo2 = ?');
    $requete_amis -> execute(array(1 ,$_SESSION['pseudo'], 1, $_SESSION['pseudo']));
    $nb_amis = $requete_amis -> rowCount();

    $requete_lvl = $bdd -> prepare('SELECT * FROM membres WHERE pseudo = ?');
    $requete_lvl -> execute(array($_SESSION['pseudo']));
    $lvl = $requete_lvl -> fetch();

    $requete_avatar = $bdd -> prepare('SELECT * FROM membres WHERE id = ?');
    $requete_avatar -> execute(array($_SESSION['id']));
    $avatar = $requete_avatar -> fetch();

    if($nb_amis == 1)
    {
        $_amis = ' ami';
    }
    else
    {
        $_amis = ' amis';
    }

    if(isset($_SESSION['id']) && $_GET['id'] == $_SESSION['id'])
    {
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('head.php');?>
    <title><?php echo $_SESSION['pseudo']; ?></title>
</head>
<body>
        <?php include('menuPHP.php'); ?>
        <?php 
            $requete_miniature = $bdd -> prepare('SELECT * FROM membres WHERE id = ?');
            $requete_miniature -> execute(array($_SESSION['id']));
            $miniature = $requete_miniature -> fetch();
        ?>
        <div style="margin-left: 25vw; margin-top: 1vw;">
            <div style="
            background: url(miniatures/<?php echo $miniature['miniature']; ?>) no-repeat;
            background-size: 50vw;
            width: 50vw;
            height: 20vw;
            border-radius: 1vw 1vw 0vw 0vw;
            "></div>
                            <div style="
                            display: flex;
                            justify-content: center;
                            width: 50vw;
                            height: 8vw;
                            background-color: rgba(0,0,0,0.8);
                            border-radius: 0vw 0vw 1vw 1vw;
                            ">
                            
                                <img src="<?php echo $_avatar; ?>" style="
                                width: 10vw; 
                                height: 10vw;
                                border: 0.1vw solid white;
                                margin-top: -5vw;
                                margin-left: -24%;
                                border-radius: 50%;
                                ">
                            </form>
                                <span style="
                                font-family: arial;
                                font-size: 1.3vw;
                                margin-top: -4.2vw;
                                ">
                               <table>
                                    <tr>
                                        <td style="color: white; font-family: Arial; font-size: 2vw;">
                                            <?php echo $_SESSION['pseudo'];?>
                                            </span>
                                        </td>
                                        <td>
                                        <form method="POST">
                                    <input name="edition" type="submit" style="
                                    height: 1.5vw;
                                    font-size: 0.8vw;
                                    position: relative;
                                    margin-left: -4vw;
                                    border: 0.05vw solid rgba(0,0,0,0.2);
                                    box-shadow: 0.1vw 0.1vw 0.2vw black;
                                    border-radius: 0.2vw 0.2vw 0.2vw 0.2vw;
                                    background-color: rgba(0,0,0,0.5);
                                    color: white;
                                    font-family: Arial;
                                    cursor: pointer;
                                    " value="Modifier le profil">
                                </form>
                                </td>
                                    </tr>
                                    <tr>
                                        <td><br>
                                        <span style="
                                        font-size: 0.8vw; 
                                        color: white;
                                        font-family: Arial;
                                        ">
                                            <?php echo 'Niveau <span style="font-weight: bold;">'.$lvl['lvl'].'</span>'; ?>
                                            </span>
                                        <span style="
                                        color: black;
                                        font-size: 0.8vw;
                                        margin-left: 1vw;
                                        font-family: Arial;
                                        ">
                                                <?php echo '<span style="font-weight: bold;"><a href="amis.php?id='.$_SESSION['id'].'&pseudo='.$_SESSION['pseudo'].'"></span><span style="color: white"><b>'.$nb_amis.'</b>'.$_amis.'</span></a>'; ?>
                                            </span>
                                        </td>
                                        </tr>
                                    <tr>
                                        <td>
                                            <?php 
                                                $requete_bio = $bdd -> prepare('SELECT * FROM membres WHERE id = ?');
                                                $requete_bio -> execute(array($_SESSION['id']));
                                                $bio = $requete_bio -> fetch();
                                                echo '<p style="
                                                color: white;
                                                font-family: bello;
                                                font-size: 0.6vw; 
                                                ">'.$bio['bio'].'</p>';
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                <?php
                }
                else
                {
                    echo '<h1 style="color: red;"> Erreur dans l\'url !</h1>';
                }
                ?>
            </div>
        </div>
            
</body>
</html>