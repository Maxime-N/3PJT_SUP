
<?php
//Contenu traduit
include('translation/compteT.php');
?>

<div class="row">
    <div class="container">
	    <?php

			$updateDataUser = lireDonneePost("updateDataUser", "");
			if ($updateDataUser == 1){
				updateUser($connect);
			}
			
			// ----- affichage des données utilisateur -----
			
			$res = donneesUser($connect);

			$nom = $res["nom"];
			$prenom = $res["prenom"];
			$email = $res["email"];
			$username = $res["pseudo"];
			$userId = $res["idutilisateur"];
			

			$lienImageAvatar = imageAffichage($connect, "avatar", $userId);
			?>
			<div class="avatar">
				<img src="<?php echo $lienImageAvatar ?>" />
			</div>
			<?php

			// permet de télécharger l'image sur le serveur et enregister le chemin dans la base de données
			$modifierImg = lireDonneePost("modifierImg", "");
			if ($modifierImg == 1) {
				modifierImg($connect, $userId);
			}


			// permet d'ajouter un utilisateur à ces contact dans la base de données
			$addUser = lireDonneePost("addUser", "");
			if ($addUser == 1) {
				addUser($connect, $userId);
			}

			// permet de supprimer un contact
			$supprimerContact = lireDonneePost("supprimerContact", "");
			if ($supprimerContact == 1) {
				supprimerContact($connect, $userId);
			}

			// affichage des informations utilisateur
			?><p><?php echo $tabTexteCompte[9]."<br>";
			echo $tabTexteCompte[10].$nom."<br>";
			echo $tabTexteCompte[11].$prenom."<br>";
			echo $tabTexteCompte[12].$email."<br>";
			echo $tabTexteCompte[13].$username; 
			?></p>

		<div class="col-sm-3">
		
			<!-- bouton modification mot de passe -->
			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#passwordModal">
			 	<?php echo $tabTexteCompte[0]; ?>
			</button>
			<!-- bouton modification Nom Utilisateur/E-mail -->
			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#generalDataModal">
			 	<?php echo $tabTexteCompte[14]; ?>
			</button>
			<!-- bouton modification Avatar/Images de fond -->
			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#imgModal">
			 	<?php echo $tabTexteCompte[15]; ?>
			</button>
			<!-- bouton ajouter contact -->
			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#findUserModal">
			 	<?php echo $tabTexteCompte[16]; ?>
			</button>
						
			
			<!-- Modal motdepasse-->
			<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  	<div class="modal-dialog">
			    	<div class="modal-content">
				      	<div class="modal-header">
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        	<h4 class="modal-title" id="myModalLabel"><?php echo $tabTexteCompte[0]; ?></h4>
				      	</div>
				      	<div class="modal-body">
				      		<form method="post" role="form" data-toggle="validator">
								<fieldset>
									<div class="form-group">
										<input type="password" name="oldPassword" placeholder="<?php echo $tabTexteCompte[2]; ?>" class="form-control">
									</div>
									<div class="form-group">
										<input type="password" name="newPassword" placeholder="<?php echo $tabTexteCompte[3]; ?>" class="form-control" id="matchingNewPasswords" data-error="<?php echo $tabTexteCompte[7]; ?>" data-minlength="6">
										<div class="help-block with-errors"></div>
									</div>
									<div class="form-group">
										<input type="password" name="confNewPassword" placeholder="<?php echo $tabTexteCompte[4]; ?>" class="form-control" data-match="#matchingNewPasswords" data-match-error="<?php echo $tabTexteCompte[8]; ?>" data-error="<?php echo $tabTexteCompte[7]; ?>">
										<div class="help-block with-errors"></div>
									</div>
								</fieldset>
								<div class="modal-footer">
						      		<input type="hidden" name="updateDataUser" value="1"/>
						        	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $tabTexteCompte[5]; ?></button>
						        	<button type="submit" class="btn btn-primary"><?php echo $tabTexteCompte[6]; ?></button>
						      	</div>
							</form>
				      	</div>
			    	</div>
			  	</div>
			</div>
			
			<!-- Modal nom/e-mail/nom utilisateur-->
			<div class="modal fade" id="generalDataModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  	<div class="modal-dialog">
			    	<div class="modal-content">
				      	<div class="modal-header">
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        	<h4 class="modal-title" id="myModalLabel"><?php echo $tabTexteCompte[14]; ?></h4>
				      	</div>
				      	<div class="modal-body">
				      		<form method="post" role="form" data-toggle="validator">
								<fieldset>
									<div class="form-group">
										<input type="email" name="newEmail" placeholder="<?php echo $tabTexteCompte[1]; ?>" class="form-control">
									</div>
									<hr />
									<div class="form-group">
										<input type="text" name="newUsername" placeholder="<?php echo $tabTexteCompte[17]; ?>" class="form-control">
									</div>
								</fieldset>
								<div class="modal-footer">
						      		<input type="hidden" name="updateDataUser" value="1"/>
						        	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $tabTexteCompte[5]; ?></button>
						        	<button type="submit" class="btn btn-primary"><?php echo $tabTexteCompte[6]; ?></button>
						      	</div>
							</form>
				      	</div>
			    	</div>
			  	</div>
			</div>

			<!-- c'est le formulaire de modification de l'avatar et image de fond, pour pouvoir modifier le text
			du bouton des <input type="file"> il fallait créer un autre bouton faisant appel à se input qui
			a été mi en visibility:hidden et si les <input> avait été intégré dans le formulaire cela aurais laissé
			une zone vide-->
			<form method="post" name="formImg" role="form" data-toggle="validator" style="visibility:hidden" enctype="multipart/form-data">
				<input type="file" accept="image/png,image/jpeg" name="newAvatar" id="imgAvatar" onchange="fileAvatarSelected();"/>
				<input type="file" accept="image/png,image/jpeg" name="newBackground" id="imgBackground" onchange="fileBackgroundSelected();"/>
				<input type="hidden" name="modifierImg" value="1"/>		
			</form>
			
			<!-- Modal avatar / image de fond-->
			<div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  	<div class="modal-dialog">
			    	<div class="modal-content">
				      	<div class="modal-header">
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        	<h4 class="modal-title" id="myModalLabel"><?php echo $tabTexteCompte[15]; ?></h4>
				      	</div>
				      	<div class="modal-body">
							<fieldset>
								<div class="form-group">	
									<input type="button" value="<?php echo $tabTexteCompte[18]; ?>" onclick="$('#imgAvatar').click();">
									<p style="color:black" id="txtAvatar"></p>
									<img src="" alt="" id="avatarImage" style="max-width:150px;"></img>	
								</div>
								<hr />
								<div class="form-group">
									<input type="button" value="<?php echo $tabTexteCompte[19]; ?>" onclick="$('#imgBackground').click();">
									<p style="color:black" id="txtBackground"></p>
									<img src="" alt="" id="backgroundImage" style="max-width:300px;"></img>
								</div>
							</fieldset>
							<div class="modal-footer">
						      	<input type="hidden" name="updateDataUser" value="1"/>
						      	<button type="button" class="btn btn-default" onclick="viderImg();"><?php echo $tabTexteCompte[21]; ?></button>
						        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="viderImg();"><?php echo $tabTexteCompte[5]; ?></button>
						        <button type="submit" class="btn btn-primary" onclick="document.forms['formImg'].submit();"><?php echo $tabTexteCompte[6]; ?></button>
						     </div>
				      	</div>
			    	</div>
			  	</div>
			</div>
			
			<!-- Modal ajout utilisateur -->
			<div class="modal fade" id="findUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  	<div class="modal-dialog">
			    	<div class="modal-content">
				      	<div class="modal-header">
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        	<h4 class="modal-title" id="myModalLabel"><?php echo $tabTexteCompte[16]; ?></h4>
				      	</div>
				      	<div class="modal-body">
							<form method="post" role="form" data-toggle="validator">
								<fieldset>
									<div class="form-group">
										<input type="text" name="addUserName" placeholder="<?php echo $tabTexteCompte[20]; ?>" class="form-control">
									</div>
								</fieldset>
								<div class="modal-footer">
						      		<input type="hidden" name="addUser" value="1"/>
						        	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $tabTexteCompte[5]; ?></button>
						        	<button type="submit" class="btn btn-primary"><?php echo $tabTexteCompte[22]; ?></button>
						      	</div>
							</form>
				      	</div>
			    	</div>
			  	</div>
			</div>		
		</div>

		<!-- Modal supprimer contact -->
			<div class="modal fade" id="supprimerContactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title" id="myModalLabel"><?php echo $tabTexteCompte[27]; ?></h4>
					      </div>
					      <div class="modal-body">
					      	<form method="post" role="form" data-toggle="validator">
								<fieldset>
									<div class="form-group">
										<?php echo $tabTexteCompte[28]; ?>
									</div>
								</fieldset>
								<div class="modal-footer">
							      	<input type="hidden" name="supprimerContact" value="1"/>
							      	<input type="hidden" id="idContact" name="idContact" value=""/>
							        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $tabTexteCompte[29]; ?></button>
							        <button type="submit" class="btn btn-primary"><?php echo $tabTexteCompte[30]; ?></button>
							    </div>
							</form>
					      </div>
				    </div>
				  </div>
			</div>


		<!--******************  ZONE DES CONTACTS SUIVI *******************-->
		


		<div class="zoneContact">
			<div class="titreContact">
				<h4 style="color:white;"><?php echo $tabTexteCompte[23]; ?></h4>
			</div>


			<?php

				//requete pour récupérer les ids des contacts de l'utilisateur
				$req = $connect->prepare("SELECT id_contact FROM contact WHERE id_utilisateur = :userId");
				$req->execute(array('userId' => $userId));	

				// calcule le nbr d'id
				$result = $req->fetchAll();
				$nbrId = count($result);

				$req->execute(array('userId' => $userId));				

				//boucle qui affiche tous les contacts de l'utilisateur avec son avatar
				if ($nbrId != 0) {
					while($row = $req->fetch(PDO::FETCH_ASSOC)) {

						$idContact = $row['id_contact'];

						//requete qui récupère les pseudos correspondant à l'id des contacts
						$req = $connect->prepare("SELECT pseudo FROM utilisateur WHERE idutilisateur = :userId");
						$req->execute(array('userId' => $idContact));
						$res = $req->fetch();
						$pseudoContact = $res['pseudo'];

						//requete qui récupère l'avatar correspondant à l'id des contacts
						$req = $connect->prepare("SELECT avatar FROM image WHERE idutilisateur = :userId");
						$req->execute(array('userId' => $idContact));
						$res = $req->fetch();
						$avatarContact = $res['avatar'];

						if ($avatarContact != null) {
							$lienAvatarContact = "img/users/".$avatarContact;
						} else {
							$lienAvatarContact = "img/sansAvatar.png";
						}

						?>
						<div class="contact">
							<img src="<?php echo $lienAvatarContact ?>" />
							<div class="basContact">
								<div class="nomContact">
									<h4><?php echo $pseudoContact ?></h4>
								</div>
								<div class="boutonContact">
									<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#supprimerContactModal" onclick="idContact(<?php echo $idContact; ?>);" style="color:red">
									 	<?php echo "X" ?>
									</button>
								</div>
							</div>
						</div>
						<?php

					}
				} else {
					?><p><?php echo $tabTexteCompte[24]; ?></p><?php
				}										

			?>
		</div>


		<!--***********  ZONE DES CONTACTS QUI SUIVENT L'UTILISATEUR ************-->
		<div class="zoneContact" style="top:10px">

			<div class="titreContact">
				<h4 style="color:white;"><?php echo $tabTexteCompte[31]; ?></h4>
			</div>

			<?php

				//requete pour récupérer les ids des contacts qui suivent l'utilisateur
				$req2 = $connect->prepare("SELECT id_utilisateur FROM contact WHERE id_contact = :contactId");
				$req2->execute(array('contactId' => $userId));	

				// calcule le nbr d'id
				$result2 = $req2->fetchAll();
				$nbrId2 = count($result2);

				$req2->execute(array('contactId' => $userId));				

				//boucle qui affiche tous les contacts avec son avatar
				if ($nbrId2 != 0) {
					while($row2 = $req2->fetch(PDO::FETCH_ASSOC)) {

						$idutilisateur = $row2['id_utilisateur'];

						//requete qui récupère les pseudos correspondant à l'id des contacts
						$req2 = $connect->prepare("SELECT pseudo FROM utilisateur WHERE idutilisateur = :userId");
						$req2->execute(array('userId' => $idutilisateur));
						$res2 = $req2->fetch();
						$pseudoContact2 = $res2['pseudo'];

						//requete qui récupère l'avatar correspondant à l'id des contacts
						$req2 = $connect->prepare("SELECT avatar FROM image WHERE idutilisateur = :userId");
						$req2->execute(array('userId' => $idutilisateur));
						$res2 = $req2->fetch();
						$avatarContact2 = $res2['avatar'];

						if ($avatarContact2 != null) {
							$lienAvatarContact2 = "img/users/".$avatarContact2;
						} else {
							$lienAvatarContact2 = "img/sansAvatar.png";
						}

						?>
						<div class="contact">
							<img src="<?php echo $lienAvatarContact2 ?>" />
							<div class="basContact">
								<div class="nomContact" style="width:150px;">
									<h4><?php echo $pseudoContact2 ?></h4>
								</div>
							</div>
						</div>
						<?php

					}
				} else {
					?><p><?php echo "Aucun utilisateur ne vous suit"; ?></p><?php
				}										

			?>


		</div>
		

	</div>
</div>

<script>
	var txtAvatar = document.getElementById('txtAvatar');
	txtAvatar.innerHTML = "(jpg, png / 150x200px)";	

	// récupère les informations de l'avatar sélectionné
	function fileAvatarSelected() {
		var valueAvatar = document.getElementById('imgAvatar').files[0];
		var fileAvatar = valueAvatar.name;
		if (fileAvatar != ""){
			txtAvatar.innerHTML = fileAvatar;
			var avatarImg = document.getElementById('avatarImage');
			var urlAvatar = URL.createObjectURL(valueAvatar);
        	avatarImg.src = urlAvatar;
		}
	}

	var txtBackground = document.getElementById('txtBackground');
	txtBackground.innerHTML = "(jpg, png / 1920x1200px)";	

	// récupère les informations du fond d'écran sélectionné
	function fileBackgroundSelected() {
		var valueBackground = document.getElementById('imgBackground').files[0];
		var fileBackground = valueBackground.name;
		if (fileBackground != ""){
			txtBackground.innerHTML = fileBackground;
			var backgroundImg = document.getElementById('backgroundImage');
			var urlBackground = URL.createObjectURL(valueBackground);
        	backgroundImg.src = urlBackground;
		}
	}

	// Vide les informations des fichiers sélectionné
	function viderImg() {
		
		if (txtAvatar.innerHTML != "(jpg, png / 150x200px)") {
			var avatarImg = document.getElementById('avatarImage');	
			var valueAvatar = document.getElementById('imgAvatar').files[0].name;
			txtAvatar.innerHTML = "(jpg, png / 150x200px)";			
			avatarImg.src = "";
			valueAvatar = "";
		}
				
		if (txtBackground.innerHTML != "(jpg, png / 1920x1200px)") {
			var backgroundImg = document.getElementById('backgroundImage');
			var valueBackground = document.getElementById('imgBackground').files[0].name;
			txtBackground.innerHTML = "(jpg, png / 1920x1200px)";
			backgroundImg.src = "";
			valueBackground = "";			
		}

	}

	// récupère l'id du contact associé au bouton et l'intègre au input hidden du form
	function idContact(idcontact) {

			var inputIdMessage = document.getElementById('idContact');
			inputIdMessage.value = idcontact;

	}

</script>