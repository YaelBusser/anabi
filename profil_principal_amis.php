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
            <br><br><br>
            <h1 align="center"><?php echo $_GET['pseudo2']; ?></h1>
            <table align="center">
            <tr>
            <td>
            <div
             style=" 
                background-color: grey;
                width: 31vw;
                height: 20vw;
                margin: auto;
                font-size: 1vw;
                border-radius: 1vw 0 0 1vw;
                overflow: scroll;
                overflow-x: hidden;
             " id="scroll"
            >
                <div id="message">
                    <?php
                        $requete = $bdd -> prepare('SELECT * FROM chat WHERE pseudo1 = ? AND pseudo2 = ? OR pseudo1 = ? AND pseudo2 = ? ORDER BY id DESC LIMIT 0, 10');
                        $requete -> execute(array($_SESSION['pseudo'], $_GET['pseudo2'], $_GET['pseudo2'], $_SESSION['pseudo1']));
                        $requete = $requete -> fetchAll();
                        $_SESSION['pseudo1Get'] = $_GET['pseudo1'];
                        $_SESSION['pseudo2Get'] = $_GET['pseudo2'];
                        $requete = array_reverse($requete);
                        foreach($requete as $chat)
                        {
                            if($chat['pseudo1'] == $_SESSION['pseudo'])
                            {
                                $margin = 'margin-left: 18vw;';
                            }
                            else
                            {
                                $margin = 'margin-left: 0.45vw;';
                            }   
                            echo '<p style="'.$margin.'
                            background-color: #4d4d4d;
                            width: 16vw;
                            color: white;
                            font-size: 1vw;
                            padding-left: 0.5vw;
                            padding-top: 0.5vw;
                            border-radius: 0.5vw 0.5vw 0.5vw 0.5vw;
                            ">'.htmlspecialchars($chat['msg']).'</p>';
                        }
                    ?>
                    </td>
                    <td></td>
                    </div>
                </div>
                <tr>
                <td>
                        <form method="POST">
                                <textarea type="text" name="msg" class="chat" placeholder="Envoyer un message"
                                style="width: 30vw;"
                                
                                ></textarea>
                                </td>
                                <td>
                                <input type="submit" name="btnEnvoyer" value="Envoyer">
                        </form>
                    </td>
                    </tr>
                    </table>
            
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