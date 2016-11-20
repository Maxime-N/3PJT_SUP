<?php
//--------------- Traduction message contact--------------

//valeur pour chaque langage
switch ($lang) {
    case 'Fr':
        $titreMessage = "Messages de vos contacts";

        $boutonRep = "Répondre";
        $boutonAvis = "Avis";

        $titreModal1 = "Répondre au message";

        $bouton1Modal = "Fermer";
        $bouton2Modal = "Ajouter";

        $titreModal2 = "Donner un avis"; 

        
        break;
		
    case 'En':
        $titreMessage = "Messages to your contacts";

        $boutonRep = "Answer";
        $boutonAvis = "Opinion";

        $titreModal1 = "Reply to this post";

        $bouton1Modal = "Close";
        $bouton2Modal = "Add";

        $titreModal2 = "Give a opinion"; 
        
        break;
		
    default : echo " erreur 404"; break;
}

//tableau avec les valeurs
$tabTexteMessageContact =array($titreMessage, $boutonRep, $boutonAvis, $titreModal1, $bouton1Modal, $bouton2Modal, $titreModal2);

?>