<?php
//--------------- Traduction Home User--------------

//valeur pour chaque langage
switch ($lang) {
    case 'Fr':
        $textBienvenue = "Bienvenue dans votre espace utilisateur";
        $titreZoneMessage = "Vos Messages :";

        // *********** modal message ************

        $boutonNewMessage = "Nouveau Message";
        $bouton1Modal1 = "Fermer";
        $bouton2Modal1 = "Valider";

        // *********** modal réponse ************
        $titreModal2 = "Répondre au message";
        $bouton1Modal2 = "Fermer";
        $bouton2Modal2 = "Ajouter";
        $boutonRep = "Répondre";

        // *********** modal suppression ************
        $titreModal3 = "Supprimer le message";
        $txtModal3 = "Etes vous certain de vouloir supprimer se message";
        $bouton1Modal3 = "NON";
        $bouton2Modal3 = "OUI";
        $boutonSup = "Supprimer";


        break;
		
    case 'En':
        $textBienvenue = "Welcome to your user space";
        $titreZoneMessage = "Your Messages :";

        // *********** modal message ************

        $boutonNewMessage = "New Message";
        $bouton1Modal1 = "Close";
        $bouton2Modal1 = "Submit";

        // *********** modal réponse ************
        $titreModal2 = "Reply to the message";
        $bouton1Modal2 = "Close";
        $bouton2Modal2 = "Add";
        $boutonRep = "Answer";

        // *********** modal suppression ************
        $titreModal3 = "Delete the message";
        $txtModal3 = "Are you sure you want to delete messages";
        $bouton1Modal3 = "NO";
        $bouton2Modal3 = "YES";
        $boutonSup = "Delete";




        break;
		
    default : echo " erreur 404"; break;
}

//tableau avec les valeurs
$tabTexteHomeUser =array($textBienvenue, $titreZoneMessage, $boutonNewMessage, $bouton1Modal1, $bouton2Modal1, $titreModal2, $bouton1Modal2, $bouton2Modal2,
    $titreModal3, $txtModal3, $bouton1Modal3, $bouton2Modal3, $boutonRep, $boutonSup);

?>