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
                                $margin = 'margin-left: 17vw;';
                            }
                            else
                            {
                                $margin = 'margin-left: 0;';
                            }
                            echo '<p style="'.$margin.'">'.$chat['msg'].'</p>';
                        }
                    ?>