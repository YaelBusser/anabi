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
    if(isset($_POST['btnEnvoyer']))    
    {
        $dateH = date('H:i:s');
        $dateA = date('Y:m:d');
        $chat_insert = $bdd -> prepare('INSERT INTO chat(pseudo1, pseudo2, msg, dateA, dateH) VALUES(?, ?, ?, ?, ?)');
        $chat_insert -> execute(array($_SESSION['pseudo'], $_GET['pseudo2'], $_POST['msg'], $dateA, $dateH));
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Profil de <?php echo $_GET['pseudo2']; ?></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    </head>
    <body>
        <h1 class="centre"><?php echo 'Profil de '.$_GET['pseudo2'].'';?></h1>
            <table align="center">
                <tr>
                    <td class="td">
                        Pseudo:
                    </td>
                    <td>
                        <?php echo $_GET['pseudo2'];?>
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
            </table>
            <br><br><br><br>
            <h1 align="center"><?php echo $_GET['pseudo2']; ?></h1>
            <div
             style=" 
                background-color: red;
                width: 25vw;
                height: 15vw;
                margin: auto;
                font-size: 1vw;
                border: 0.2vw solid black;
                overflow: scroll;
                overflow-x: hidden;
             " id="scroll"
            >
                <div id="message">
                    <?php
                        $requete = $bdd -> prepare('SELECT * FROM chat WHERE pseudo1 = ? AND pseudo2 = ? OR pseudo1 = ? AND pseudo2 = ? ORDER BY id DESC LIMIT 0, 10');
                        $requete -> execute(array($_GET['pseudo1'], $_GET['pseudo2'], $_GET['pseudo2'], $_GET['pseudo1']));
                        $requete = $requete -> fetchAll();
                        $_SESSION['pseudo1Get'] = $_GET['pseudo1'];
                        $_SESSION['pseudo2Get'] = $_GET['pseudo2'];
                        $requete = array_reverse($requete);
                        foreach($requete as $chat)
                        {
                            if($chat['pseudo1'] == $_SESSION['pseudo'])
                            {
                                $margin = 'margin-left: 17vw;';
                            }
                            else
                            {
                                $margin = 'margin-left: 0;';
                            }
                            echo '<p style="'.$margin.'">'.$chat['msg'].'</p>';
                        }
                    ?>
                </div>
                        <form method="POST">
                                <textarea type="text" name="msg" class="chat" placeholder="Envoyer un message"
                                style="width: 20vw;"
                                
                                ></textarea>
                                <input type="submit" name="btnEnvoyer" value="Envoyer">
                        </form>
            </div>
    </body>
    <script type="text/javascript">
        setInterval('chargement_message()', 500);
        function chargement_message()
        {

        	$('#message').load('chargement_message.php');
        
        }
		document.chat.msg.focus();
</script>
<script type="text/javascript">
				element = document.getElementById('scroll');
				element.scrollTop = element.scrollHeight;
</script> 
</html>