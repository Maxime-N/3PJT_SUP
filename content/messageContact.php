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

$res = donneesUser($connect);
$userId = $res["idutilisateur"];


//Contenu traduit
include('translation/messageContactT.php');

$ajouterReponse = lireDonneePost("ajouterReponse", "");
if ($ajouterReponse == 1){
	addAnswer($connect, $userId);
}

$ajouterAvis = lireDonneePost("ajouterAvis", "");
if ($ajouterAvis == 1){
	addAvis($connect, $userId);
}

?>

<div class="row">
    <div class="container">

			<!-- Titre -->
			<h3 style="margin-left:10%; margin-bottom:20px; margin-top:20px; color: white;"><?php echo $tabTexteMessageContact[0]; ?></h3>

			<!-- Zone messages des contacts -->

			<div class="zoneMessageUser" id="zoneMessageUser">
				<?php

				//boucle qui affiche les messages des contacts avec leur avatar et pseudo
				/* d'abord il faut faire une boucle sur tous les messages, récupéré
				l'id de l'auteur du message et vérifier que cet id est bien
				dans la liste des contact de l'utilisateur si oui on affiche le tous*/

				//requete qui récupère tous les messages de la bdd
				$req = $connect->prepare("SELECT idmessage, message, idutilisateur, date FROM message WHERE idutilisateur != :userId ORDER BY idmessage DESC");	
				$req->execute(array('userId' => $userId));

				while($row1 = $req->fetch(PDO::FETCH_ASSOC)) {

						$idUserMessage = $row1['idutilisateur'];

						//requete pour vérifier que l'auteur du message se trouve dans la liste des contacts de l'utilisateur
						$req1 = $connect->prepare("SELECT id_contact FROM contact WHERE id_utilisateur = :userId And id_contact = :contactId");
						$req1->execute(array('userId' => $userId, 'contactId' => $idUserMessage));	
						$res1 = $req1->fetch();

						$idContact = $res1['id_contact'];

						if ( $idContact != null ) {

							$messageContact = $row1['message'];

							//requete qui récupère les pseudos correspondant à l'id des contacts
							$req2 = $connect->prepare("SELECT pseudo FROM utilisateur WHERE idutilisateur = :userId");
							$req2->execute(array('userId' => $idContact));
							$res2 = $req2->fetch();
							$pseudoContact = $res2['pseudo'];

							//requete qui récupère l'avatar correspondant à l'id des contacts
							$req3 = $connect->prepare("SELECT avatar FROM image WHERE idutilisateur = :userId");
							$req3->execute(array('userId' => $idContact));
							$res3 = $req3->fetch();
							$avatarContact = $res3['avatar'];

							if ($res3['avatar'] != null) {
								$lienImgContact = "img/users/".$avatarContact;;
							} else {
								$lienImgContact = "img/sansAvatar.png";
							}

							?>
							<div class="message">
								<div class="date">
								<?php
									echo $row1['date']; // afficher la date du message
								?>
								</div>
								<div class="avatarContact">
									<img src="<?php echo $lienImgContact ?>" />
								</div>
								<div class="messageContact">
									<p style="color: black;">Pseudo: <?php echo $pseudoContact; ?></p>
									<p style="color: black;">Message:</br><?php echo $messageContact; ?></p>
								</div>
								<div class="bouton">
									<?php // récupère l'id du message pour l'associer au bouton
									$idmessage = $row1['idmessage'];
									?>
									<!-- bouton pour ajouter une réponse -->
									<button type="button" class="btn btn-primary btn-lg" data-toggle="modal"  data-target="#reponseMessageModal" onclick="idMessage('reponse',<?php echo $idmessage; ?>);">
									<?php echo $tabTexteMessageContact[1]; ?>
									</button>
								</div>
								<?php
								?>
									<div class="bouton">
										<!-- bouton pour donner un avis -->
										<button type="button" class="btn btn-primary btn-lg" data-toggle="modal"  data-target="#avisMessageModal" onclick="idMessage('avis',<?php echo $idmessage; ?>);">
										<?php echo $tabTexteMessageContact[2]; ?>
										</button>
									</div>
								<?php
								?>
							<?php

							/* _______________ Les réponses _______________ */

								$idmessage = $row1['idmessage'];

							//  requete qui récupère toutes les reponses de la bdd
								$req4 = $connect->prepare("SELECT idcontact, reponse FROM reponse WHERE idmessage = :idmessage ORDER BY idreponse DESC");	
								$req4->execute(array('idmessage' => $idmessage));

							// boucle pour afficher les reponses du message
								while($row2 = $req4->fetch(PDO::FETCH_ASSOC)) {

										$idUserMessage2 = $row2['idcontact'];

										/*requete pour vérifier que l'auteur de la réponse se trouve dans la liste des contacts de l'utilisateur
										ou que c'est lui meme l'auteur de la réponse*/
										$req5 = $connect->prepare("SELECT id_contact FROM contact WHERE id_utilisateur = :userId And id_contact = :contactId");
										$req5->execute(array('userId' => $userId, 'contactId' => $idUserMessage2));	
										$res5 = $req5->fetch();

										$idContact2 = $res5['id_contact'];

										if (($idContact2 != null)||($idUserMessage2 == $userId)) {
											if ($idUserMessage2 == $userId){
												$idContact2 = $userId;
											}

											$messageContact2 = $row2['reponse'];

											//requete qui récupère les pseudos correspondant à l'id des contacts
											$req6 = $connect->prepare("SELECT pseudo FROM utilisateur WHERE idutilisateur = :userId");
											$req6->execute(array('userId' => $idContact2));
											$res6 = $req6->fetch();
											$pseudoContact2 = $res6['pseudo'];

											//requete qui récupère l'avatar correspondant à l'id des contacts
											$req7 = $connect->prepare("SELECT avatar FROM image WHERE idutilisateur = :userId");
											$req7->execute(array('userId' => $idContact2));
											$res7 = $req7->fetch();
											$avatarContact2 = $res7['avatar'];

											if ($res7['avatar'] != null) {
												$lienImgContact2 = "img/users/".$avatarContact2;
											} else {
												$lienImgContact2 = "img/sansAvatar.png";
											}

											?>

											<!-- affichage des réponses -->
												<div class="reponse">
													<div class="avatarContact2">
														<img style="width:75px;" src="<?php echo $lienImgContact2 ?>" />
													</div>
													<div class="messageContact2">
														<p style="color: black;">Pseudo: <?php echo $pseudoContact2; ?></p>
														<p style="color: black;">Message:</br><?php echo $messageContact2; ?></p>
													</div>		
												</div>
											<!--************************-->

							
											<?php	
										}											
								}
							/* ____________________ Les Avis ____________________ */

							//  requete qui récupère tous les avis de la bdd
								$req8 = $connect->prepare("SELECT idutilisateur, avis FROM avis WHERE idmessage = :idmessage ORDER BY idavis DESC");	
								$req8->execute(array('idmessage' => $idmessage));

							// boucle pour afficher les avis du message
								while($row3 = $req8->fetch(PDO::FETCH_ASSOC)) {

										$idUserAvis = $row3['idutilisateur'];

										/*requete pour vérifier que l'utilisateur qui a déposé l'avis se trouve dans la liste des contacts de l'utilisateur
										ou que c'est lui meme qui a déposé cet avis*/
										$req8 = $connect->prepare("SELECT id_contact FROM contact WHERE id_utilisateur = :userId And id_contact = :contactId");
										$req8->execute(array('userId' => $userId, 'contactId' => $idUserAvis));	
										$res8 = $req8->fetch();

										$idContact3 = $res8['id_contact'];

										if (($idContact3 != null)||($idUserAvis == $userId)) {
											if ($idUserAvis == $userId){
												$idContact3 = $userId;
											}

											$Avis = $row3['avis'];

											//requete qui récupère les pseudos correspondant à l'id des utilisateurs
											$req9 = $connect->prepare("SELECT pseudo FROM utilisateur WHERE idutilisateur = :userId");
											$req9->execute(array('userId' => $idContact3));
											$res9 = $req9->fetch();
											$pseudoContact3 = $res9['pseudo'];

											?>

											<!-- affichage des avis -->
												<div class="avis">
												<?php
													$avisPseudo = $pseudoContact3." : ".$Avis;
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


			<!-- Modal réponse aux messages -->
			<div class="modal fade" id="reponseMessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title" id="myModalLabel"><?php echo $tabTexteMessageContact[3]; ?></h4>
					      </div>
					      <div class="modal-body">
					      	<form method="post" role="form" data-toggle="validator">
								<fieldset>
									<div class="form-group">
										<textarea rows="2" cols="100" style="max-width:570px;" maxlength="255" required="true" name="newReponseMessage" id="newReponseMessage" onkeypress="maxlength();"></textarea>
									</div>
								</fieldset>
								<div class="modal-footer">
							      	<input type="hidden" name="ajouterReponse" value="1"/>
							      	<input type="hidden" id="idMessage" name="idMessage" value=""/>
							        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $tabTexteMessageContact[4]; ?></button>
							        <button type="submit" class="btn btn-primary"><?php echo $tabTexteMessageContact[5]; ?></button>
							    </div>
							</form>
					      </div>
				    </div>
				  </div>
			</div>


			<!-- Modal avis des messages -->
			<div class="modal fade" id="avisMessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title" id="myModalLabel"><?php echo $tabTexteMessageContact[6]; ?></h4>
					      </div>
					      <div class="modal-body">
					      	<form method="post" role="form" data-toggle="validator">
								<fieldset>
									<div class="form-group">
										<select name="newAvisMessage">										
												<option value="Aime">Aime</option>
												<option value="Aime Pas">Aime Pas</option>										
										</select>
									</div>
								</fieldset>
								<div class="modal-footer">
							      	<input type="hidden" name="ajouterAvis" value="1"/>
							      	<input type="hidden" id="idMessage2" name="idMessage" value=""/>
							        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $tabTexteMessageContact[4]; ?></button>
							        <button type="submit" class="btn btn-primary"><?php echo $tabTexteMessageContact[5]; ?></button>
							    </div>
							</form>
					      </div>
				    </div>
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
	else if (type == "avis") {
		var inputIdMessage = document.getElementById('idMessage2');
		inputIdMessage.value = idmessage;
	}
}

//affiche un message si le nombre de caractère atteind la limite
function maxlength(type) { 
	var nbr = 255;	
	var txt = document.getElementById('newReponseMessage').value.length;
	if (txt >= nbr) {
			alert("Limite de 255 caratères atteinte");
			return false;
	}

}

</script>

