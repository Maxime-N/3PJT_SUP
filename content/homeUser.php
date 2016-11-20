<?php
/*--------------Actualiser page firefox--------------
(éviter le message et le renvoi des mêmes éléments des formulaire)*/
//Première partie(sauvegarder les éléments)
if(!empty($_POST) OR !empty($_FILES))
{
    $_SESSION['sauvegarde'] = $_POST ;
    $_SESSION['sauvegardeFILES'] = $_FILES ;
    
    $fichierActuel = $_SERVER['PHP_SELF'] ;
    if(!empty($_SERVER['QUERY_STRING']))
    {
        $fichierActuel .= '?' . $_SERVER['QUERY_STRING'] ;
    }    
    header('Location: ' . $fichierActuel);
    exit;
}
//Seconde partie(remettre les éléments)
if(isset($_SESSION['sauvegarde']))
{
    $_POST = $_SESSION['sauvegarde'] ;
    $_FILES = $_SESSION['sauvegardeFILES'] ;  
    unset($_SESSION['sauvegarde'], $_SESSION['sauvegardeFILES']);
}
/*--------------------------------------*/

//Contenu traduit
include('translation/homeUserT.php');

// permet de télécharger l'image sur le serveur et enregister le chemin dans la base de données
$ajouterMessage = lireDonneePost("ajouterMessage", "");
if ($ajouterMessage == 1) {
	newMessage($connect, $userId);
	$ajouterMessage == 0;
}

$ajouterReponse = lireDonneePost("ajouterReponse", "");
if ($ajouterReponse == 1){
	addAnswer($connect, $userId);
}

$supprimerMessage = lireDonneePost("supprimerMessage", "");
if ($supprimerMessage == 1){
	supprimerMessage($connect, $userId);
}
?>

?>

<div class="row">
    <div class="container">	
    
			<!-- Modal new message -->
			<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title" id="myModalLabel"><?php echo $tabTexteHomeUser[2]; ?></h4>
					      </div>
					      <div class="modal-body">
					      	<form method="post" role="form" data-toggle="validator">
								<fieldset>
									<div class="form-group">
										<textarea rows="2" cols="100" maxlength="255" style="max-width:570px;" required="true" name="newMessage" id="newMessage" onkeypress="maxlength('newMessage');" ></textarea>
										<p id="nbrCararateres"></p>
									</div>
								</fieldset>
								<div class="modal-footer">
							      	<input type="hidden" name="ajouterMessage" value="1"/>
							        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $tabTexteHomeUser[3]; ?></button>
							        <button type="submit" class="btn btn-primary"><?php echo $tabTexteHomeUser[4]; ?></button>
							      </div>
							</form>
					      </div>
				    </div>
				  </div>
			</div>

			<!-- Modal réponse aux messagesRéponse -->
			<div class="modal fade" id="reponseMessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title" id="myModalLabel"><?php echo $tabTexteHomeUser[5]; ?></h4>
					      </div>
					      <div class="modal-body">
					      	<form method="post" role="form" data-toggle="validator">
								<fieldset>
									<div class="form-group">
										<textarea rows="2" cols="100" maxlength="255" style="max-width:570px;" required="true" name="newReponseMessage" id="newReponseMessage" onkeypress="maxlength('newReponse');"></textarea>
									</div>
								</fieldset>
								<div class="modal-footer">
							      	<input type="hidden" name="ajouterReponse" value="1"/>
							      	<input type="hidden" id="idMessage" name="idMessage" value=""/>
							        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $tabTexteHomeUser[6]; ?></button>
							        <button type="submit" class="btn btn-primary"><?php echo $tabTexteHomeUser[7]; ?></button>
							    </div>
							</form>
					      </div>
				    </div>
				  </div>
			</div>

			<!-- Modal supprimer messages -->
			<div class="modal fade" id="supprimerMessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title" id="myModalLabel"><?php echo $tabTexteHomeUser[8]; ?></h4>
					      </div>
					      <div class="modal-body">
					      	<form method="post" role="form" data-toggle="validator">
								<fieldset>
									<div class="form-group">
										<?php echo $tabTexteHomeUser[9]; ?>
									</div>
								</fieldset>
								<div class="modal-footer">
							      	<input type="hidden" name="supprimerMessage" value="1"/>
							      	<input type="hidden" id="idMessage2" name="idMessage" value=""/>
							        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $tabTexteHomeUser[10]; ?></button>
							        <button type="submit" class="btn btn-primary"><?php echo $tabTexteHomeUser[11]; ?></button>
							    </div>
							</form>
					      </div>
				    </div>
				  </div>
			</div>

		<div class="elementsMessage">


			<!-- Titre -->
			<h3 style="margin-left:10%; margin-bottom:20px; color:white;"><?php echo $tabTexteHomeUser[1]; ?></h3>


			<!-- bouton pour ajouter un message -->
			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#messageModal" style="margin-left:10%">
			<?php echo $tabTexteHomeUser[2]; ?>
			</button>


			<!-- Zone messages utilisateur -->
			<div class="zoneMessageUser" id="zoneMessageUser">
				<?php

				//requete pour récupérer les ids des messages de l'utilisateur
				$req = $connect->prepare("SELECT idmessage, message, date FROM message WHERE idutilisateur = :userId ORDER BY idmessage DESC");
				$req->execute(array('userId' => $userId));	

				// calcule le nbr d'id
				$result = $req->fetchAll();
				$nbrId = count($result);

				$req->execute(array('userId' => $userId));					

				//boucle qui affiche tous les messages de l'utilisateur avec une nouvelle div par message
				if ($nbrId != 0) {
					while($row1 = $req->fetch(PDO::FETCH_ASSOC)) {
						?>
						<div class="message">
							<div class="date">
								<?php
									echo $row1['date']; // afficher la date du message
								?>
							</div>
							<?php
							echo $row1['message']; //affiche le message de l'utilisateur

						/* _______________ Les réponses _______________ */

								$idmessage = $row1['idmessage'];

							//  requete qui récupère toutes les reponses de la bdd
								$req2 = $connect->prepare("SELECT idcontact, reponse FROM reponse WHERE idmessage = :idmessage ORDER BY idreponse DESC");	
								$req2->execute(array('idmessage' => $idmessage));

							// affiche le bouton que si il y a au moin 1 réponse
							// calcule le nbr de réponse
								$result = $req2->fetchAll();
								$nbrReponse = count($result);

								if ($nbrReponse >= 1) {
									?>
									<!-- bouton pour ajouter une réponse -->
									<div class="bouton">
										<button type="button" class="btn btn-primary btn-lg" data-toggle="modal"  data-target="#reponseMessageModal" onclick="idMessage('reponse', <?php echo $idmessage; ?>);">
										<?php echo $tabTexteHomeUser[12]; ?>
										</button>
									</div>
									<?php
								}
								?>
								<!-- bouton pour supprimer un message -->
								<div class="bouton">
									<button type="button" class="btn btn-primary btn-lg" data-toggle="modal"  data-target="#supprimerMessageModal" onclick="idMessage('supprimer', <?php echo $idmessage; ?>);">
									<?php echo $tabTexteHomeUser[13]; ?>
									</button>
								</div>
								<?php

								$req2->execute(array('idmessage' => $idmessage));

							// boucle pour afficher les reponses du message
								while($row2 = $req2->fetch(PDO::FETCH_ASSOC)) {

										$idUserMessage = $row2['idcontact'];

										/*requete pour vérifier que l'auteur de la réponse se trouve dans la liste des contacts de l'utilisateur
										ou que c'est lui meme l'auteur de la réponse*/
										$req3 = $connect->prepare("SELECT id_contact FROM contact WHERE id_utilisateur = :userId And id_contact = :contactId");
										$req3->execute(array('userId' => $userId, 'contactId' => $idUserMessage));	
										$res3 = $req3->fetch();

										$idContact = $res3['id_contact'];

										if (($idContact != null)||($idUserMessage == $userId)) {
											if ($idUserMessage == $userId){
												$idContact = $userId;
											}

											$messageContact = $row2['reponse'];

											//requete qui récupère les pseudos correspondant à l'id des contacts
											$req4 = $connect->prepare("SELECT pseudo FROM utilisateur WHERE idutilisateur = :userId");
											$req4->execute(array('userId' => $idContact));
											$res4 = $req4->fetch();
											$pseudoContact = $res4['pseudo'];

											//requete qui récupère l'avatar correspondant à l'id des contacts
											$req5 = $connect->prepare("SELECT avatar FROM image WHERE idutilisateur = :userId");
											$req5->execute(array('userId' => $idContact));
											$res5 = $req5->fetch();
											$avatarContact = $res5['avatar'];

											if ($res5['avatar'] != null) {
												$lienImgContact = "img/users/".$avatarContact;
											} else {
												$lienImgContact = "img/sansAvatar.png";
											}

											?>

											<!-- affichage des réponses -->
												<div class="reponse">
													<div class="avatarContact2">
														<img style="width:75px;" src="<?php echo $lienImgContact ?>" />
													</div>
													<div class="messageContact2">
														<p style="color: black;">Pseudo: <?php echo $pseudoContact; ?></p>
														<p style="color: black;">Message:</br><?php echo $messageContact; ?></p>
													</div>		
												</div>
											<!--************************-->

							
											<?php	
										}											
								}
							/* ____________________ Les Avis ____________________ */

							//  requete qui récupère tous les avis de la bdd
								$req5 = $connect->prepare("SELECT idutilisateur, avis FROM avis WHERE idmessage = :idmessage ORDER BY idavis DESC");	
								$req5->execute(array('idmessage' => $idmessage));

							// boucle pour afficher les avis du message
								while($row3 = $req5->fetch(PDO::FETCH_ASSOC)) {

										$idUserAvis = $row3['idutilisateur'];

										//requete pour vérifier que l'utilisateur qui a déposé l'avis se trouve dans la liste des contacts de l'utilisateur
										$req6 = $connect->prepare("SELECT id_contact FROM contact WHERE id_utilisateur = :userId And id_contact = :contactId");
										$req6->execute(array('userId' => $userId, 'contactId' => $idUserAvis));	
										$res6 = $req6->fetch();

										$idContact2 = $res6['id_contact'];

										if ($idContact2 != null) {

											$Avis = $row3['avis'];

											//requete qui récupère les pseudos correspondant à l'id des utilisateurs
											$req7 = $connect->prepare("SELECT pseudo FROM utilisateur WHERE idutilisateur = :userId");
											$req7->execute(array('userId' => $idContact2));
											$res7 = $req7->fetch();
											$pseudoContact2 = $res7['pseudo'];

											?>

											<!-- affichage des avis -->
												<div class="avis">
												<?php
													$avisPseudo = $pseudoContact2." : ".$Avis;
													echo $avisPseudo;
												?>
												</div>
											<!--********************-->
				
											<?php

										}											
								}	

							/* _____________________________________________________ */
						?>
						</div>
						<?php

					}
				}						

				?>


			</div>


		</div>


	</div>


</div>


<script>

// récupère l'id du message associé au bouton et l'intègre au input hidden du form
function idMessage(type, idmessage) {

	if (type == "reponse") {
		var inputIdMessage = document.getElementById('idMessage');
		inputIdMessage.value = idmessage;
	}
	else if (type == "supprimer") {
		var inputIdMessage = document.getElementById('idMessage2');
		inputIdMessage.value = idmessage;
	}
}

//affiche un message si le nombre de caractère atteind la limite
function maxlength(type) { 

	var nbr = 255;	
	if ( type == "newMessage" ) {
			var txt = document.getElementById('newMessage').value.length;
	}
	
	if ( type == "newReponse" ) {
			var txt = document.getElementById('newReponseMessage').value.length;
	}

	if (txt >= nbr) {
			alert("Limite de 255 caratères atteinte");
			return false;
	}

}

</script>