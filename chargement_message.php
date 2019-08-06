<?php
    session_start();
                include('bdd.php');
                        $requete = $bdd -> prepare('SELECT * FROM chat WHERE pseudo1 = ? AND pseudo2 = ? OR pseudo1 = ? AND pseudo2 = ? ORDER BY id DESC LIMIT 0, 10');
                        $requete -> execute(array($_SESSION['pseudo1Get'], $_SESSION['pseudo2Get'], $_SESSION['pseudo2Get'], $_SESSION['pseudo1Get']));
                        $requete = $requete -> fetchAll();
                        $requete = array_reverse($requete);
                        foreach($requete as $chat)
                        {
                            if($chat['pseudo1'] == $_SESSION['pseudo'])
                            {
                                    $margin = 'margin-left: 13vw;';
                                    $margin_date = 'margin-left: 23vw;';
                            }
                            else
                            {
                                $margin = 'margin-left: 0.45vw;';
                                $margin_date = 'margin-left: 1vw;';
                            }
                            $dateA = new DateTime($chat['dateA']);
                            $dateAA = $dateA -> format('d/m/Y');
                            echo '<p style="font-size: 0.5vw; color: rgba(0,0,0,0.5);'.$margin_date.'"><i>Le '.$dateAA.' à '.$chat['dateH'].'</i><p style="'.$margin.'
                            background-color: #4d4d4d;
                            width: 16vw;
                            color: white;
                            font-size: 1vw;
                            padding-left: 0.5vw;
                            padding-top: 0.1vw;
                            border-radius: 1vw 1vw 1vw 1vw;
                            ">'.htmlspecialchars($chat['msg']).'</p>';
                        }
                    ?>
