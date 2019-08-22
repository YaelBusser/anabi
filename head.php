<?php 
if(isset($_SESSION['id']))
{
        $requete_wallpaper = $bdd -> prepare('SELECT * FROM theme WHERE pseudo = ? ');
        $requete_wallpaper -> execute(array($_SESSION['pseudo']));
        $wallpaper = $requete_wallpaper -> fetch();
}

?>
<head>
        <meta charset="UTF-8">
        <meta content="no-cache">
        <link rel="stylesheet" type="text/css" href="css.css">
        <link rel="icon" type="icon" href="images/logo_web.png">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
</head>
<body style="
        background: url('wallpaper/<?php if(isset($_SESSION['id'])){ echo $wallpaper['wallpaper']; }?>') fixed no-repeat;
    ">
