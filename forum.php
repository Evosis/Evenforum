<?php
include('base.php');


if(!isset($_SESSION['id']))
{
	include('tete.php');
	siMembre();
}

if(!isset($_GET['id']))
{
	include('tete.php');

	$req_forum = $connexion->prepare('SELECT * FROM forums ORDER by id ASC');
	$req_forum->execute();
	

	echo '
		<h3>Liste des forums</h3>
		<div class="contenu">
	';

	while($donnees_forum = $req_forum->fetch(PDO::FETCH_OBJ))
	{
		switch($donnees_forum->acces)
		{
			case 1: 
			$acces = "Public";
			break;

			case 2: 
			$acces = "Premium";
			break;

			case 3:
			$acces = "Modérateurs et administrateurs";
			break;

			case 4:
			$acces = "Codeurs, pour les tests";
			break;

			default:
			$acces = "Public";
		}

		echo '
		<span style="font-weight: bold; font-size: 17px;"><a href="forum.php?id=' . $donnees_forum->id . '">' . htmlspecialchars($donnees_forum->nom) . '</a></span><br />
		Accès :<b> ' . $acces . '</b><br /><br />
		' . nl2br(htmlspecialchars($donnees_forum->description)) . '
		<div class="separate"></div>

		';
	}

	echo '
	</div>';


	include('pied.php');
	exit;
}

$count = $connexion->prepare('SELECT COUNT(*) FROM forums WHERE id=' . intval($_GET['id']));
$count->execute();
$valeur = $count->fetchColumn();

if($valeur == 0)
{
	avert('Le forum n\'existe pas ou n\'existe plus !');
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

if($_SESSION['acces'] == 50)
{
	$requete = $connexion->prepare('SELECT * FROM modos WHERE idPseudo = ' . $_SESSION['id']);
	$requete->execute();
	$donnees = $requete->fetch(PDO::FETCH_OBJ);

	if($donnees->idForum == $_GET['id'])
	{
		$accesModo = true;
	}
	else
	{
		$accesModo = false;
	}
}

if($accesModo OR $_SESSION['acces'] >= 90)
{
	$formDebut = '<form method="post" id="supprimerForm"> <input type="hidden" name="token" value="' . $_SESSION['mToken'] . '" />';
	$formFin = '</form>';
	$checkbox = '<th width="3%"><input type="checkbox" onclick="sujetSupprimerAll(this);" /></th>';
}

$req_derniertopic = $connexion->prepare('SELECT timestamp FROM sujets WHERE idAuteur = "'. $_SESSION['id'] . '" AND timestamp = (SELECT MAX( timestamp ) FROM sujets )');
$req_derniertopic->execute();
$temps_derniertopic = $req_derniertopic->fetch(PDO::FETCH_OBJ);

$time = time() - $temps_derniertopic->timestamp;

$req_forum = $connexion->prepare('SELECT * FROM forums WHERE id = ' . $_GET['id']);
$req_forum->execute();
$don_forum = $req_forum->fetch(PDO::FETCH_OBJ);

if(isset($_POST['titre']) AND isset($_POST['message']))
{
	if(!empty($_POST['titre']))
	{
		if(!empty($_POST['message']))
		{
			if($time >= $temps_chaque_topic)
			{
				if($_SESSION['acces'] == 50 AND $accesModo == false)
				{
					$acces = 10;
				}
				else
				{
					$acces = $_SESSION['acces'];
				}

				$envoi = $connexion->prepare("INSERT INTO sujets VALUES('', :idForum, :idAuteur, :auteur, :titre, :etat, :acces, :timestamp, :timestampCreation)");
				$envoi->execute(array(
				'idForum' => $_GET['id'],
				'idAuteur' => $_SESSION['id'],
				'auteur' => $_SESSION['pseudo'],
				'titre' => addslashes($_POST['titre']),
				'etat' => '1.1',
				'acces' => $acces,
				'timestamp' => time(),
				'timestampCreation' => time()
				));

				$idSujet = $connexion->lastInsertId('sujets');

				$envoi2 = $connexion->prepare("INSERT INTO messages VALUES('', :idSujet, :idAuteur, :auteur, :message, '', '', :acces, '0', :ip, :timestamp, :timestampEdit)");
				$envoi2->execute(array(
				'idSujet' => $idSujet,
				'idAuteur' => $_SESSION['id'],
				'auteur' => $_SESSION['pseudo'],
				'message' => addslashes($_POST['message']),
				'acces' => $acces,
				'ip' => $_SESSION['ip'],
				'timestamp' => time(),
				'timestampEdit' => time()
				));

				if($don_forum->ranked == 1)
				{
					giveEXP($EXP_topic, $_SESSION['pseudo'], $connexion);
					giveEC($EC_topic, $_SESSION['pseudo'], $connexion);
				}
				
				info('Votre sujet a bien été envoyé !');
				header('Location: forum.php?id=' . (int) $_GET['id']);
				exit;
			}
			else
			{
				include('tete.php');
				avert('Vous postez trop vite. Vous devez attendre ' . $temps_chaque_topic . ' secondes entre chaque envoi.');
			}

		}
		else
		{
			include('tete.php');
			avert('Le message ne peut pas être vide! ');
		}
	}
	else
	{
		include('tete.php');
		avert('Le titre ne peut pas être vide !');
	}
}
else
{
	include('tete.php');
}

if($don_forum->ranked == 0)
{
	avert('EXP/EC désactivés dans ce forum.');
}

if($don_forum->acces == 4)
{
	if($donnees_membres->acces < 90)
	{
		avert('Accès interdit.');
		include('pied.php');
		exit;
	}
}


if(isset($_POST['supprimer']) AND $_POST['token'] == $_SESSION['mToken'] AND $_SESSION['acces'] >= 50)
{
	$listeId = implode(",", $_POST["supprimer"]);

	$connexion->exec('UPDATE sujets SET etat="0" WHERE id IN (' . $listeId . ')');
	info('Les sujets ont bien été supprimés !');
}

$pagination = paginationForum($connexion, $configuration);

echo '
<h3>' . stripslashes(htmlspecialchars($don_forum->nom)) . ' 

		<span style="position: relative; left: 300px;">
			<input type="text" name="rechercheSujet" id="rechercheSujet" /> 
			<a href="#" onclick="javascript:location.reload();"><img src="images/forum/reloadClair.png" class="luminosite" /></a>
		</span>
	</h3>
<div class="contenu">
	
	
	<span style="float: right;">' . $pagination['suivant'] . '</span>
	<span style="float: left;">' . $pagination['precedent'] . '</span>
	<center>' . $pagination['selectPage'] . '</center>
</div>

<table>
	' . $formDebut . '
		<tr>
			' . $checkbox . '
			<th width="3%"></th>
			<th width="40%">Titre</th>
			<th width="7%">Réponse</th>
			<th width="15%">Auteur</th>
			<th width="16%">Date</th>
		</tr>
';

$count = $connexion->prepare('SELECT COUNT(*) FROM sujets WHERE idForum=' . intval($_GET['id']));
$count->execute();
$nombreSujet = $count->fetchColumn();

if($nombreSujet != 0)
{
	$req_sujet = $connexion->prepare('SELECT * FROM sujets WHERE idForum = ' . $_GET['id'] . ' AND etat != "0" ORDER BY ROUND( etat ) DESC, timestamp DESC LIMIT ' . $pagination['min'] . ', ' . $pagination['max']);
	$req_sujet->execute();

	while($don_sujet = $req_sujet->fetch(PDO::FETCH_OBJ))
	{
		$nbMessage = $connexion->query('SELECT COUNT(*) FROM messages WHERE idSujet=' . $don_sujet->id)->fetchColumn();
		$nbMessage--;
		$image = '';

		if($don_sujet->etat == "1.0")
		{
			$image = "1.0";
		}
		elseif($don_sujet->etat == "2.0")
		{
			$image = "2.0";
		}
		elseif($don_sujet->etat == "2.1")
		{
			$image = "2.1";
		}
		elseif($nbMessage >= 0 AND $nbMessage < 20)
		{
			$image = "1.1";
			$connexion->exec('UPDATE sujets SET etat="1.1" WHERE id=' . $don_sujet->id);
		}
		elseif($nbMessage >= 20 AND $nbMessage < 50)
		{
			$image = "1.2";
			$connexion->exec('UPDATE sujets SET etat="1.2" WHERE id=' . $don_sujet->id);
		}
		elseif($nbMessage >= 50 AND $nbMessage < 100)
		{
			$image = "1.3";
			$connexion->exec('UPDATE sujets SET etat="1.3" WHERE id=' . $don_sujet->id);
		}
		elseif($nbMessage >= 100)
		{
			$image = "1.4";
			$connexion->exec('UPDATE sujets SET etat="1.4" WHERE id=' . $don_sujet->id);
		}

		switch($don_sujet->acces)
		{
			case 10:
			$auteur = '<span class="membre_connectes"><a href="page-' . $don_sujet->auteur . '.html">' . $don_sujet->auteur . '</a></span>';
			break;

			case 20:
			$auteur = '<span class="premium_connectes"><a href="page-' . $don_sujet->auteur . '.html">' . $don_sujet->auteur . '</a></span>';
			break;

			case 50:
			$auteur = '<span class="modo_connectes"><a href="page-' . $don_sujet->auteur . '.html">' . $don_sujet->auteur . '</a></span>';
			break;

			case 80:
			$auteur = '<span class="super_modo_connectes"><a href="page-' . $don_sujet->auteur . '.html">' . $don_sujet->auteur . '</a></span>';
			break;

			case 90:
			$auteur = '<span class="codeur_connectes"><a href="page-' . $don_sujet->auteur . '.html">' . $don_sujet->auteur . '</a></span>';
			break;

			case 100:
			$auteur = '<span class="admin_connectes"><a href="page-' . $don_sujet->auteur . '.html">' . $don_sujet->auteur . '</a></span>';
			break;

			default:
			$auteur = '<span class="membre_connectes"><a href="page-' . $don_sujet->auteur . '.html">' . $don_sujet->auteur . '</a></span>';
		}

		if($accesModo OR $_SESSION['acces'] >= 90)
		{
			$checkboxTD = '<td id="' . $don_sujet->id . '" name="supprimerTd" style="text-align: center;"><input type="checkbox" id="checkbox_' . $don_sujet->id . '" name="supprimer[]" value="' . $don_sujet->id . '" onchange="sujetSupprimer(\'' . $don_sujet->id . '\');" /></td>';
		}
		else
		{
			$checkboxTD = '';
		}

		echo '
		<tr>
			' . $checkboxTD . '
			<td id="' . $don_sujet->id . 'a" name="supprimerTd" style="text-align: center;"><img src="images/forum/' . $image . '.png"  style="vertical-align: middle;"/></td>
			<td id="' . $don_sujet->id . 'b" name="supprimerTd" style="text-align: left;"><a href="sujet.php?id=' . $don_sujet->id . '">' . stripslashes(htmlspecialchars($don_sujet->titre)) . '</a></td>
			<td id="' . $don_sujet->id . 'c" name="supprimerTd" style="text-align: center;">' . $nbMessage . '</td>
			<td id="' . $don_sujet->id . 'd" name="supprimerTd" style="text-align: center;">' . $auteur . '</td>
			<td id="' . $don_sujet->id . 'e" name="supprimerTd" style="text-align: center;">' . date('d/m/Y\ à H\hi', $don_sujet->timestamp) . '</td>
		</tr>
		';
	}
}
else
{
	echo '
	<tr>
		<td colspan="6" style="text-align: center;">Aucun sujet</td>
	</tr>
	';
}

echo '
	' . $formFin . '
</table>
';

if(isset($_SESSION['id']))
{
	if($don_forum->etat == 0 OR $_SESSION['acces'] >= 90)
	{
		echo '
		<br /><br />
		<h3>Créer un sujet</h3>
		<div class="contenu">
			<form method="post"><br />
				<input class="form" type="text" name="titre" placeholder="Titre du sujet, 75 caractères maximum." maxlength="75" />
				<br /><br /><div class="contenuBbcode">
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
				<textarea id="messageBloc" name="message" placeholder="Veuillez respecter la charte et les règles en vigueurs du forum." class="form"></textarea><br />
				<center><input type="submit" /> <input type="button" value="Aperçu" /></center>
			</form>
		</div>
		';
	}
	else
	{
		echo '
		<h3>ERREUR</h3>
		<div class="contenu">
			<center>Ce forum est <b>verrouillé</b>, vous ne pouvez pas créer de sujet.</center>
		</div>
		';
	}
}
else
{
	echo '
	<h3>ERREUR</h3>
	<div class="contenu">
		<center>Vous devez vous <a href="connexion.php">connecter</a> pour créer un sujet.</center>
	</div>
	';
}

include('pied.php');
?>