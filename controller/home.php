<?php
include('template/menu.php');
if ($connexionUtilisateur == $nbr){ //si l'utilisateur est connecté cela inclut la page home de l'utilisateur
	include('template/header.php'); // rechargement du header pour générer le fond d'écran de l'utilisateur
	include('content/homeUser.php');

} else {
	include('template/header.php');
	include('content/home.php');
}
include('template/footer.php');