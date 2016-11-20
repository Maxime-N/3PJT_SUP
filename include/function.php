<?php

// --------- Connexion base de données -------
function connecterBdd() {
    $login = "root";
	$password = "";
	return new PDO('mysql:host=localhost;dbname=bddgabbler', $login, $password);
}

// --------- récupérer un Get -------
function lireDonneeUrl($nomDonnee, $valDefaut="") {
    if ( isset($_GET[$nomDonnee]) ) { //test si le champ n'est pas vide pour retourner la valeur
        $val = $_GET[$nomDonnee];
    }
    else { //si il est vide alors la valeur retourné sera celle que l'on aura définis par défaut
        $val = $valDefaut;
    }
    return $val;
}

// --------- récupérer un Post -------
function lireDonneePost($nomDonnee, $valDefaut="") {
    if ( isset($_POST[$nomDonnee]) ) {
        $val = $_POST[$nomDonnee];
    }
    else {
        $val = $valDefaut;
    }
    return $val;
}

// --------- Enregistrer un utilisateur -------
function registerUser($connect){
	// récupération des champs du formulaire
	$firstname = lireDonneePost("firstname", "");
	$lastname = lireDonneePost("lastname", "");
	$email = lireDonneePost("email", "");
	$username = lireDonneePost("username", "");
	$password = lireDonneePost("password", "");
	$confpassword = lireDonneePost("confpassword", "");
	
	// test si tous les champs sont remplis et si les motsdepasse sont identique
	if (($firstname != "")&&($lastname != "")&&($email != "")&&($username != "")&&($password != "")&&($confpassword == $password)){			
		// récupère le nombres de ligne identique au pseudo rentré pour vérifier que le pseudo n'existe pas déjà
		$req = $connect->prepare("SELECT * FROM utilisateur WHERE pseudo = :pseudo");
		$req->execute(array('pseudo' => $username));
		$count = $req->rowCount();
		
		if ($count == 0) { // si le nombres de ligne = 0 alors on enregiste l'utilisateur
			$req = $connect->prepare("INSERT INTO utilisateur(nom, prenom, email, pseudo, motdepasse) VALUES (:nom, :prenom, :email, :pseudo, :motdepasse)");
			$req->execute(array('prenom' => $firstname, 'nom' => $lastname, 'email' => $email, 'pseudo' => $username, 'motdepasse' => md5($password))); // mot de passe en MD5
		}
	}		
}

// --------- Mise à jour des informations d'un utilisateur -------
function updateUser($connect){
	$idUser = idUser($connect);
	
	$res = donneesUser($connect);
	$password = $res["motdepasse"];
	$username = $res["pseudo"];
	$email = $res["email"];
	
	// récupère la valeur à modifier et si le post n'existe pas cela mais la valeur par défaut de la BDD 
	$newPassword = lireDonneePost("newPassword",$password);	
	$newEmail = lireDonneePost("newEmail",$email);
	$newUsername = lireDonneePost("newUsername",$username);
	
	// Si la variable est vide cela mais la valeur par défaut de la BDD
	if ($newPassword == ""){ $newPassword = $password; }
	if ($newEmail == ""){ $newEmail = $email; }
	if ($newUsername == ""){ $newUsername = $username; }

	if ($idUser != "") {
		$req = $connect->prepare("UPDATE utilisateur SET motdepasse = :password, pseudo = :username, email = :email WHERE idutilisateur = :iduser");
		if ($newPassword == $password){
			// si $newPassword == $password cela enregistre $newPassword(contenant la valeur initial de la BDD) qui est déjà au format MD5
			$req->execute(array('password' => $newPassword, 'username' => $newUsername, 'email' => $newEmail, 'iduser' => $idUser));			
		} else {
			$req->execute(array('password' => md5($newPassword), 'username' => $newUsername, 'email' => $newEmail, 'iduser' => $idUser));
		}
						
		if ($password != $newPassword){ 
			enregistrerSession("motdepasse", $newPassword);
		}			
		if ($username != $newUsername){ 
			enregistrerSession("pseudo", $newUsername);
		}		
	}
}

// ---------- Connecte l'utilisateur -------------
function connexion($connect, $nbr) {
	$formConnexion = lireDonneePost("formconnexion", "");
	$sessionConnexion = lireDonneeSession("sessionconnexion", "");
	
	if (($sessionConnexion == 1)||($formConnexion == 1)){
		// récupèration du pseudo et motdepasse de la session ou du formulaire
		if ($sessionConnexion == 1){
			$pseudo = lireDonneeSession("pseudo", "");
			$motdepasse = lireDonneeSession("motdepasse", "");
		} else {
			$pseudo = lireDonneePost("pseudo", "");
			$motdepasse = lireDonneePost("motdepasse", "");
		}
		
		if (($pseudo != "")&&($motdepasse != "")) {
			// récupère le nombres de ligne pour vérifier que l'utilisateur existe et que le motdepasse est correcte
			$req = $connect->prepare("SELECT * FROM utilisateur WHERE pseudo = :pseudo AND motdepasse = :motdepasse ");
			$req->execute(array('pseudo' => $pseudo, 'motdepasse' => md5($motdepasse)));
			$count = $req->rowCount();
					
			if($count == 1) { // si le nombres de ligne = 1 alors on connecte l'utilisateur
				if ($sessionConnexion != 1){ // enregistre les données de connexion dans une session
					enregistrerSession("sessionconnexion", "1");
					enregistrerSession("pseudo", $pseudo);
					enregistrerSession("motdepasse", $motdepasse);
				}
				return $nbr;
			}		
		}
	} else {
		return "";
	}
}

// -------- initialiser la session -----------
function initSession() {
    session_start();
}

// -------- enregistrer une donnée Session ---------
function enregistrerSession($nomDonnee, $val) {
    $_SESSION[$nomDonnee] = $val;
}

// -------- récupérer une donnée Session ----------
function lireDonneeSession($nomDonnee, $valDefaut="") {
   if(isset($_SESSION[$nomDonnee])){
       $val = $_SESSION[$nomDonnee];
   }
   else {
       $val = $valDefaut;
   }
   return $val;
}

// -------- déconnecter l'utilisateur ---------
function deconnexion() {
	 supprimerDonneeSession("sessionconnexion");
	 supprimerDonneeSession("pseudo");
	 supprimerDonneeSession("motdepasse");
}

// -------- supprimer des donnée Session ---------
function supprimerDonneeSession($nomDonnee) {
	 unset($_SESSION[$nomDonnee]);
}


// -------- choix langage ---------
function langage(){
	$sessionLang = lireDonneeSession("sessionlang", "");
	$formLang = lireDonneePost("formlang", "");
	
	//par défaut
	
	$defaut = "Fr";
	
	if ($formLang == 1){
		$lang = lireDonneePost("lang", $defaut);
		enregistrerSession("lang", $lang);
		if ($sessionLang != 1){
			enregistrerSession("sessionlang", "1");
		}	
	} elseif (($sessionLang == 1)&&($formLang != 1)) {
		$lang = lireDonneeSession("lang", $defaut);	
	} else {
		$lang = $defaut;
	}

	return $lang;
}

// ------- traduction du texte --------
function traduction($connect, $element, $lang){
	
	if ($lang == "Fr"){
		$champ = 'textefr';
	} elseif ($lang == "En"){
		$champ = 'texteen';
	}
		
	$req = $connect->prepare("SELECT * FROM textepage WHERE idtexte = :element");
	$req->execute(array('element' => $element));	
	$res = $req->fetch();
	$texte = $res[$champ];
		
	return utf8_encode($texte);
}

// ------- récupérer données utilisateur --------
function donneesUser($connect){	
	$idUser = idUser($connect);
	
	$req = $connect->prepare("SELECT * FROM utilisateur WHERE idutilisateur = :iduser ");
	$req->execute(array('iduser' => $idUser));
	$res = $req->fetch();
	
	return $res;
}

// ------- récupérer id utilisateur --------
function idUser($connect){
	$pseudo = lireDonneeSession("pseudo", "");
	$motdepasse = lireDonneeSession("motdepasse", "");	
	
	$req = $connect->prepare("SELECT idutilisateur FROM utilisateur WHERE pseudo = :pseudo AND motdepasse = :motdepasse ");
	$req->execute(array('pseudo' => $pseudo, 'motdepasse' => md5($motdepasse)));
	$res = $req->fetch();
	
	return $res["idutilisateur"];	
}

// --------- télécharger image -------
function telechargerImage($width, $height, $typeImg){

	if ( $typeImg == "avatar" ) {
		$imageError = $_FILES['newAvatar']['error'];
		$imageName = $_FILES['newAvatar']['name'];
		$imageTmpName = $_FILES['newAvatar']['tmp_name'];
	}

	if ( $typeImg == "background" ) {
		$imageError = $_FILES['newBackground']['error'];
		$imageName = $_FILES['newBackground']['name'];
		$imageTmpName = $_FILES['newBackground']['tmp_name'];
	}


	if ($imageError > 0){
		$erreur = "Erreur lors du transfert";
	}
	else{
		$extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
		/*strrchr renvoie l'extension avec le point (« . »).
		substr(chaine,1) ignore le premier caractère de chaine.
		strtolower met l'extension en minuscules.*/

		$extension_upload = strtolower(substr(strrchr($imageName, '.'),1));

			if ( in_array($extension_upload,$extensions_valides) ) {
				$image_sizes = getimagesize($imageTmpName);
				if ($image_sizes[0] != $width OR $image_sizes[1] != $height) {
					$erreur = "Mauvaise taille Image";
				} else {
					$destination = $_SERVER["DOCUMENT_ROOT"]."/img/users/".$imageName;
					$resultat = move_uploaded_file($imageTmpName,$destination);
				}
			}
	}
}

// --------- supprimer image -------
function supprimerImage($connect, $nomImage, $userId, $typeImg){
	//requete pour recupérer le nom de l'ancienne image
	$req = $connect->prepare("SELECT * FROM image WHERE idutilisateur = :userId");
	$req->execute(array('userId' => $userId));	
	$res = $req->fetch();
	
	if ( $typeImg == "avatar" ) {
		$ancienneImg = $res['avatar'];
	}

	if ( $typeImg == "background" ) {
		$ancienneImg = $res['fond'];
	}

	/*teste dans la base de donnée si il existe une ancienne image, si l'ancienne image est différente de la nouvelle et dans
	le fichier qui contien les image si cet ancienne image existe, pour ensuite la supprimer du fichier*/ 
	$lienSuppr = $_SERVER["DOCUMENT_ROOT"]."/img/users/".$ancienneImg;
	if (($ancienneImg!="")&&($ancienneImg!=$nomImage)&&(file_exists($lienSuppr))) {	
		unlink ($lienSuppr);
	}	
}

// --------- Modifier avatar ou image fond -------
function modifierImg($connect, $userId){

	/*récupère l'id de l'utilisateur de la table image qui correspond a l'id de la table utilisateur
	pour verifier si il existe ou non*/
	$req = $connect->prepare("SELECT idutilisateur FROM image WHERE idutilisateur = :userId ");
	$req->execute(array('userId' => $userId));
	$res = $req->fetch();
	$idutilisateur = $res["idutilisateur"];

	$newAvatar = $_FILES['newAvatar']['name'];
	$newBackground = $_FILES['newBackground']['name']; 

	if ( $newAvatar != "" ) {
		/* taille demandé pour accepter le téléchargement,
		pour éviter d'avoir des images trop grande ou déformé*/
		$width=150;
		$height=200;
		$typeImg = "avatar";
		$nomImage = $newAvatar;

		telechargerImage($width, $height, $typeImg);

		supprimerImage($connect ,$nomImage, $userId, $typeImg);

		if ( $idutilisateur == null) {
			//enregister le nom de l'image dans la base de données
			$req = $connect->prepare("INSERT INTO image(avatar, idutilisateur) VALUES (:avatar, :idutilisateur)");
			$req->execute(array('avatar' => $nomImage, 'idutilisateur' => $userId));		
		} else {
			//modifie le nom de l'image dans la base de données
			$req = $connect->prepare("UPDATE image SET avatar = :avatar WHERE idutilisateur = :iduser");
			$req->execute(array('avatar' => $nomImage, 'iduser' => $userId));			
		}

	}

	if ( $newBackground != "" ) {
		$width=1920;
		$height=1200;
		$typeImg = "background";
		$nomImage = $newBackground;

		telechargerImage($width, $height, $typeImg);

		supprimerImage($connect, $nomImage, $userId, $typeImg);

		if ( $idutilisateur == null) {
			//enregister le nom de l'image dans la base de données
			$req = $connect->prepare("INSERT INTO image(fond, idutilisateur) VALUES (:fond, :idutilisateur)");
			$req->execute(array('fond' => $nomImage, 'idutilisateur' => $userId));		
		} else {
			//modifie le nom de l'image dans la base de données
			$req = $connect->prepare("UPDATE image SET fond = :fond WHERE idutilisateur = :iduser");
			$req->execute(array('fond' => $nomImage, 'iduser' => $userId));			
		}
	}

}


// --------- Afficher avatar ou image fond --------
function imageAffichage($connect, $typeImage, $userId) {

	//requete pour recupérer le nom des images correspondant à l'utilisateur
	$req = $connect->prepare("SELECT * FROM image WHERE idutilisateur = :userId");
	$req->execute(array('userId' => $userId));	
	$res = $req->fetch();

	if ( $typeImage == "avatar" ) {
		if ($res['avatar'] != null) {
			$lienImg = "img/users/".$res['avatar'];
			return $lienImg;
		} else {
			return "img/sansAvatar.png";
		}		
	}

	if ( $typeImage == "background" ) {
		if ($res['fond'] != null) {
			$lienImg = "img/users/".$res['fond'];
			return $lienImg;
		} else {
			return "img/background.jpg";
		}
	}

}

// ---------  enregistrer un nouveau message --------
function newMessage($connect, $userId) {

	$message = lireDonneePost("newMessage", "");

	//récupère la date actuelle
	$date = date('Y-m-d');

	//requete pour enregistrer le message dans la base de données 
	$req = $connect->prepare("INSERT INTO message(message, idutilisateur, date) VALUES (:message, :idutilisateur, :date)");
	$req->execute(array('message' => $message, 'idutilisateur' => $userId, 'date' => $date));

}

// ---------  ajoute un nouveau contact --------
function addUser($connect, $userId) {

	$addUserName = lireDonneePost("addUserName", "");

	// vérifie que l'username du contact existe
	$req = $connect->prepare("SELECT pseudo, idutilisateur FROM utilisateur WHERE pseudo = :addUserName");
	$req->execute(array('addUserName' => $addUserName));	
	$res = $req->fetch();

	$pseudoUserCo = lireDonneeSession("pseudo", "");

	if (( $res['pseudo'] != null )&&( $addUserName != $pseudoUserCo )) {

		// id du contact à ajouter
		$idContact = $res['idutilisateur'];

		// vérifie que l'id du contact n'a pas déjà été ajouté
		$req = $connect->prepare("SELECT * FROM contact WHERE id_contact = :idcontact");
		$req->execute(array('idcontact' => $idContact));	
		$res = $req->fetch();

		if ( $res['id_contact'] == null ) {

			//requete pour enregistrer le nouveau contact dans la base de données 
			$req = $connect->prepare("INSERT INTO contact(id_utilisateur, id_contact) VALUES (:idutilisateur, :idcontact)");
			$req->execute(array('idutilisateur' => $userId, 'idcontact' => $idContact));

		} else {
			?><p>Vous avez déjà ajouté ce contact</p><?php
		}

	} else {
		?><p>L'utilisateur n'existe pas ou l'username est identique au votre</p><?php
	}

}

// ---------  ajoute une réponse --------
function addAnswer($connect, $userId) {

	$messageReponse = lireDonneePost("newReponseMessage", "");
	$idMessage = lireDonneePost("idMessage", "");

	//requete pour enregistrer la réponse dans la base de données 
	$req = $connect->prepare("INSERT INTO reponse(idmessage, reponse, idcontact) VALUES (:idmessage, :reponse, :idcontact)");
	$req->execute(array('idmessage' => $idMessage, 'reponse' => $messageReponse, 'idcontact' => $userId));

}

// ---------  ajoute un avis --------
function addAvis($connect, $userId) {

	$avis = lireDonneePost("newAvisMessage", "");
	$idMessage = lireDonneePost("idMessage", "");

	//requete pour vérifier si l'avis existe 
	$req = $connect->prepare("SELECT idavis FROM avis WHERE idutilisateur = :idutilisateur AND idmessage = :idmessage");
	$req->execute(array('idutilisateur' => $userId, 'idmessage' => $idMessage));	
	$res = $req->fetch();

	$avisExiste = $res['idavis'];

	//si l'avis existe on le modifie, si non on l'ajoute
	if ( $avisExiste == null ) {
		//requete pour enregistrer la réponse dans la base de données 
		$req = $connect->prepare("INSERT INTO avis(idmessage, avis, idutilisateur) VALUES (:idmessage, :avis, :idutilisateur)");
		$req->execute(array('idmessage' => $idMessage, 'avis' => $avis, 'idutilisateur' => $userId));
	} else {
		$req = $connect->prepare("UPDATE avis SET avis = :avis WHERE idutilisateur = :idutilisateur AND idmessage = :idmessage");
		$req->execute(array('avis' => $avis, 'idutilisateur' => $userId, 'idmessage' => $idMessage));
	}
}

// ---------  supprimer message --------
function supprimerMessage($connect, $userId) {

	$idMessage = lireDonneePost("idMessage", "");

	//on supprime le message
	$req = $connect->prepare("DELETE FROM message WHERE idmessage = :idmessage");
	$req->execute(array('idmessage' => $idMessage));

	//on supprime aussi les réponse associé à se message
	$req2 = $connect->prepare('DELETE FROM reponse WHERE idmessage = :idmessage');
 	$req2->execute(array('idmessage'  => $idMessage ));

 	//et aussi les avis
 	$req3 = $connect->prepare('DELETE FROM avis WHERE idmessage = :idmessage');
 	$req3->execute(array('idmessage'  => $idMessage ));
	
}

// ---------  supprimer contact --------
function supprimerContact($connect, $userId) {

	$idContact = lireDonneePost("idContact", "");

	//on supprime le contact
	$req = $connect->prepare("DELETE FROM contact WHERE id_contact = :idcontact AND id_utilisateur = :idutilisateur");
	$req->execute(array('idcontact' => $idContact, 'idutilisateur' => $userId));
	
}


?>