<?php
include('template/header.php');
include('template/menu.php');
if ($connexionUtilisateur == $nbr){
	include('content/compte.php');
} else {
	include('content/home.php');
}
include('template/footer.php');