<?php
include('head.php');

$r_donnees_membre = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $_SESSION['id'] . '');
$r_donnees_membre->execute();
$donnees_membre = $r_donnees_membre->fetch(PDO::FETCH_OBJ); 

switch($donnees_membre->acces) {
	case 100:
		$_SESSION['acces'] = 100;
		$grade = '<div class="admin">Administrateur</div>';
	break;
	case 90:
		$_SESSION['acces'] = 90;
		$grade = '<div class="codeur">Codeur</div>';
	break;
}

if(stristr($_SERVER['REQUEST_URI'], 'index.php'))
{
	$focusTa = 'Focus';
	$sousMenuTa = '

	';
	$titre = 'Tableau de bord';
}
elseif(stristr($_SERVER['REQUEST_URI'], 'articles.php'))
{
	$focusAr = 'Focus';
	$sousMenuAr = '

	';
	$titre = '';
}
elseif(stristr($_SERVER['REQUEST_URI'], 'forums.php'))
{
	$focusFo = 'Focus';
	$sousMenuFo = '

	';
	$titre = '';
}
elseif(stristr($_SERVER['REQUEST_URI'], 'membres.php'))
{
	$focusMe = 'Focus';
	$sousMenuMe = '

	';
	$titre = '';
}
elseif(stristr($_SERVER['REQUEST_URI'], 'admins.php'))
{
	$focusAd = 'Focus';
	$sousMenuAd = '

	';
	$titre = '';
}
elseif(stristr($_SERVER['REQUEST_URI'], 'codeurs.php'))
{
	$focusCo = 'Focus';
	$sousMenuCo = '

	';
	$titre = '';
}
elseif(stristr($_SERVER['REQUEST_URI'], 'supermodos.php'))
{
	$focusSu = 'Focus';
	$sousMenuSu = '

	';
	$titre = '';
}
elseif(stristr($_SERVER['REQUEST_URI'], 'modos.php'))
{
	$focusMo = 'Focus';
	$sousMenuMo = '

	';
	$titre = '';
}
elseif(stristr($_SERVER['REQUEST_URI'], 'sanctions.php'))
{
	$focusSa = 'Focus';
	$sousMenuSa = '

	';
	$titre = '';
}
elseif(stristr($_SERVER['REQUEST_URI'], 'options.php'))
{
	$focusOp = 'Focus';
	$sousMenuOp = '

	';
	$titre = '';
}
elseif(stristr($_SERVER['REQUEST_URI'], 'banhammer.php'))
{
	$focusBh = 'Focus';
	$sousMenuOp = '

	';
	$titre = 'The BanHammer';
}

echo '
	<div class="barrePrincipale">EvenForum</div>
	<div class="menu">
		<div class="infoCompte">
			<div class="avatar_case_compte"><img src="http://www.evenforum.com/' . $donnees_membre->avatar . '" /></div> 
			<span style="left: 120px; position: relative;">
			' . $_SESSION['pseudo'] . '<br />
			' . $grade .'
			</span>
		</div>
		<div class="menuTitre">MENU</div>
		<a href="index.php" class="menuOnglet' . $focusTa . '">Tableau de bord</a>
		<a href="articles.php" class="menuOnglet' . $focusAr . '">Articles</a>
		<a href="forums.php" class="menuOnglet' . $focusFo . '">Forums</a>
		<a href="membres.php" class="menuOnglet' . $focusMe . '">Membres</a>
		<a href="admins.php" class="menuOnglet' . $focusAd . '">Admins</a>
		<a href="codeurs.php" class="menuOnglet' . $focusCo . '">Codeurs</a>
		<a href="supermodos.php" class="menuOnglet' . $focusSu . '">Super-modos</a>
		<a href="modos.php" class="menuOnglet' . $focusMo . '">Modos</a>
		<a href="sanctions.php" class="menuOnglet' . $focusSa . '">Sanctions</a>
		<a href="banhammer.php" class="menuOnglet' . $focusBh . '">The BanHammer</a>
		<a href="options.php" class="menuOnglet' . $focusOp . '">Options</a>
	</div>
	<div class="cadre">
		<span class="titre">' . $titre . ' > </span><span class="sousTitre">Vue d\'ensemble</span>
		<div class="separate"></div>
';
?>