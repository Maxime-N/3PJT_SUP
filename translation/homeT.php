<?php
//--------------- Traduction menu--------------

//valeur pour chaque langage
switch ($lang) {
    case 'Fr':
        $titre1 = "Bienvenue sur Gabbler";
		$titre2 = "Vous ne faites pas encore partie de la communauté?";
		$titre3 = "Inscrivez-vous ici";
		$form1 = "Prénom";
		$form2 = "Nom";
		$form3 = "E-mail valide";
		$form4 = "Nom d'utilisateur";
		$form5 = "Mot de passe";
		$form6 = "Confirmez le mot de passe";
		$bouton = "Valider";
		$formErreur1 = "Veuillez entrer votre prénom";
		$formErreur2 = "Veuillez entrer votre nom";
		$formErreur3 = "Veuillez entrer un e-mail valide";
		$formErreur4 = "Veuillez entrez votre nom d'utilisateur";
		$formErreur5 = "Veuillez entrez un mot de passe avec au moins 6 caractères";
		$formErreur6 = "Veuillez essayer à nouveau, vos mots de passe ne correspondent pas!";
        break;
		
    case 'En':
        $titre1 = "Welcome to Gabbler";
		$titre2 = "Not part of the community yet?";
		$titre3 = "Register her";
		$form1 = "Firstname";
		$form2 = "Lastname";
		$form3 = "Valid Email";
		$form4 = "Username";
		$form5 = "Password";
		$form6 = "Confirm Password";
		$bouton = "Register";
		$formErreur1 = "Please enter your first name";
		$formErreur2 = "Please enter your last name";
		$formErreur3 = "Please enter a valid email";
		$formErreur4 = "Please enter your username";
		$formErreur5 = "Please enter a password that is at least 6 characters long";
		$formErreur6 = "Please try again, your passwords don't match!";
        break;
		
    default : echo " erreur 404"; break;
}

//tableau avec les valeurs
$tabTexteHome =array($titre1, $titre2, $titre3, $form1, $form2, $form3, $form4, $form5, $form6, $bouton, $formErreur1, $formErreur2, $formErreur3, $formErreur4, $formErreur5, $formErreur6);

?>