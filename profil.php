<?php
    session_start();
    if(isset($_POST['edition']))
    {
        header('Location: edition_profil.php');
    }
    if(isset($_POST['btnMdp']))
    {
        header('Location: update_mdp.php');
    }
    if(isset($_POST['btnAvatar']))
    {
        header('Location: modif_avatar.php');
    }
    if($_SESSION['age'] == 1 )
    { 
        $ageAn = 'an';
    } 
    else 
    {
        $ageAn = 'ans';
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
<nav>
        <div class="bandeHaut">
            <span class="floatLeft">
                <a href="accueil.php?id=<?php echo $_SESSION['id']; ?>"><img src="images/logo.png" class="sizeLogo"></a>
            </span>
            <div class="flexMenu">

            <a href="accueil.php?id=<?php echo $_SESSION['id']; ?>"><h1 class="txtFloat"><i>A unique <br> gaming social <br> <span class="sizeXP">experience</span></i> <br><span class="nabi">nabi</span></h1></a>
                    
                <div class="menu flexMenu">

                    
                        <h1 class="sizeMenu marginMenu" style="font-size: 1vw;"><a href="accueil.php?id=<?php echo $_SESSION['id']; ?>">Accueil</a></h1>
                  
                        <h1 class="sizeMenu marginMenu" style="font-size: 1vw;"><a href="profil.php?id=<?php echo $_SESSION['id']; ?>">Mon Profil</a></h1>
                    
                    <div class="sizeMenu marginMenu">
                        <?php include('search.php'); ?>
                    </div>
                        <h1 class="sizeMenu marginMenu" style="font-size: 1vw;"><a href="amis.php?id=<?php echo $_SESSION['id']; ?>&pseudo=<?php echo $_SESSION['pseudo']; ?>">Mes amis</a></h1>
                  
                        <h1 class="sizeMenu marginMenu" style="font-size: 1vw;"><a href="deconnexion.php">Se déconnecter</a></h1>
                   </div>
              
            </div>
        </div>
    </div>
    </nav>
    <h1 class="centre"><?php echo $_SESSION['pseudo'];?></h1>
    <table align="center">

        <tr>
            <td class="td">
                Pseudo:
            </td>
            <td>
                <?php echo $_SESSION['pseudo'];?>
            </td>
        </tr>
        <tr>
            <td class="td">
                Email:
            </td>
            <td>
                <?php echo $_SESSION['email'];?>
            </td>
        </tr>
        <tr>
            <td class="td">
                Style de jeux:
            </td>
            <td>
                <?php echo $_SESSION['jeux'];?>
            </td>
        </tr>
        <tr>
            <td class="td">
                Sexe:
            </td>
            <td>
                <?php echo $_SESSION['sexualite'];?>
            </td>
        </tr>
        <tr>
            <td class="td">
                Age :
            </td>
            <td>
                 <?php echo $_SESSION['age']; ?> <?php echo $ageAn ?>
            </td>
        </tr>
        <tr>
            <td>
                
            </td>
        <form method="POST">
            <td>
                <input name="edition" type="submit" value="Modifier le profil">
            </td>
        </form>
        </tr>

    </table><br><br>
    <form method="POST" align="center">
        <input type="submit" name="btnMdp" value="Changer de mot de passe">
            <br><br>
        <input type="submit" name="btnAvatar" value="Changer d'avatar">
    </form>
<?php
}
else
{
    echo '<h1 style="color: red;"> Erreur dans l\'url !</h1>';
}
?>
</body>
</html>