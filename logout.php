<?php
include('base.php');

if(isset($_SESSION['pseudo']))
{
	session_destroy();
	header('Location: index.php');
}
else
{
	include('tete.php');
	avert('Vous êtes déjà déconnecté');
	include('pied.php');
	exit;
}


?>
