<?php

if(isset($_SESSION['pseudo']))
{
	$type_header = 1;
}
else
{
	$type_header = 0;
}

if(isset($_SESSION['pseudo']))
{
$r_donnees_membre = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $_SESSION['id'] . '');
$r_donnees_membre->execute();
$donnees_membre = $r_donnees_membre->fetch(PDO::FETCH_OBJ);

	if($donnees_membre->niveau <= 25)
	{
		$icon_rank = '♣';
		$name_rank = "Trèfle";
	}
	elseif($donnees_membre->niveau <= 50 AND $donnees_membre->niveau > 25)
	{
		$icon_rank = '♦';
		$name_rank = "Carreau";
	}
	elseif($donnees_membre->niveau <= 75 AND $donnees_membre->niveau > 50)
	{
		$icon_rank = '♥';
		$name_rank = "Coeur";
	}
	elseif($donnees_membre->niveau <= 99 AND $donnees_membre->niveau > 75)
	{
		$icon_rank = '♠';
		$name_rank = "Pique";
	}
	elseif($donnees_membre->niveau == 100)
	{
		$icon_rank = '&#9884;';
		$name_rank = "Lys";
	}

	if($donnees_membre->prestige == 0)
	{
		$rankPrestige = '';
	}
	else
	{
		$rankPrestige = entier_romain($donnees_membre->prestige) . '-';
	}

		switch($donnees_membre->acces)
		{
			case 10:
			$grade = '';
			$etoile = '';
			break;

			case 20:
			$grade = ',<span style="font-weight: bold; color: #ff8825;"> Premium</span>';
			$etoile = '<img style="opacity: 1; margin-right: 10px;" src="images/design/premium.png" height="23" width="23" />';
			break;

			case 50:
			$grade = ',<span style="font-weight: bold; color: #4625ff;"> Modérateur</span>';
			$etoile = '<img style="opacity: 1; margin-right: 10px;" src="images/design/premium.png" height="23" width="23" />';
			break;

			case 80:
			$grade = ',<span style="font-weight: bold; color: #7fff25;"> Super-Modérateur</span>';
			$etoile = '<img style="opacity: 1; margin-right: 10px;" src="images/design/premium.png" height="23" width="23" />';
			break;

			case 90:
			$grade = ',<span style="font-weight: bold; color: #9b25ff;"> Codeur</span>';
			$etoile = '<img style="opacity: 1; margin-right: 10px;" src="images/design/premium.png" height="23" width="23" />';
			break;

			case 100:
			$grade = ',<span style="font-weight: bold; color: #ff255e;"> Administrateur</span>';
			$etoile = '<img style="opacity: 1; margin-right: 10px;" src="images/design/premium.png" height="23" width="23" />';
			break;

			default:
			$grade = ', grade inconnu';
			$etoile = '';
		}


}
	if(isset($_SESSION['id']))
	{
		$r_donnees_membres = $connexion->prepare('SELECT * FROM membres WHERE pseudo = "' . $_SESSION['pseudo'] . '"');
		$r_donnees_membres->execute();
		$donnees_membres = $r_donnees_membres->fetch(PDO::FETCH_OBJ);

		$r_donnees_perso = $connexion->prepare('SELECT * FROM personnages WHERE idPseudo = ' . $_SESSION['id'] . '');
		$r_donnees_perso->execute();
		$donnees_perso = $r_donnees_perso->fetch(PDO::FETCH_OBJ);

		if($donnees_membres->experience < $niveau[$donnees_membres->niveau]['exp'])
		{
			$cheater = '<b><font color="red">[ Cheater ]</font></b> ';
		}
		else
		{
			$cheater = '';
		}

		/*if($donnees_perso->ptsCaracteristiques > 495)
		{
			$cheater = '<b><font color="red">[ Cheater ]</font></b> ';
		}
		else
		{
			$cheater = '';
		}*/
	}


echo '

<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" media="screen" title="css" href="style/design.css" />
		<link rel="stylesheet" type="text/css" media="screen" title="css" href="combat/design.css" />
		<link rel="stylesheet" href="style/jquery_ui.css">
		<link rel="icon" type="image/png" href="/images/fav2.png" />

		<script  type="text/javascript" src="javascript/jquery-2.1.1.js"></script>
		<script  type="text/javascript" src="javascript/jquery-ui.js"></script>
		<script  type="text/javascript" src="javascript/fenetre.js?' . time() . '"></script>
		<script  type="text/javascript" src="javascript/compte.js?' . time() . '"></script>
		<script  type="text/javascript" src="javascript/mp.js?' . time() . '"></script>
		<script  type="text/javascript" src="javascript/message.js?' . time() . '"></script>
		<script  type="text/javascript" src="javascript/forum.js?' . time() . '"></script>
		<script  type="text/javascript" src="javascript/sujet.js?' . time() . '"></script>
		<script  type="text/javascript" src="javascript/timer.js?' . time() . '"></script>

		<script  type="text/javascript" src="combat/envoi.js?' . time() . '"></script>


		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
 		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

		  <script>
		  $(function() {
		    $( "#accordion" ).accordion({
		      heightStyle: "content",
		      collapsible: true,
		      active: true
		    });
		  });
		  </script>

		<title>EvenForum - Le seul jeu-forum existant</title>
		<meta name="Content-Type" content="UTF-8">
		<meta name="Content-Language" content="fr">
		<meta name="Description" content="Participez à un RPG intégré à un forum. Créez votre personnage, choisissez ses compétences et devenez le joueur le plus expérimenté, ou le plus riche ! ( Voir les deux... )">
		<meta name="Copyright" content="TimeR, Evosis">
		<meta name="Author" content="TimeR, Evosis">
		<meta name="Revisit-After" content="15 days">
		<meta name="Robots" content="all">
		<meta name="Distribution" content="global">

	</head>
	<body>

	<div class="header">
		<div class="invisible_header">
			<a href="index.php"><img src="images/banner.png" /></a>
		</div>
	</div>

';

if($type_header == 1)
{

	$countPerso = $connexion->query('SELECT COUNT(*) FROM personnages WHERE idPseudo = ' . $_SESSION['id'])->fetchColumn();

	if($countPerso > 0)
	{
		$r_donnees_perso = $connexion->prepare('SELECT * FROM personnages WHERE idPseudo = ' . $_SESSION['id']);
		$r_donnees_perso->execute();
		$donnees_perso = $r_donnees_perso->fetch(PDO::FETCH_OBJ);

		$nomPerso = htmlspecialchars($donnees_perso->nomPerso);
	}
	else
	{
		$nomPerso = "Votre perso";
	}

	$nb_notif_non_lues = $connexion->query('SELECT COUNT(*) FROM notifications WHERE idPseudo = ' . $_SESSION['id'] . ' AND vue = 0')->fetchColumn();

	if($nb_notif_non_lues == 0)
	{
		$alert = 0;
	}
	else
	{
		$alert = '<font color="red">' . $nb_notif_non_lues . '</font>';
	}

	if($donnees_membres->niveau < 5 AND $donnees_membres->prestige == 0)
	{
		$color = "#ff2b47";
	}
	else
	{
		$color = "";
	}

echo '

	<div class="barreLaterale">
		<div class="invisible_header">
		<a style="margin-right: 80px;" href="stats.php"><img src="images/design/you.png" width="25" height="25" style="position: relative; top: 5px;" /> ' . $nomPerso . '</a>
		<a style="margin-right: 40px;" href="notifications.php"><img src="images/notifications/warn.png" height="25" width="25" style="position: relative; top: 5px;" /> Notif. (' . $alert . ')</a>
		<a style="margin-right: 40px;" href="mp.php?action=lire&page=1"><img src="images/design/mp.png" width="25" height="25" style="position: relative; top: 5px;" /> MP (0)</a>
		<a style="margin-right: 40px;" href="competences.php"><img src="images/design/skills.png" width="25" height="25" style="position: relative; top: 8px;" /> Compétences (' . $donnees_membres->pc . ')</a>
		<a style="margin-right: 40px;" href="inventaire.php"><img src="images/design/bag.png" width="25" height="25" style="position: relative; top: 5px;" /> Inventaire (' . $colorCountDrop . $countNbObj . '</font>)</a>
		<a style="margin-right: 40px; color: '. $color . '" href="quetes.php"><img src="images/design/quest.png" width="25" height="25" style="position: relative; top: 5px;" /> Quêtes (0)</a>
		<a style="margin-right: 40px;" href="achievements.php"><img src="images/design/achievements.png" width="25" height="25" style="position: relative; top: 5px;" /> Succès</a>
		</div>
	</div>

	';

}
else
{

echo '
	<div class="barreLaterale">
		<div class="invisible_header">
		Invité, non connecté
		<span style="float: right;"><a style="margin-right: 70px;" href="login.php">Connexion</a><a href="register.php">Inscription</a>
		</div>
	</div>
';

}

echo '

		<div class="cadre">

';

if(isset($_SESSION['pseudo']))
{

	echo '

	<div class="menuDroite" style="min-height: 108px;">
		<img src="' . $donnees_membres->avatar . '" width="110" height="110"  style="border: 1px solid #ccc; float: left; margin-right: 8px;" />
	<span style="font-weight: bold;">' . $_SESSION['pseudo'] . '</span>' . $grade . '<span style="float: right;"><a href="logout.php"><img src="images/design/logout.png" width="30" height="30" /></a></span><br />
	<font color="#0906ab">EXP</font> : ' . number_format($donnees_membres->experience) . ' ( <b> ' . $icon_rank . ' ' . $rankPrestige . $donnees_membres->niveau . ' </b> )<br />
	<font color="#00b201">EC</font> : ' . number_format($donnees_membres->ec) . '<br /><br />
	<a href="etat.php">État de compte</a><br />
	<a href="compte.php">Paramètres</a>
	</div>

	';

}

echo '
<div class="menuDroite" style="clear: right;">
		<center><span style="font-size: 18pt; font-weight: bold;">Forums principaux</span></center>
		<div class="separate"></div>
';

$r_donnees_forums = $connexion->prepare('SELECT * FROM forums ORDER BY id ASC');
$r_donnees_forums->execute();

while($donnees_forums = $r_donnees_forums->fetch(PDO::FETCH_OBJ))
{
	echo '
		<li><a href="forum.php?id=' . (int) $donnees_forums->id . '">' . htmlspecialchars($donnees_forums->nom) . '</a></li>
	';
}


echo '

<div class="separate"></div>
<li><a href="forum.php">Liste des forums</a></li>
<li><a href="combat.php">Combat Pré-Alpha</a></li>
	</div>

	<div class="menuDroite" style="clear: right;">
	<center><span style="font-size: 18pt; font-weight: bold;">Les connectés</span></center>
		<div class="separate"></div>
	';

	$req_membresco = $connexion->query('SELECT
				connectes.idPseudo AS `idPseudo`,
				connectes.acces AS `acces`,
				membres.id AS `idMembre`,
				membres.pseudo AS `pseudo`,
				membres.avatar AS avatar
				FROM connectes
				INNER JOIN membres
				ON membres.id = connectes.idPseudo
				ORDER BY pseudo');
		$req_membresco->execute();

		$count_nb_membresco = $connexion->query('SELECT COUNT(*) FROM connectes WHERE idPseudo > 0')->fetchColumn();

		$i = 0;
		while($don_membresco = $req_membresco->fetch(PDO::FETCH_OBJ))
		{
			if($i == $count_nb_membresco - 1)
			{
				$virgule = '';
			}
			else
			{
				$virgule = ', ';
			}

			if($count_nb_membresco == 1)
			{
				$virgule = '';
			}
			if($count_nb_membresco == 0)
			{
				$virgule = '';
			}

			$req_pseudo = $connexion->query('SELECT * FROM membres WHERE id = ' . $don_membresco->idPseudo . '') or die(print_r($connexion->errorInfo(), true));;
			$req_pseudo->execute();
			$don_pseudo = $req_pseudo->fetch(PDO::FETCH_OBJ);

			switch($don_membresco->acces)
			{
				case 10:
				$style_membre = '<span class="membre_connectes"><a style="font-weight: normal;" href="page-' . $don_pseudo->pseudo . '.html">' . $don_pseudo->pseudo . '</a></span>' . $virgule;
				break;

				case 20:
				$style_membre = '<span class="premium_connectes"><a href="page-' . $don_pseudo->pseudo . '.html">' . $don_pseudo->pseudo . '</a></span>' . $virgule;
				break;

				case 50:
				$style_membre = '<span class="modo_connectes"><a href="page-' . $don_pseudo->pseudo . '.html">' . $don_pseudo->pseudo . '</a></span>' . $virgule;
				break;

				case 80:
				$style_membre = '<span class="super_modo_connectes"><a href="page-' . $don_pseudo->pseudo . '.html">' . $don_pseudo->pseudo . '</a></span>' . $virgule;
				break;

				case 90:
				$style_membre = '<span class="codeur_connectes"><a href="page-' . $don_pseudo->pseudo . '.html">' . $don_pseudo->pseudo . '</a></span>' . $virgule;
				break;

				case 100:
				$style_membre = '<span class="admin_connectes"><a href="page-' . $don_pseudo->pseudo . '.html">' . $don_pseudo->pseudo . '</a></span>' . $virgule;
				break;

				default:
				$style_membre = '<span class="membre_connectes"><a href="page-' . $don_pseudo->pseudo . '.html">' . $don_pseudo->pseudo . '</a></span>' . $virgule;
			}

			echo $style_membre;
			$i++;
		}

		$count_nb_visiteurs = $connexion->query('SELECT COUNT(*) FROM connectes WHERE idPseudo = 0')->fetchColumn();

		if($count_nb_visiteurs == 1)
		{
			$sVisiteur = '';
		}
		else
		{
			$sVisiteur = 's';
		}

		if($count_nb_visiteurs != 0 AND $count_nb_membresco != 0)
		{
			echo ' et ' . $count_nb_visiteurs . ' visiteur' . $sVisiteur;
		}
		elseif($count_nb_visiteurs != 0 AND $count_nb_membresco == 0)
		{
			echo $count_nb_visiteurs . ' visiteur' . $sVisiteur;
		}


	echo '
	</div>
';

if(isset($_SESSION['pseudo']))
		{
			if($donnees_membres->ec < 0)
			{
				$connexion->query('UPDATE membres SET ec = 0 WHERE id = ' . $_SESSION['id']);
				avert('Suite à un bug, vos EC ont été réinitialisés.');
			}
		}

?>
