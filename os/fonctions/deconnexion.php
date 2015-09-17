<?php
include('../base.php');

if(isset($_POST['deconnexion']))
{
	session_destroy();
}
?>