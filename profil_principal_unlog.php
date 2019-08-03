<?php
include('index.php');   
?>
<!DOCTYPE html>
<html>
    <head>
        <title>.....</title>
    </head>
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