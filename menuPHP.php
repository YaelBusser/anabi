<?php
	$q_avatar = $bdd -> prepare('SELECT * FROM membres WHERE id = ?');
	$q_avatar -> execute(array($_SESSION['id']));
	$r_avatar = $q_avatar -> fetch();
	if(!empty($r_avatar['avatar']))
	{
		$_avatar = 'avatars/'.$r_avatar['avatar'].'';
	}
	else
	{
		$_avatar = 'images/profil.png';
	}

?>
<head>
	<meta charset="UTF-8">
	<?php include('head.php');?>
</head>
<nav>
		<div
		style="
		border: 0.05vw solid rgba(0, 0, 0, 0.2);
		width: 105.3vw;
		height: 5vw;
		margin-top: -1vw;
		margin-left: -2vw;
		background-color: rgba(0,0,0,0.5)
		"
		>

		<div style="
		display: flex;
		margin-left: 20vw;
		">
					<h1 style="color: black; margin-top: 1.3vw;"><a href=""><span style="font-family: bello; font-size: 1.25vw;">Anabi</span></h1>
					</a>
					<span style="margin-left: 20vw; margin-top: 1.7vw;">
						<?php include('search.php'); ?>
					</span>	

					<a href="profil.php?id=<?php echo $_SESSION['id']; ?>" style=" margin-top: 1vw; margin-left: 17vw;"><img src="<?php echo $_avatar; ?>" style="width: 2.5vw; height: 2.5vw; border-radius: 50%;" alt="Profil" title="Profil"></a>
					
					<a href="amis.php?id=<?php echo $_SESSION['id']; ?>&pseudo=<?php echo $_SESSION['pseudo']; ?>" style="margin-top: 0.7vw; margin-left: 2vw;"><img src="images/amis.png" style="width: 3vw; height: 3vw;" alt="Amis" title="Amis"></a>
					
					<a href="deconnexion.php" style="margin-top: 1.2vw; margin-left: 20vw;"><img src="images/deconnexion.png" style="width: 2vw; height: 2vw;" alt="Se déconnecter" title="Se déconnecter"></a>
		</div>

</nav>

