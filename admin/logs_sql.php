<?php

$nom_hote_sql = "91.216.107.248";
$nom_d_utilisateur = "evenf527509";
$mot_de_passe = "HJLd4dt52uH83";
$base_de_donnees = "evenf527509";

try {

	$connexion = new PDO('mysql:host=' . $nom_hote_sql . ';dbname=' . $base_de_donnees . '', '' . $nom_d_utilisateur . '', '' . $mot_de_passe . '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	//$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e)
{
		echo '<b>Maintenance, ou arret serveur, on revient bientot ! !</b><br /><br />';
        echo 'Erreur SQL : '.$e->getMessage().'<br />';
        echo 'N° Code : '.$e->getCode();
        exit;
}