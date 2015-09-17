<?php
include('base.php');
include('tete.php');

siMembre();

$count = $connexion->prepare('SELECT COUNT(*) FROM mpFil WHERE id=' . intval($_GET['id']));
$count->execute();
$valeur = $count->fetchColumn();

if($valeur == 0)
{
	avert('Le fil de discussion n\'existe pas ou n\'existe plus !');
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

$requete = $connexion->prepare('SELECT * FROM mpFil WHERE id = ' . $_GET['id']);
$requete->execute();
$donnees = $requete->fetch(PDO::FETCH_OBJ);

$destinataire = explode(",", $donnees->participant); // On met dans un tableau la liste des participants

if(!in_array($_SESSION['pseudo'], $destinataire) AND $_SESSION['pseudo'] != $donnees->auteur AND $_SESSION['acces'] != 90) // On vérifie si notre pseudo se trouve dans la liste des participants ou qu'on en est 
{	
	avert('Ce message privé ne vous concerne pas !');
	include('pied.php');
	exit;
}

$connexion->exec('DELETE FROM mpNotif WHERE idFil=' . $_GET['id'] . ' AND toPseudo="' . $_SESSION['pseudo'] . '"');

if(isset($_POST['message']))
{
	if(!empty($_POST['message']))
	{
		if($donnees->etat != "1.0")
		{
			$envoi = $connexion->prepare("INSERT INTO mpMessage VALUES('', :idFil, :idPseudo, :pseudo, :message, :type, :timestamp)");
			$envoi->execute(array(
			'idFil' => $_GET['id'],
			'idPseudo' => $_SESSION['id'],
			'pseudo' => $_SESSION['pseudo'],
			'message' => addslashes($_POST['message']),
			'type' => '0', // Type 0 = Message | Type 1 = Invitation | Type 2 = Exclusion | Type 3 = Départ | Type 4 = Fermeture
			'timestamp' => time()
			));
			foreach ($destinataire as $des) 
			{
				if($des != $_SESSION['pseudo'])
				{
					$envoi2 = $connexion->prepare("INSERT INTO mpNotif VALUES('', :idFil, :pseudo, :toPseudo, :timestamp)");
					$envoi2->execute(array(
					'idFil' => $_GET['id'],
					'pseudo' => $_SESSION['pseudo'],
					'toPseudo' => $des,
					'timestamp' => time()
					));
				}
			}
			if($donnees->auteur != $_SESSION['pseudo'])
			{
				$envoi3 = $connexion->prepare("INSERT INTO mpNotif VALUES('', :idFil, :pseudo, :toPseudo, :timestamp)");
				$envoi3->execute(array(
				'idFil' => $_GET['id'],
				'pseudo' => $_SESSION['pseudo'],
				'toPseudo' => $donnees->auteur,
				'timestamp' => time()
				));
			}
			$connexion->exec('UPDATE mpFil SET timestamp=' . time() . ' WHERE id=' . $_GET['id']);
			info('Votre message a bien été envoyé !');

			}
		else
		{
			avert('Cette conversation est fermé !');
		}
	}
	else
	{
		avert('Votre message ne peut être vide !');
	}
}

if(isset($_POST['invitation']))
{
	if($_SESSION['pseudo'] == $donnees->auteur)
	{
		if($donnees->etat != "1.0")
		{
			if(!empty($_POST['invitation']))
			{
				$i = 0;
				$ok = true;
				$destinataires = $donnees->participant;
				$invitation = explode(",", $_POST['invitation']);
				$participant = explode(",", $donnees->participant);

				foreach ($invitation as $invit) 
				{	
					$count = $connexion->prepare('SELECT COUNT(*) FROM membres WHERE pseudo="' . $invit . '"');
					$count->execute();
					$valeur = $count->fetchColumn();
					
					if($valeur == 0)
					{
						avert('Le pseudo ' . $invit . ' n\'existe pas !');
						$ok = false;
						break;
					}

					if($invit == $_SESSION['pseudo'])
					{
						avert('Vous ne pouvez pas vous ajouter !');
						$ok = false;
						break;
					}

					if(in_array($invit, $participant))
					{
						avert($invit . ' est déjà dans la conversation !');
						$ok = false;
						break;
					}

					if($i != 0)
					{
						$invites .= ",";
					}

					$destinataires .= ",";
					$destinataires .= $invit;
					$invites .= $invit;
					$i++;
				}

				if($ok == true)
				{
					$connexion->exec('UPDATE mpFil SET participant="' . $destinataires . '" WHERE id=' . $_GET['id']);
					$envoi = $connexion->prepare("INSERT INTO mpMessage VALUES('', :idFil, :idPseudo, :pseudo, :message, :type, :timestamp)");
					$envoi->execute(array(
					'idFil' => $_GET['id'],
					'idPseudo' => $_SESSION['id'],
					'pseudo' => $invites,
					'message' => '',
					'type' => '1', // Type 0 = Message | Type 1 = Invitation | Type 2 = Exclusion | Type 3 = Départ | Type 4 = Fermeture
					'timestamp' => time()
					));
					$connexion->exec('UPDATE mpFil SET timestamp=' . time() . ' WHERE id=' . $_GET['id']);
					info('Les participants ont bien été rajoutés dans la conversation !');
				}
			}
			else
			{
				avert('Il doit y avoir au moins un destinataire !');
			}
		}
		else
		{
			avert('Cette conversation est fermé !');
		}
	}
	else
	{
		avert('Vous n\'êtes pas l\'auteur de cette conversation !');
	}
}

if($_GET['action'] == "exclure" AND isset($_GET['ePseudo']))
{
	if($_SESSION['pseudo'] == $donnees->auteur)
	{
		if($_GET['ePseudo'] != $donnees->auteur)
		{
			if(in_array($_GET['ePseudo'], $destinataire))
			{
				if($donnees->etat != "1.0")
				{
					$i = 0;
					$destinataires = '';
					$destinataire = explode(",", $donnees->participant);
					$nbDestinataire = count($destinataire);

					foreach($destinataire AS $des)
					{
						if($des != $_GET['ePseudo'])
						{
							if($i != 0 AND $nbDestinataire > 2 AND !empty($destinataires))
							{
								$destinataires .= ",";
							}

							$destinataires .= $des;
						}
						$i++;
					}
					$connexion->exec('UPDATE mpFil SET participant="' . $destinataires . '" WHERE id=' . $_GET['id']);
					$envoi = $connexion->prepare("INSERT INTO mpMessage VALUES('', :idFil, :idPseudo, :pseudo, :message, :type, :timestamp)");
					$envoi->execute(array(
					'idFil' => $_GET['id'],
					'idPseudo' => $_SESSION['id'],
					'pseudo' => $_GET['ePseudo'],
					'message' => '',
					'type' => '2', // Type 0 = Message | Type 1 = Invitation | Type 2 = Exclusion | Type 3 = Départ | Type 4 = Fermeture
					'timestamp' => time()
					));
					$connexion->exec('UPDATE mpFil SET timestamp=' . time() . ' WHERE id=' . $_GET['id']);
					info($_GET['ePseudo'] . ' a été exlu de la conversation !');
				}
				else
				{
					avert('Cette conversation est fermé !');
				}
			}
			else
			{
				avert('Ce membre n\'est pas un participant de cette conversation !');
			}
		}
		else
		{
			avert('Vous ne pouvez pas vous exclure de la conversation !');
		}
	}
	else
	{
		avert('Vous n\'êtes pas l\'auteur de cette conversation !');
	}
}

if($_GET['action'] == "quitter")
{
	if($_SESSION['pseudo'] != $donnees->auteur)
	{
		if(in_array($_SESSION['pseudo'], $destinataire))
		{
			if($donnees->etat != "1.0")
			{
				$i = 0;
				$destinataires = '';
				$destinataire = explode(",", $donnees->participant);
				$nbDestinataire = count($destinataire);

				foreach($destinataire AS $des)
				{
					if($des != $_SESSION['pseudo'])
					{
						if($i != 0 AND $nbDestinataire > 2 AND !empty($destinataires))
						{
							$destinataires .= ",";
						}

						$destinataires .= $des;
					}
					$i++;
				}

				$connexion->exec('UPDATE mpFil SET participant="' . $destinataires . '" WHERE id=' . $_GET['id']);
				$envoi = $connexion->prepare("INSERT INTO mpMessage VALUES('', :idFil, :idPseudo, :pseudo, :message, :type, :timestamp)");
				$envoi->execute(array(
				'idFil' => $_GET['id'],
				'idPseudo' => $_SESSION['id'],
				'pseudo' => $_SESSION['pseudo'],
				'message' => '',
				'type' => '3', // Type 0 = Message | Type 1 = Invitation | Type 2 = Exclusion | Type 3 = Départ | Type 4 = Fermeture
				'timestamp' => time()
				));
				$connexion->exec('UPDATE mpFil SET timestamp=' . time() . ' WHERE id=' . $_GET['id']);
				info('Vous avez quitté la conversation ! <a href="mp.php?action=lire">Retour aux MPs</a>');
				include('pied.php');
				exit;
			}
			else
			{
				avert('Cette conversation est fermé !');
			}
		}
		else
		{
			avert('Vous n\'êtes pas un participant de cette conversation !');
		}
	}
	else
	{
		avert('Vous ne pouvez pas quitter votre propre conversation !');
	}
}

if($_GET['action'] == "fermer")
{
	if($_SESSION['pseudo'] == $donnees->auteur)
	{
		if($donnees->etat != "1.0")
		{
			$connexion->exec('UPDATE mpFil SET etat="1.0" WHERE id=' . $_GET['id']);
			$envoi = $connexion->prepare("INSERT INTO mpMessage VALUES('', :idFil, :idPseudo, :pseudo, :message, :type, :timestamp)");
			$envoi->execute(array(
			'idFil' => $_GET['id'],
			'idPseudo' => $_SESSION['id'],
			'pseudo' => $_SESSION['pseudo'],
			'message' => '',
			'type' => '4', // Type 0 = Message | Type 1 = Invitation | Type 2 = Exclusion | Type 3 = Départ | Type 4 = Fermeture
			'timestamp' => time()
			));
			$connexion->exec('UPDATE mpFil SET timestamp=' . time() . ' WHERE id=' . $_GET['id']);
			info('Le fil de discussion a bien été fermé !');
		}
		else
		{
			avert('Cette conversation est déjà fermé !');
		}
	}
	else
	{
		avert('Vous n\'êtes pas l\'auteur de cette conversation !');
	}
}

$requete = $connexion->prepare('SELECT * FROM mpFil WHERE id = ' . $_GET['id']);
$requete->execute();
$donnees = $requete->fetch(PDO::FETCH_OBJ);

if($_SESSION['pseudo'] == $donnees->auteur AND $donnees->etat != "1.0")
{
	$action = '<a href="message.php?id=' . $_GET['id'] . '&page=' . $page . '&action=fermer">Fermer la conversation</a>';
}
elseif(in_array($_SESSION['pseudo'], $destinataire) AND $donnees->etat != "1.0")
{
	$action = '<a href="message.php?id=' . $_GET['id'] . '&page=' . $page . '&action=quitter">Quitter la conversation</a>';
}

echo '
<h3></h3>
<div class="contenu">
	<h2><center>Sujet : ' . stripslashes(htmlspecialchars($donnees->objet)) . '</center></h2>
	<div class="separate"></div>
	<span style="float: right;"><a href="mp.php?action=lire">Retour aux MPs</a></span>
	<span style="float: left;">' . $action . '</span>
</div>
';

$pagination = paginationMpMessage($connexion, $configuration);

echo '
<h3></h3>
<div class="contenu">
	<span style="float: right;">' . $pagination['suivant'] . '</span>
	<span style="float: left;">' . $pagination['precedent'] . '</span>
	<center>' . $pagination['selectPage'] . '</center>
</div>
';

$requete = $connexion->prepare('SELECT * FROM mpMessage WHERE idFil=' . $_GET['id'] . ' ORDER BY timestamp ASC LIMIT ' . $pagination['min'] . ', ' . $pagination['max']);
$requete->execute();

while($donnees_message = $requete->fetch(PDO::FETCH_OBJ))
{
	if($donnees_message->type == 0) // Type 0 = Message
	{
		$requete_2 = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $donnees_message->idPseudo);
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

		//$count_mp = $connexion->query('SELECT COUNT(*) FROM mpMessages WHERE idPseudo = ' . $donnees_message->idPseudo . '')->fetchColumn();

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
		elseif($donnees_membres->niveau <= 100 AND $donnees_membres->niveau > 75)
		{
			$icon_rank = '♠';
		}

		$timestamp = $donnees_message->timestamp;
		$mois_fr = array('', 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
		list($jour, $mois, $annee) = explode('/', date('d/n/Y', $timestamp));
		$poste_le = $jour . ' ' . $mois_fr[$mois] . ' ' . $annee . ' à ' . date('H\ : i\ : s', $timestamp);

		echo '

			<div class="post">
				<div class="pseudo">
					<div class="avatar">
						<img src="http://www.evenforum.com/' . $donnees_membres->avatar . '" />
					</div>
					' . $donnees_membres->pseudo . '

					<div class="date_envoi">
						Envoyé le ' . $poste_le . '
					</div>
				</div>
				<b><font size="5" face="Arial">' . $icon_rank . '</font> <font size="4">' . $donnees_membres->niveau . '</font></b><br />
				EXP : <b>' . number_format($donnees_membres->experience) . '</b>
				<br />
				<div class="separate"></div>
				' . nl2br(bbCode(stripslashes(htmlspecialchars($donnees_message->message)))) . '
		</div>

		';
	}
	elseif($donnees_message->type == 1) // Type 1 = Invitation
	{
		$destinataire = explode(",", $donnees_message->pseudo); // On met dans un tableau la liste des participants
		$i = 0;
		$invites = "";
		$nbDestinataire = count($destinataire);

		foreach($destinataire AS $des)
		{
			$invites .= $des;
			
			if($nbDestinataire - $i > 2)
			{
				$invites .= ", ";
			}
			elseif($nbDestinataire > 1 AND $nbDestinataire - $i > 1)
			{
				$invites .= " et ";
			}
			$i++;
		}

		if($nbDestinataire > 1)
		{
			$texte = 'ont été ajoutés';
		}
		else
		{
			$texte = 'a été ajouté';
		}

		echo '
		<h3></h3>
		<div class="contenu">
			<center><b>' . $invites . '</b> ' . $texte . ' à la conversation.</center>
		</div>
		';
	}
	elseif($donnees_message->type == 2) // Type 2 = Exclusion
	{
		echo '
		<h3></h3>
		<div class="contenu">
			<center><b>' . $donnees_message->pseudo . '</b> a été exclu de la conversation.</center>
		</div>
		';
	}
	elseif($donnees_message->type == 3) // Type 3 = Départ
	{
		echo '
		<h3></h3>
		<div class="contenu">
			<center><b>' . $donnees_message->pseudo . '</b> a quitté la conversation.</center>
		</div>
		';
	}
	elseif($donnees_message->type == 4) // Type 4 = Fermeture
	{
		echo '
		<h3></h3>
		<div class="contenu">
			<center>La conversation a été <b>fermé</b> par <b>' . $donnees_message->pseudo . '</b></center>
		</div>
		';
	}
}

echo '
<h3></h3>
<div class="contenu">
	<span style="float: right;">' . $pagination['suivant'] . '</span>
	<span style="float: left;">' . $pagination['precedent'] . '</span>
	<center>' . $pagination['selectPage'] . '</center>
</div>
';

if($donnees->etat != "1.0")
{
	$destinataire = explode(",", $donnees->participant); // On met dans un tableau la liste des participants
	$i = 0;
	$destinataires = "";
	$nbDestinataire = count($destinataire);

	foreach($destinataire AS $des)
	{
		if($des == $_SESSION['pseudo'])
		{
			$destinataires .= "Vous";
		}
		else
		{
			$destinataires .= $des;
		}

		if($nbDestinataire - $i > 1)
		{
			$destinataires .= ", ";
		}
		$i++;
	}

	if($donnees->auteur == $_SESSION['pseudo'])
	{
		$destinataires .= " et Vous";
	}
	else
	{
		$destinataires .= " et " . $donnees->auteur;
	}

	if($_SESSION['pseudo'] == $donnees->auteur)
	{
		$inviter = '
			<form method="post">
				<label>Ajouter un destinaire :</label>	<input type="text" name="invitation" placeholder="Vous pouvez en mettre plusieurs en séparant avec des virgules comme Evosis,Timer." style="width: 67%;" /> <input type="submit" value="Ajouter" /><br />
			</form>';
	}

	echo '
	<h3>Envoyer un message</h3>
	<div class="contenu">
		Destinataires: ' . $destinataires . '<br />
		' . $inviter . '
		<form method="post">
			<center>Message : </center>
			<textarea name="message"></textarea>
			<div class="separate"></div>
			<center><input type="submit" /></center>
		</form>
	</div>
	';
}

include('pied.php');
?>