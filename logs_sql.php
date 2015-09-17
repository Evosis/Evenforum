<?php

$nom_hote_sql = "localhost";
$nom_d_utilisateur = "adminvv5NEmI";
$mot_de_passe = "7pyPEfGJuZpD";
$base_de_donnees = "evenforum";

try {

	$connexion = new PDO('mysql:host=' . $nom_hote_sql . ';dbname=' . $base_de_donnees . '', '' . $nom_d_utilisateur . '', '' . $mot_de_passe . '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e)
{
		echo '<b>Maintenance, ou arret serveur, on revient bientot ! !</b><br /><br />';
        echo 'Erreur SQL : '.$e->getMessage().'<br />';
        echo 'N° Code : '.$e->getCode();
        exit;
}
