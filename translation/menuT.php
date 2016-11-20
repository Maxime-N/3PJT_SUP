<?php
//--------------- Traduction Home--------------

//valeur pour chaque langage
switch ($lang) {
    case 'Fr':
        $menu1 = "Accueil";
		$menu2 = "Message contact";
		$menu3 = "Compte";
		$form1 = "Nom d'utilisateur";
		$form2 = "Mot de passe";
		$bouton1 = "Connexion";
		$bouton2 = "Déconnexion";
		$texte = "Bienvenue";
		$langageSelector = "Choisir la langue";
        break;
		
    case 'En':
        $menu1 = "Home";
		$menu2 = "Message contact";
		$menu3 = "Account";
		$form1 = "Username";
		$form2 = "Password";
		$bouton1 = "Sign in";
		$bouton2 = "Sign out";
		$texte = "Welcome";	
		$langageSelector = "Choose your language";
        break;
		
    default : echo " erreur 404"; break;
}

//tableau avec les valeurs
$tabTexteMenu =array($menu1, $menu2, $menu3, $form1, $form2, $bouton1, $bouton2, $texte, $langageSelector);

?>