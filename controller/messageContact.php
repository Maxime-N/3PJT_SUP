<?php
include('template/header.php');
include('template/menu.php');
if ($connexionUtilisateur == $nbr){
	include('content/messageContact.php');
} else {
	include('content/home.php');
}
include('template/footer.php');