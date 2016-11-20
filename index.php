<?php
// inclut les fontions PHP
include("include/function.php");

initSession(); //initialise la session

// variable de connexion à la BDD utilisé pour les requetes SQL des fonctions
$connect = connecterBdd();

//execute la fonction après validation du form de déconnexion
$formDeconnexion = lireDonneePost("formdeconnexion", "");
if ($formDeconnexion == 1){
	deconnexion();
}
	
// ------------ inclut le controller des pages ----------
//le controller va ensuite inclure les templates et le contenu de la page
$page = "home";
if (isset($_GET['page'])){
    $page = lireDonneeUrl("page", "");
}

switch ($page) {
    case 'home':
        include('controller/home.php');
        break;
		
    case 'compte':
        include('controller/compte.php');
        break;

    case 'messageContact':
        include('controller/messageContact.php');
        break;
		
    default : echo " erreur 404"; break;
}
?>