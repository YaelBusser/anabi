

    <form method="GET" name="formSearch" action="recherche_pseudo.php">
        <input type="search" name="pseudo" placeholder="Rechercher un pseudo" value="<?php if(!empty($_GET['pseudo'])){ echo $_GET['pseudo']; } ?>">
        <input type="submit" name="btnSearch" value="Rechercher">
    </form>