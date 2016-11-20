<?php
//--------------- Traduction compte--------------

//valeur pour chaque langage
switch ($lang) {
    case 'Fr':
		// -------- modal1 motdepasse ---------
        $modal1 = "Modifier mot de passe";
		$form1_modal1 = "Ancien mot de passe";
		$form2_modal1 = "Nouveau mot de passe";
		$form3_modal1 = "Confirmer le nouveau mot de passe";
		$bouton1 = "Fermer";// tous les "modal"
		$bouton2 = "Valider les modifications";// tous les "modal"
		$formErreur1_modal1 = "Veuillez entrez un mot de passe avec au moins 6 caractères";
		$formErreur2_modal1 = "Veuillez essayer à nouveau, vos mots de passe ne correspondent pas!";
		
		//-------- affichage infos utilisateur -------	
		$titre1 = "Détails du compte :";
		$champ1 = "Nom : ";
		$champ2 = "Prénom : ";
		$champ3 = "E-mail : ";
		$champ4 = "Nom utilisateur : ";
		
		//------- modal2 nom/e-mail/non utilisateur ------ 		
		$modal2 = "Modifier e-mail / nom utilisateur";
		$form1_modal2 = "Nouvel Email";
		$form2_modal2 = "Nouveau Nom Utilisateur";
		
		//------- modal3 avatar/image de fond ------ 
		$modal3 = "Modifier avatar / image de fond";
		$form1_modal3 = "Nouvel avatar";
		$form2_modal3 = "Nouvel image de fond";
		$bouton3 = "Vider";
		
		//------- modal4 ajout user ------ 
		$modal4 = "Ajouter contact";
		$form1_modal4 = "Nom Utilisateur";
		$bouton4 = "Ajouter";
		$erreur1 = "Vous avez déjà ajouté ce contact";
		$erreur2 = "L'utilisateur n'existe pas ou l'username est identique au votre";

		//------- contact ---------
		$titreContact = "Vos contacts :";
		$txtAucunContact = "Vous n'avez aucun contacts";

		//------- modal5 suppr user ------
		$modal5 = "Supprimer contact";
		$txtModal5 = "Etes vous certain de vouloir supprimer se contact";
		$bouton1Modal5 = "NON";
		$bouton2Modal5 = "OUI";

		//------- suivi de contact ---------
		$titreSuiviDeContact = "Vous etes suivi par :";
		

        break;
		
    case 'En':
		// -------- modal1 motdepasse ---------
        $modal1 = "Modify password";
		$form1_modal1 = "Old Password";
		$form2_modal1 = "New Password";
		$form3_modal1 = "Confirm New Password";
		$bouton1 = "Close"; // tous les "modal"
		$bouton2 = "Submit Changes"; // tous les "modal"
		$formErreur1_modal1 = "Veuillez entrez un mot de passe avec au moins 6 caractères";
		$formErreur2_modal1= "Veuillez essayer à nouveau, vos mots de passe ne correspondent pas!";
		
		//-------- affichage infos utilisateur -------		
		$titre1 = "Account details :";
		$champ1 = "Last Name : ";
		$champ2 = "First Name : ";
		$champ3 = "E-mail : ";
		$champ4 = "Username : ";
		
		//------- modal2 nom/e-mail/non utilisateur ------ 		
		$modal2 = "Modify e-mail / username";
		$form1_modal2 = "New Email";
		$form2_modal2 = "New Username";
		
		//------- modal3 avatar/image de fond ------ 
		$modal3 = "Modify avatar / background image";
		$form1_modal3 = "New avatar";
		$form2_modal3 = "New background image";
		$bouton3 = "Clear";
		
		//------- modal4 ajout user ------ 
		$modal4 = "Add contact";
		$form1_modal4 = "Username";
		$bouton4 = "Add";
		$erreur1 = "You have already added this contact";
		$erreur2 = "The user does not exist or is the same as your username";

		//------- contact ---------
		$titreContact = "Your contacts :";
		$txtAucunContact = "You have no contacts";

		//------- modal5 suppr user ------
		$modal5 = "Delete contact";
		$txtModal5 = "Are you sure you want to delete contacts";
		$bouton1Modal5 = "NO";
		$bouton2Modal5 = "YES";

		//------- suivi de contact ---------
		$titreSuiviDeContact = "You are followed by:";

        break;
		
    default : echo " erreur 404"; break;
}

//tableau avec les valeurs
$tabTexteCompte =array($modal1, $form1_modal2, $form1_modal1, $form2_modal1, $form3_modal1, $bouton1, $bouton2, $formErreur1_modal1, $formErreur2_modal1,
$titre1, $champ1, $champ2, $champ3, $champ4, $modal2, $modal3, $modal4, $form2_modal2, $form1_modal3, $form2_modal3, $form1_modal4,
$bouton3, $bouton4, $titreContact, $txtAucunContact, $erreur1, $erreur2, $modal5, $txtModal5, $bouton1Modal5, $bouton2Modal5, $titreSuiviDeContact);

?>