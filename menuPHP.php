<?php?>
<head>
	<meta charset="UTF-8">
	<?php include('head.php');?>
</head>
<nav>
	<div class="bandeHaut">
		<span class="floatLeft">
			<a href="accueil.php?id=<?php echo $_SESSION['id']; ?>"><img src="images/logo.png" class="sizeLogo"></a>
		</span>
		<div class="flexMenu">
			<a href="accueil.php?id=<?php echo $_SESSION['id']; ?>">
				<h1 class="txtFloat">
					<i>
						A unique 
						<br>
						 gaming social 
						<br>
						<span class="sizeXP">experience</span>
					</i>
					<br>
					<span class="nabi" style="
					color: #9b59d9; 
					text-shadow: 0 0 3px black, 0 0 3px black;
					">nabi</span>
				</h1>
			</a>
			<div class="menu flexMenu">
				<h1 class="sizeMenu marginMenu" style="font-size: 1vw;"><a href="accueil.php?id=<?php echo $_SESSION['id']; ?>">Accueil</a></h1>
				<h1 class="sizeMenu marginMenu" style="font-size: 1vw;"><a href="profil.php?id=<?php echo $_SESSION['id']; ?>">Mon Profil</a></h1>
				<div class="sizeMenu marginMenu">
					<?php include('search.php'); ?>
				</div>
				<h1 class="sizeMenu marginMenu" style="font-size: 1vw;"><a href="amis.php?id=<?php echo $_SESSION['id']; ?>&pseudo=<?php echo $_SESSION['pseudo']; ?>">Mes amis</a></h1>
				<h1 class="sizeMenu marginMenu" style="font-size: 1vw;"><a href="deconnexion.php">Se déconnecter</a></h1>
			</div>
		</div>
	</div>
</div>
</nav>
