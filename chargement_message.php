<?php
    session_start();
                include('bdd.php');
                        $requete = $bdd -> prepare('SELECT * FROM chat WHERE pseudo1 = ? AND pseudo2 = ? OR pseudo1 = ? AND pseudo2 = ? ORDER BY id DESC LIMIT 0, 20');
                        $requete -> execute(array($_SESSION['pseudo1Get'], $_SESSION['pseudo2Get'], $_SESSION['pseudo2Get'], $_SESSION['pseudo1Get']));
                        $requete = $requete -> fetchAll();
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
