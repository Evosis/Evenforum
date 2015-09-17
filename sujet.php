<?php
include('base.php');
include('tete.php');

siMembre();

$count = $connexion->prepare('SELECT COUNT(*) FROM sujets WHERE id=' . intval($_GET['id']));
$count->execute();
$valeur = $count->fetchColumn();

if($valeur == 0)
{
	avert('Le sujet n\'existe pas ou n\'existe plus !');
	include('pied.php');
	exit;
}

if(!isset($_GET['page']) OR intval($_GET['page']) == 0)
{
	$page = 1;
}
else
{
	$page = $_GET['page'];
}

$req_sujet = $connexion->prepare('SELECT * FROM sujets WHERE id = ' . $_GET['id']);
$req_sujet->execute();
$don_sujet = $req_sujet->fetch(PDO::FETCH_OBJ);
$idForum = $don_sujet->idForum;

$requete = $connexion->prepare('SELECT * FROM forums WHERE id = ' . $idForum);
$requete->execute();
$donnees = $requete->fetch(PDO::FETCH_OBJ);
$etat = $donnees->etat;

$requeteKick = $connexion->prepare('SELECT * FROM kick WHERE pseudo = "' . $_SESSION['pseudo'] . '"');
$requeteKick->execute();
$donneesKick = $requeteKick->fetch(PDO::FETCH_OBJ);

if($donnees->acces != 1 AND $_SESSION['acces'] < 90) // On vérifie si notre pseudo se trouve dans la liste des participants ou qu'on en est
{
	avert('Vous n\'avez pas l\'autorisation nécéssaire pour accéder à ce forum !');
	include('pied.php');
	exit;
}

if($_SESSION['acces'] == 50)
{
	$requete = $connexion->prepare('SELECT * FROM modos WHERE idPseudo = ' . $_SESSION['id']);
	$requete->execute();
	$donnees = $requete->fetch(PDO::FETCH_OBJ);

	if($donnees->idForum == $idForum)
	{
		$accesModo = true;
	}
	else
	{
		$accesModo = false;
	}
}

$req_dernierpost = $connexion->prepare('SELECT timestamp FROM messages WHERE idAuteur = '. $_SESSION['id'] . ' AND timestamp = (SELECT MAX( timestamp ) FROM messages )');
$req_dernierpost->execute();
$temps_dernierpost = $req_dernierpost->fetch(PDO::FETCH_OBJ);


$time = time() - $temps_dernierpost->timestamp;

if(isset($_POST['message']))
{
	if(!empty($_POST['message']))
	{
		if($don_sujet->etat != '1.0' AND $don_sujet->etat != '2.0' OR $accesModo OR $_SESSION['acces'] >= 90)
		{
			if($time >= $temps_chaque_post)
			{
				if($_SESSION['acces'] == 50 AND $accesModo == false)
				{
					$acces = 10;
				}
				else
				{
					$acces = $_SESSION['acces'];
				}

				$getPage = (int) $_GET['page'];

				if(!isset($_GET['page']))
				{
					$getPage = 1;
				}

				$envoi2 = $connexion->prepare("INSERT INTO messages VALUES('', :idSujet, :idAuteur, :auteur, :message, '', '', :acces, '0', :ip, :timestamp, :timestampEdit)");
				$envoi2->execute(array(
				'idSujet' => $_GET['id'],
				'idAuteur' => $_SESSION['id'],
				'auteur' => $_SESSION['pseudo'],
				'message' => addslashes($_POST['message']),
				'acces' => $acces,
				'ip' => $_SESSION['ip'],
				'timestamp' => time(),
				'timestampEdit' => time()
				));

				$connexion->exec('UPDATE sujets SET timestamp=' . time() . ' WHERE id=' . $_GET['id']);

				if($donnees->ranked == 1)
				{
					giveEXP($EXP_post, $_SESSION['pseudo'], $connexion);
					giveEC($EC_post, $_SESSION['pseudo'], $connexion);
				}

				redirection('sujet.php?id=' . (int) $_GET['id'] . '&page=' . $getPage);
				exit;
			}
			else
			{
				avert('Vous postez trop vite. Veuillez attendre ' . $temps_chaque_post. ' secondes entre chaque envoi.');
			}
		}
		else
		{
			avert('Le sujet est verrouillé !');
		}
	}
	else
	{
		avert('Le message ne peut pas être vide !');
	}
}

$req_sujet = $connexion->prepare('SELECT * FROM sujets WHERE id = ' . $_GET['id']);
$req_sujet->execute();
$don_sujet = $req_sujet->fetch(PDO::FETCH_OBJ);

if($_GET['action'] == 'ban' AND isset($_GET['banId']) AND $_GET['token'] == $_SESSION['mToken'] AND $_SESSION['acces'] >= 90)
{
	$reponse = ban($_GET['banId'], $_GET['token'], $connexion);

	if($reponse)
	{
		info('Le membre a bien été banni !');
	}
	else
	{
		avert('Une erreur s\'est produite !');
	}
}

if($_GET['action'] == 'banIp' AND isset($_GET['banIp']) AND isset($_GET['banId']) AND $_GET['token'] == $_SESSION['mToken'] AND $_SESSION['acces'] >= 90)
{
	$reponse = banIp($_GET['banIp'], $_GET['banId'], $_GET['token'], $connexion);

	if($reponse)
	{
		info('Le membre a bien été banni !');
	}
	else
	{
		avert('Une erreur s\'est produite !');
	}
}

if($_GET['action'] == 'listeNoire' AND isset($_GET['listeNoireIp']) AND isset($_GET['listeNoireId']) AND $_GET['token'] == $_SESSION['mToken'] AND $_SESSION['acces'] == 90)
{
	$reponse = listeNoire($_GET['listeNoireIp'], $_GET['listeNoirId'], $_GET['token'], $connexion);

	if($reponse)
	{
		info('Le membre a bien été blacklisté !');
	}
	else
	{
		avert('Une erreur s\'est produite !');
	}
}

if($_GET['action'] == 'epingler' AND $_GET['token'] == $_SESSION['mToken'] AND $_SESSION['acces'] >= 50)
{
	if($don_sujet->etat != '2.0' AND $don_sujet->etat != '2.1')
	{
		if($don_sujet->etat == '1.0')
		{
			$connexion->exec('UPDATE sujets SET etat="2.0" WHERE id=' . $_GET['id']);
			info('Le sujet a bien été épinglé !');
		}
		else
		{
			$connexion->exec('UPDATE sujets SET etat="2.1" WHERE id=' . $_GET['id']);
			info('Le sujet a bien été épinglé !');
		}
	}
	else
	{
		avert('Le sujet est déjà épinglé !');
	}
}

if($_GET['action'] == 'desepingler' AND $_GET['token'] == $_SESSION['mToken'] AND $_SESSION['acces'] >= 50)
{
	if($don_sujet->etat == '2.0' OR $don_sujet->etat == '2.1')
	{
		if($don_sujet->etat == '2.0')
		{
			$connexion->exec('UPDATE sujets SET etat="1.0" WHERE id=' . $_GET['id']);
			info('Le sujet a bien été désepinglé !');
		}
		else
		{
			$connexion->exec('UPDATE sujets SET etat="1.1" WHERE id=' . $_GET['id']);
			info('Le sujet a bien été désepinglé !');
		}
	}
	else
	{
		avert('Le sujet est déjà désepinglé !');
	}
}

if($_GET['action'] == 'verrouiller' AND $_GET['token'] == $_SESSION['mToken'] AND $_SESSION['acces'] >= 50)
{
	if($don_sujet->etat != '1.0' AND $don_sujet->etat != '2.0')
	{
		if($don_sujet->etat == '2.1')
		{
			$connexion->exec('UPDATE sujets SET etat="2.0" WHERE id=' . $_GET['id']);
			info('Le sujet a bien été verrouillé !');
		}
		else
		{
			$connexion->exec('UPDATE sujets SET etat="1.0" WHERE id=' . $_GET['id']);
			info('Le sujet a bien été verrouillé !');
		}
	}
	else
	{
		avert('Le sujet est déjà verrouillé !');
	}
}

if($_GET['action'] == 'deverrouiller' AND $_GET['token'] == $_SESSION['mToken'] AND $_SESSION['acces'] >= 50)
{
	if($don_sujet->etat == '1.0' OR $don_sujet->etat == '2.0')
	{
		if($don_sujet->etat == '2.0')
		{
			$connexion->exec('UPDATE sujets SET etat="2.1" WHERE id=' . $_GET['id']);
			info('Le sujet a bien été déverrouillé !');
		}
		else
		{
			$connexion->exec('UPDATE sujets SET etat="1.1" WHERE id=' . $_GET['id']);
			info('Le sujet a bien été déverrouillé !');
		}
	}
	else
	{
		avert('Le sujet est déjà déverrouillé !');
	}
}

if($_GET['action'] == 'supprimerSujet' AND $_GET['token'] == $_SESSION['mToken'] AND $_SESSION['acces'] >= 90)
{
	if($don_sujet->etat != '0')
	{
		$connexion->exec('UPDATE sujets SET etat="0" WHERE id=' . $_GET['id']);
		info('Le sujet a bien été supprimé !');
	}
	else
	{
		avert('Le sujet est déjà supprimé !');
	}
}

if($_GET['action'] == 'remettreSujet' AND $_GET['token'] == $_SESSION['mToken'] AND $_SESSION['acces'] >= 90)
{
	if($don_sujet->etat == '0')
	{
		$connexion->exec('UPDATE sujets SET etat="1.1" WHERE id=' . $_GET['id']);
		info('Le sujet a bien été remis !');
	}
	else
	{
		avert('Le sujet est déjà remis !');
	}
}

if($_POST['idForum'] AND isset($_SESSION['mToken']) AND $_SESSION['acces'] >= 90)
{
	$connexion->exec('UPDATE sujets SET idForum=' . $_POST['idForum'] . ' WHERE id=' . $_GET['id']);
	info('Le sujet a bien été déplacé !');
}

if($_GET['action'] == 'detruireSujet' AND $_GET['token'] == $_SESSION['mToken'] AND $_SESSION['acces'] == 90)
{
	$connexion->exec('DELETE FROM sujets WHERE id=' . $_GET['id']);
	info('Le sujet a bien été détruit !');
}

$req_sujet = $connexion->prepare('SELECT * FROM sujets WHERE id = ' . $_GET['id']);
$req_sujet->execute();
$don_sujet = $req_sujet->fetch(PDO::FETCH_OBJ);
$idForum = $don_sujet->idForum;

$req_sujet = $connexion->prepare('SELECT * FROM sujets WHERE id = ' . $_GET['id']);
$req_sujet->execute();
$don_sujet = $req_sujet->fetch(PDO::FETCH_OBJ);

echo '

<h3> </h3>
<div class="contenu">
	<h2><center>Sujet : ' . stripslashes(htmlspecialchars($don_sujet->titre)) . '</center></h2>
	<div class="separate"></div>
	<span style="float: right;"><a href="forum.php?id=' . $idForum . '">Retour aux sujets</a></span><br />
	<span style="float: left;"></span>
</div>
';

$pagination = paginationSujet($connexion, $configuration);

echo '

<h3> </h3>
<div class="contenu">
	<span style="float: right;">' . $pagination['suivant'] . '</span>
	<span style="float: left;">' . $pagination['precedent'] . '</span>
	<center>' . $pagination['selectPage'] . '</center>
</div>
';

$requete = $connexion->prepare('SELECT * FROM messages WHERE idSujet=' . $_GET['id'] . ' ORDER BY timestamp ASC LIMIT ' . $pagination['min'] . ', ' . $pagination['max']);
$requete->execute();

$i = 0;

while($donnees_message = $requete->fetch(PDO::FETCH_OBJ))
{
	$requete_2 = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $donnees_message->idAuteur);
	$requete_2->execute();
	$donnees_membres = $requete_2->fetch(PDO::FETCH_OBJ);

	switch($donnees_membres->acces)
	{
		case 10:
		$rang = '<div class="membre">Membre</div>';
		break;

		case 20:
		$rang = '<div class="premium">Premium</div>';
		break;

		case 50:
		$rang = '<div class="modo">Modérateur</div>';
		break;

		case 80:
		$rang = '<div class="super_modo">Super-Modérateur</div>';
		break;

		case 90:
		$rang = '<div class="codeur">Codeur</div>';
		break;

		case 100:
		$rang = '<div class="admin">Administrateur</div>';
		break;
	}

	$count_mp = $connexion->query('SELECT COUNT(*) FROM messages WHERE idAuteur = ' . $donnees_message->idAuteur . '')->fetchColumn();

	if($count_mp < 2)
	{
		$s = "";
	}
	else
	{
		$s = "s";
	}

	if($donnees_membres->niveau == 12)
	{
		$niveau = "Dév.";
	}
	else
	{
		$niveau = $donnees_membres->niveau;
	}

	if($_SESSION['acces'] >= 80 OR $accesModo)
	{
		if($donnees_message->etat == 0)
		{
			$supprimer = '<a href="#" onclick="confirmer(\'Supprimer le message de ' . $donnees_membres->pseudo . '\', \'Êtes-vous sûr de vouloir supprimer le message de ' . $donnees_membres->pseudo . ' ?\', \'sujet.php?id=' . $_GET['id'] . '&page=' . $page . '&action=supprimer&sId=' . $donnees_membres->id . '&token=' . $_SESSION['mToken'] . '\'); return false;"><button class="supprimer">Supprimer le message</button></a><br /><br />';
		}

		if($donnees_membres->acces > 2 AND $donnees_membres->acces < 90)
		{
			$countKick = $connexion->prepare('SELECT COUNT(*) FROM kick WHERE idForum=' . $idForum . ' AND pseudo = "' . $donnees_membres->pseudo . '"');
			$countKick->execute();
			$siKick = $countKick->fetchColumn();

			if($siKick == 0)
			{
				$kick = '<a href="#" onclick="confirmer(\'Kicker ' . $donnees_membres->pseudo . '\', \'Êtes-vous sûr de vouloir kicker ' . $donnees_membres->pseudo . ' pendant 72h ?\', \'sujet.php?id=' . $_GET['id'] . '&page=' . $page . '&action=kick&kickId=' . $donnees_membres->id . '&token=' . $_SESSION['mToken'] . '\'); return false;"><button class="kick">Kicker le membre</button></a><br /><br />';
			}

			if($_SESSION['acces'] >= 90)
			{
				$ip = $donnees_message->ip;

				$ban = '<a href="#" onclick="confirmer(\'Bannir ' . $donnees_membres->pseudo . '\', \'Êtes-vous sûr de vouloir bannir définitivement ' . $donnees_membres->pseudo . ' ?\', \'sujet.php?id=' . $_GET['id'] . '&page=' . $page . '&action=ban&banId=' . $donnees_membres->id . '&token=' . $_SESSION['mToken'] . '\'); return false;"><button class="ban">Bannir le membre</button></a><br /><br />';
				$banIp = '<a href="#" onclick="confirmer(\'Bannir IP ' . $donnees_membres->pseudo . '\', \'Êtes-vous sûr de vouloir bannir IP ' . $donnees_membres->pseudo . ' ?\', \'sujet.php?id=' . $_GET['id'] . '&page=' . $page . '&action=banIp&banIp=' . $donnees_message->ip . '&banId=' . $donnees_membres->id . '&token=' . $_SESSION['mToken'] . '\'); return false;"><button class="banIp">Bannir IP le membre</button></a><br /><br />';

			}

			if($_SESSION['acces'] == 90)
			{
				$countBlackLister = $connexion->prepare('SELECT COUNT(*) FROM listeNoire WHERE ip=' . $idForum . '');
				$countBlackLister->execute();
				$siBlackLister = $countBlackLister->fetchColumn();

				if($siBlackLister == 0)
				{
					$listeNoire = '<a href="#" onclick="confirmer(\'Blacklister ' . $donnees_membres->pseudo . '\', \'Êtes-vous sûr de vouloir blacklister ' . $donnees_membres->pseudo . ' ?\', \'sujet.php?id=' . $_GET['id'] . '&page=' . $page . '&action=listeNoire&listeNoireIp=' . $donnees_message->ip . '&listeNoireId=' . $donnees_membres->id . '&token=' . $_SESSION['mToken'] . '\'); return false;"><button class="listeNoire">Blacklister</button></a><br />';
				}
			}
		}
	}

	$timestamp = $donnees_membres->timestamp;
	$mois_fr = array('', 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
	list($jour, $mois, $annee) = explode('/', date('d/n/Y', $timestamp));
	$inscrit_le = $jour . ' ' . $mois_fr[$mois] . ' ' . $annee;

	$timestamp_2 = $donnees_message->timestamp;
	list($jour, $mois, $annee) = explode('/', date('d/n/Y', $timestamp_2));
	$poste_le = $jour . ' ' . $mois_fr[$mois] . ' ' . $annee . ' à ' . date('H\ : i\ : s', $timestamp_2);

	switch($donnees_membres->sexe)
	{
		case 1:
		$color = "#3f00e0";
		break;

		case 2:
		$color = "#ff336f";
		break;

		default:
		$color = "#3f00e0";
	}

		if($donnees_membres->niveau <= 25)
	{
		$icon_rank = '♣';
	}
	elseif($donnees_membres->niveau <= 50 AND $donnees_membres->niveau > 25)
	{
		$icon_rank = '♦';
	}
	elseif($donnees_membres->niveau <= 75 AND $donnees_membres->niveau > 50)
	{
		$icon_rank = '♥';
	}
	elseif($donnees_membres->niveau <= 99 AND $donnees_membres->niveau > 75)
	{
		$icon_rank = '♠';
	}
	elseif($donnees_membres->niveau == 100)
	{
		$icon_rank = '&#9884;';
	}

	$timestamp = $donnees_message->timestamp;
	$mois_fr = array('', 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
	list($jour, $mois, $annee) = explode('/', date('d/n/Y', $timestamp));
	$poste_le = $jour . ' ' . $mois_fr[$mois] . ' ' . $annee . ' à ' . date('H\ : i\ : s', $timestamp);

	if($donnees_membres->prestige > 0)
	{
		$prestige_mark = entier_romain($donnees_membres->prestige) . ' - ';
	}
	else
	{
		$prestige_mark = "";
	}

	switch($donnees_membres->acces)
	{
		case 10:
		$etoilei = '';
		$back_color = '';
		break;

		case 20:
		$etoilei = '<img style="opacity: 1; margin-right: 10px;" src="images/design/premium.png" height="23" width="23" />';
		$back_color = 'style="background-color: #fff2dd;"';
		break;

		case 50:
		$etoilei = '<img style="opacity: 1; margin-right: 10px;" src="images/design/premium.png" height="23" width="23" />';
		$back_color = 'style="background-color: #ddddff;"';
		break;

		case 80:
		$etoilei = '<img style="opacity: 1; margin-right: 10px;" src="images/design/premium.png" height="23" width="23" />';
		$back_color = 'style="background-color: #ddffe1;"';
		break;

		case 90:
		$etoilei = '<img style="opacity: 1; margin-right: 10px;" src="images/design/premium.png" height="23" width="23" />';
		$back_color = 'style="background-color: #eeddff;"';
		break;

		case 100:
		$etoilei = '<img style="opacity: 1; margin-right: 10px;" src="images/design/premium.png" height="23" width="23" />';
		$back_color = 'style="background-color: #ffdddd;"';
		break;
	}

	switch($donnees_message->acces)
	{
		case 10:
		$pseudo = '<a href="page-' . $donnees_membres->pseudo . '.html"><span style="color: #000; font-weight: bold;">' . $donnees_membres->pseudo . '</span></a>';
		break;

		case 20:
		$pseudo = '<a href="page-' . $donnees_membres->pseudo . '.html"><span style="color: #ff9601; font-weight: bold;">' . $donnees_membres->pseudo . '</span></a>';
		break;

		case 50:
		$pseudo = '<a href="page-' . $donnees_membres->pseudo . '.html"><span style="color: #013dff; font-weight: bold;">' . $donnees_membres->pseudo . '</span></a>';
		break;

		case 80:
		$pseudo = '<a href="page-' . $donnees_membres->pseudo . '.html"><span style="color: #5aff01; font-weight: bold;">' . $donnees_membres->pseudo . '</span></a>';
		break;

		case 90:
		$pseudo = '<a href="page-' . $donnees_membres->pseudo . '.html"><span style="color: #7901ff; font-weight: bold;">' . $donnees_membres->pseudo . '</span></a>';
		break;

		case 100:
		$pseudo = '<a href="page-' . $donnees_membres->pseudo . '.html"><span style="color: #ff014c; font-weight: bold;">' . $donnees_membres->pseudo . '</span></a>';
		break;
	}

	echo '

		<div class="post" ' . $back_color . '>
			<div class="pseudo">
				<div class="avatar">
					<img src="' . $donnees_membres->avatar . '" />
				</div>
				' . $etoilei . $pseudo . '

				<div class="date_envoi">
					Envoyé le ' . $poste_le . '
				</div>
			</div>
			<b><font size="5" face="Arial">' . $icon_rank . '</font> <font size="4">' . $prestige_mark . $donnees_membres->niveau . '</font></b><br />
			EXP : <b>' . number_format($donnees_membres->experience) . '</b>
			<br />
			<div class="separate"></div>
			' . nl2br(bbCode(stripslashes(htmlspecialchars($donnees_message->message)))) . '
	</div>

	';



	$i++;
}

echo '
<h3> </h3>
<div class="contenu">
	<span style="float: right;">' . $pagination['suivant'] . '</span>
	<span style="float: left;">' . $pagination['precedent'] . '</span>
	<center>' . $pagination['selectPage'] . '</center>
</div>
';

if($etat == 0 OR $_SESSION['acces'] >= 90)
{
	if($donnees->etat != "1.0" AND $donnees->etat != "2.0" OR $accesModo OR $_SESSION['acces'] >= 90)
	{
		echo '
		<h3>Repondre au sujet <span style="float: right;"><a href="forum.php?id=' . $idForum . '"><img src="images/forum/retourClair.png" /></a></span></h3>
		<div class="contenu">
			<form method="post">
				<div class="contenuBbcode">
					<div class="sousContenuBbcode">
						<span class="boutonBbcode" onclick="replaceTextareaSelection(document.getElementById(\'messageBloc\'), \'[b]\', \'[/b]\');" value="B">B</span>
						<span class="boutonBbcode" onclick="replaceTextareaSelection(document.getElementById(\'messageBloc\'), \'[u]\', \'[/u]\');" value="U">U</span>
						<span class="boutonBbcode" onclick="replaceTextareaSelection(document.getElementById(\'messageBloc\'), \'[i]\', \'[/i]\');" value="I">I</span>
						<span class="boutonBbcode" onclick="replaceTextareaSelection(document.getElementById(\'messageBloc\'), \'[s]\', \'[/s]\');" value="S">S</span>
					</div>

					<div class="sousContenuBbcode">
						<span class="boutonBbcode" onclick="replaceTextareaSelection(document.getElementById(\'messageBloc\'), \'[citer]\', \'[/citer]\');" value="S"><img src="images/bbcode/blockquoteClair.png" /></span>
						<span class="boutonBbcode" onclick="replaceTextareaSelection(document.getElementById(\'messageBloc\'), \'[cacher]\', \'[/cacher]\');" value="Cacher"><img src="images/bbcode/spoilerClair.png" /></span>
					</div>

					<div class="sousContenuBbcode">
						<span class="boutonBbcode" onclick="replaceTextareaSelection(document.getElementById(\'messageBloc\'), \'[img]\', \'[/img]\');" value="IMG"><img src="images/bbcode/imageClair.png" /></span>
						<span class="boutonBbcode"><img src="images/bbcode/smileyClair.png" /></span>
					</div>
				</div>
				<textarea name="message" placeholder="Veuillez respecter la charte et les règles en vigueurs du forum." class="form"></textarea><br />
				<center><input type="submit" /> <input type="button" value="Aperçu" /></center>
			</form>
		</div>
		';
	}
}
else
{
	echo '
	<div class="contenu">
		<center>Ce forum est <b>verrouillé</b>, vous ne pouvez pas créer de sujet.</center>
	</div>
	';
}

include('pied.php');
?>
