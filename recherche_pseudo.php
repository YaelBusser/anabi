<?php
    session_start();
    include('bdd.php');
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('head.php');?>
</head>
    <body>
        <?php include('menuPHP.php') ?>
            <h1 class="centre" style="text-decoration: underline;">Recherche de pseudo :</h1>
            <div style="width: 20vw; background-color: #F7941D; margin: auto;">
            <table align="center">
                <?php
                if(isset($_GET['btnSearch']))
                {
                    $_GET['pseudo'] = htmlspecialchars($_GET['pseudo']);
                    if(!empty($_GET['pseudo']))
                    {
                    $requete_search = $bdd -> prepare('SELECT * FROM membres WHERE pseudo LIKE ? ORDER BY id ');
                    $requete_search -> execute(array('%'.$_GET['pseudo'].'%'));
                    $q_exist = $requete_search -> rowCount();
                        if($q_exist > 0)
                        { 
                    ?> 
                            <?php 

                                    foreach($requete_search as $pseudo)
                                    {
                                        echo '<tr><td><p><a href="profil_principal.php?id='.$pseudo['id'].'&pseudo='.$pseudo['pseudo'].'&email='.$pseudo['email'].'&jeux='.$pseudo['jeux'].'&sexe='.$pseudo['sexualite'].'&age='.$pseudo['age'].'">-'.$pseudo['pseudo'].'</a></p></td></tr></li>';
                                       $q_pseudo = $bdd -> prepare('SELECT * FROM membres WHERE pseudo');
                                       $q_pseudo -> execute(array($_GET['pseudo']));
                                       $q_peudoo = $q_pseudo -> fetch();
                                        $_SESSION['id_recherche'] = $q_peudoo['id'];
                                        $_SESSION['pseudo_recherche'] = $q_peudoo['pseudo'];
                                        $_SESSION['email_recherche'] = $q_peudoo['email'];
                                        $_SESSION['jeux_recherche'] = $q_peudoo['jeux'];
                                        $_SESSION['sexe_recherche'] = $q_peudoo['sexualite'];
                                        $_SESSION['age_recherche'] = $q_peudoo['age'];
                                    }

                                ?>
                                <?php 
                                } 
                                else
                                {
                                    echo  '<tr><td><p style="color: red; background-color: white;">Aucun résultat pour '.$_GET['pseudo'].'</p></td></tr>';
                                }
                        }
                        else
                        {
                            echo  '<tr><td><p style="color: red; background-color: white;">Veuillez entrer un pseudo !</p></td></tr>';
                        }
                }
                ?>
                </div>
            </table>
    </body>
</html>
