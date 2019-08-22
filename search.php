

    <form method="GET" name="formSearch" action="recherche_pseudo.php">
                <input type="search" name="pseudo" style="
                width: 10vw;
                height: 1vw;
                font-size: 0.7vw;
                border: 1px solid rgba(255, 255, 255, 0);
                " placeholder="Rechercher une personne..." value="<?php if(!empty($_GET['pseudo'])){ echo $_GET['pseudo']; } ?>">
                <input type="image" src="images/loop.png" name="btnSearch" style="
                width: 1vw;
                height: 0.6vw;
                margin-left: -11.6vw;
                ">
    </form>