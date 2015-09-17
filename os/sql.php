<?php
		mysql_connect('mysql1.alwaysdata.com', 'evosis', 'tamere67');
		mysql_select_db('evosis_os');
		mysql_unbuffered_query('SET NAMES UTF8');
		
		
$PARAM_hote='mysql1.alwaysdata.com'; // le chemin vers le serveur
$PARAM_nom_bd='evosis_os'; // le nom de votre base de données
$PARAM_utilisateur='evosis'; // nom d'utilisateur pour se connecter
$PARAM_mot_passe='tamere67'; // mot de passe de l'utilisateur pour se connecter

try
{
        $connexion = new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
}
 
catch(Exception $e)
{
        echo 'Erreur : '.$e->getMessage().'<br />';
        echo 'N° : '.$e->getCode();
}
?>
