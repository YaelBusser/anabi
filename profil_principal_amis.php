<?php
    session_start();
    include('bdd.php');
    include('menuPHP.php');
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
        <?php include('head.php');?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    </head>
    <body style="
        background: url('images/wallpaper.jpg') fixed no-repeat;
    ">
    <div style="
    display: flex;
    ">
        <div style="
    width: 15vw;
    margin-left: 8vw;
    margin-top: 1vw;
    ">
    <div style="
    display: flex;
    flex-direction: column;
    ">
        <h1 style="
        color: white;
        text-align: center;
        font-family: bello;
        font-size: 2vw;
        background-color: rgba(0,0,0,0.5);
        ">Amis</h1>
        <div style="
            margin-top: -1.15vw;
            height: 34.2vw;
            overflow: hidden;
            background-color: rgba(0,0,0,0.5);
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
                    color: white;
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
                    '.$pseudo.'
                    </a>
                    </span>
                    <!--
                        <form method="POST" action="">
                            <input type="submit" style="width: 1.25vw; margin-left: 2vw; color: black" name="supp'.$amis['pseudo2'].'" value="X">
                        </form>
                    -->
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
        <div style="
        display: flex;
        margin-top: 2.35vw;
        margin-left: 0.2vw;
        ">
        <div style="
                
        ">
            <div
            id="scroll"
             style=" 
                width: 50vw;
                height: 35vw;
                font-size: 1vw;
                overflow: scroll;
                overflow-x: hidden;
             "
            >
                <div id="message">
                    <?php
                        $requete = $bdd -> prepare('SELECT * FROM chat WHERE pseudo1 = ? AND pseudo2 = ? OR pseudo1 = ? AND pseudo2 = ? ORDER BY id DESC LIMIT 0, 10');
                        $requete -> execute(array($_SESSION['pseudo'], $_GET['pseudo2'], $_GET['pseudo2'], $_SESSION['pseudo']));
                        $requete = $requete -> fetchAll();
                        $_SESSION['pseudo1Get'] = $_GET['pseudo1'];
                        $_SESSION['pseudo2Get'] = $_GET['pseudo2'];
                        $requete = array_reverse($requete);
                        foreach($requete as $chat)
                        {
                            $requete_membre = $bdd -> prepare('SELECT * FROM membres WHERE pseudo = ?');
                            $requete_membre -> execute(array($chat['pseudo1']));
                            $membre = $requete_membre -> fetch();

                            $dateA = new DateTime($chat['dateA']);
                            $dateAA = $dateA -> format('d/m/Y');
                            echo '
                    <div style="border-top: 1px solid rgba(0,0,0,0.1); width: 50vw; background-color: rgba(0,0,0,0.5)"> 
                        <table>   
                                    <tr>
                                        <td>
                                           <img src="avatars/'.$membre['avatar'].'" style="
                                                width: 2vw;
                                                height: 2vw;
                                                border-radius: 50%;
                                            ">
                                        </td>
                                        
                                        <td>
                                            <span style=" color: white; font-size: 1vw; font-family: whitney;">'.$chat['pseudo1'].'</span>
                                            <span style="font-size: 0.5vw; color: #bf80ff;">Le '.$dateAA.' à '.$chat['dateH'].'</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            
                                        </td>
                                        
                                        <td>
                                            <span style="width: 16vw; color: rgba(255,255,255,0.7); font-size: 0.vw; font-family: arial;">'.htmlspecialchars($chat['msg']).'</span>
                                        </td>
                                    </tr>
                        </table>
                    </div>
                    ';
                        }
                    ?>
                </div>
                </div>
                        <div>
                            <form method="POST" name="chat">
                                <div style="
                                border-top: 0.01vw solid rgba(0,0,0,1);
                                padding-top: 0.5vw;
                                background-color: rgba(0,0,0,0.5);
                                ">
                                    <input type="textarea" name="msg" class="chat" placeholder="Envoyer un message à <?php echo $_GET['pseudo2']; ?>"
                                    style="
                                    width: 47vw;
                                    height: 1.3vw;
                                    font-family: arial;
                                    resize: none;
                                    border-radius: 0.5vw 0.5vw 0.5vw 0.5vw;
                                    outline: none;
                                    padding-left: 1vw;
                                    -webkit-appearance: none;
                                    border: none;
                                    margin-left: 2.2vw;
                                    margin-bottom: 0.5vw;
                                    background-color: rgba(0,0,0,0.5);
                                    color: white;
                                    "
                                    autocomplete="off"
                                    >
                                    </div>
                                    <input type="submit" name="btnEnvoyer" src="images/envoyer.png" style="
                                        width: 1vw;
                                        height: 1vw;
                                        border: 1px solid rgba(0,0,0,0);
                                        background-color: rgba(0,0,0,0);
                                        z-index: 2;
                                        cursor: pointer;
                                        position: absolute;
                                    " value="">
                            </form>
                        </div>
    </div>

            
    </body>
    <script type="text/javascript">
        setInterval('chargement_message()', 500);
        function chargement_message()
        {

        	$('#message').load('chargement_message.php');
        
        }
		document.chat.msg.focus();
        element = document.getElementById('scroll');
		element.scrollTop = element.scrollHeight;
</script>
</html>