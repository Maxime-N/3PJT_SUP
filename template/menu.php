<?php
$nbr = rand(); //génère un nombre aléatoire
$connexionUtilisateur = connexion($connect, $nbr);


//Ajoute la classe active à l'onglet du menu correspondant à la page affichée
$urlActive = $_SERVER['REQUEST_URI'];
if (strpos($urlActive, "=") == false) {
	$valeur = "home";
} else  {
	$composants = explode('=', $urlActive);
	$valeur = $composants[1];
}

//Gestion du langage
$lang = langage();

//Contenu traduit
include('translation/menuT.php');
?>

<!-- ====== NAVIGATION ====== -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">								    					
				<!------- Logo -------->
				<div class="navbar-header">
					<div class="logo"></div>
					
					<!------- Menu -------->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>	
				<div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
						<li class="<?php if ($valeur == "home") {echo "active"; } else  {echo "noactive";}?>"><a href="?page=home"><?php echo $tabTexteMenu[0]; ?></a></li>
						<?php
						if ($connexionUtilisateur == $nbr){
						?>
							<li class="<?php if ($valeur == "messageContact") {echo "active"; } else  {echo "noactive";}?>"><a href="?page=messageContact"><?php echo $tabTexteMenu[1]; ?></a></li>
							<li class="<?php if ($valeur == "compte") {echo "active"; } else  {echo "noactive";}?>"><a href="?page=compte"><?php echo $tabTexteMenu[2]; ?></a></li>
						<?php
						}
						?>
                    </ul>
					
					<!------- form selection langage -------->
					<!-- <div class="navbar-right"> -->	
						<form class="navbar-form navbar-right" method="post">
							<select name="lang" onchange="this.form.submit();">
								<?php	
								if ($lang == ""){
								?>
									<option><?php echo $tabTexteMenu[8]; ?></option>
									<option>Fr</option>
									<option>En</option>	
								<?php
								} elseif ($lang == "En") {
								?>
									<option><?php echo $lang; ?></option>
									<option>Fr</option>	
								<?php
								} else {
								?>
									<option><?php echo $lang; ?></option>
									<option>En</option>	
								<?php
								}
								?>																
																								
							</select>
							<input type="hidden" name="formlang" value="1"/>
						</form>
					<!-- </div> -->
				
					<!------- form de connection -------->
					<form class="navbar-form navbar-right" method="post" action="?page=home">
						<?php
						if ($connexionUtilisateur == $nbr){ // Il y a connexion si la valeur est égale au nbr aléatoire
							$pseudo = lireDonneeSession("pseudo", "");							
							echo $tabTexteMenu[7]." ". $pseudo . " !";
						?>
							<form method="post">
								<input type="hidden" name="formdeconnexion" value="1"/>
								<button type="submit" class="btn btn-primary"><?php echo $tabTexteMenu[6]; ?></button>
							</form>
						<?php
						} else {
						?>
							<div class="form-group">
								<input type="text" name="pseudo" placeholder="<?php echo $tabTexteMenu[3]; ?>" class="form-control">
							</div>
							<div class="form-group">
								<input type="password" name="motdepasse" placeholder="<?php echo $tabTexteMenu[4]; ?>" class="form-control">
							</div>
							<input type="hidden" name="formconnexion" value="1"/>
							<button type="submit" class="btn btn-primary"><?php echo $tabTexteMenu[5]; ?></button>
						<?php
						}
						?>
					</form>
				</div>
			</div>
        </nav>
<!-- ====== NAVIGATION ====== -->