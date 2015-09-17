<?php
include('base.php');
include('tete.php');

siMembre();

if(!isset($_GET['page']) OR intval($_GET['page']) == 0)
{
	$page = 1;
}
else
{
	$page = $_GET['page'];
}

echo '
<h3>Mes messages privés</h3>
<div class="contenu">
	<a href="#" onclick="mpMenu(\'lire\', ' . $page . '); return false;" title="Lire mes messages"><img src="images/mp/1.png" class="luminosite" /></a> &nbsp;&nbsp;&nbsp; 
	<a href="#" onclick="mpMenu(\'ecrire\', ' . $page . '); return false;" title="Écrire un message"><img src="images/mp/2.png" class="luminosite" /></a> &nbsp;&nbsp;&nbsp; 
	<span style="float: right;">
	<a href="#" onclick="document.getElementById(\'envoyerForm\').submit(); return false;" title="Envoyer le message" id="envoyerLien" style="display: none;"><img src="images/mp/3.png" class="luminosite" /></a> 
	<a href="#" onclick="document.getElementById(\'supprimerForm\').submit(); return false;" title="Supprimer les messages sélectionnés"><img src="images/mp/4.png" class="luminosite" id="supprimerSelect" style="display: none;" /></a>
	</span>
</div>
';

if(isset($_POST['supprimer']))
{
	$listeId = implode(",", $_POST["supprimer"]);
	$reponse = $connexion->query('SELECT * FROM mpFil WHERE id IN (' . $listeId . ')');

	while($donnees = $reponse->fetch(PDO::FETCH_OBJ))
	{
		$destinataire = explode(",", $donnees->participant);

		if(in_array($_SESSION['pseudo'], $destinataire) OR $_SESSION['pseudo'] == $donnees->auteur)
		{
			$count = $connexion->prepare('SELECT COUNT(*) FROM mpFilSupp WHERE idFil=' . $donnees->id . ' AND idPseudo=' . $_SESSION['id']);
			$count->execute();
			$valeur = $count->fetchColumn();

			if($valeur == 0)
			{
				$envoi = $connexion->prepare("INSERT INTO mpFilSupp VALUES('', :idFil, :idPseudo)");
				$envoi->execute(array(
				'idFil' => $donnees->id,
				'idPseudo' => $_SESSION['id']
				));
			}
		}
	}

	info('Les messages sélectionnés ont bien été supprimés !');
}

$pagination = paginationMpFil($connexion, $configuration);

echo '
<span  id="lire" style="display: none;">
	<h3></h3>
	<div class="contenu">
		<span style="float: right;">' . $pagination['suivant'] . '</span>
		<span style="float: left;">' . $pagination['precedent'] . '</span>
		<center>' . $pagination['selectPage'] . '</center>
	</div>
	<table>
		<form method="post" id="supprimerForm">
			<tr>
				<th width="3%"><input type="checkbox" onclick="mpSupprimerAll(this);" /></th>
				<th width="3%"></th>
				<th width="50%">Objet</th>
				<th width="7%">Messages</th>
				<th width="15%">Avec</th>
				<th width="16%">Date</th>
			</tr>
			';

			
			$i = 0;
			$nbMessage = 0;
			$reponse = $connexion->query('SELECT * FROM mpFil ORDER BY timestamp DESC');

			while($donnees = $reponse->fetch(PDO::FETCH_OBJ)) // On liste les tout les mps de la BDD
			{
				$destinataire = explode(",", $donnees->participant); // On met dans un tableau la liste des participants

				if(count($destinataire) == 1) // Si il n'y a qu'un seul participant
				{
					$pseudo = ($donnees->auteur == $_SESSION['pseudo']) ? $donnees->participant : $donnees->auteur; // Et que le participant c'est nous, alors on met l'auteur et vice versa
				}
				else
				{
					$pseudo = 'Groupe (' . count($destinataire) . ')'; // Sinon on affiche combien de personne font parti de la discussion (à part nous)
				}

				if(in_array($_SESSION['pseudo'], $destinataire) OR $_SESSION['pseudo'] == $donnees->auteur) // On vérifie si notre pseudo se trouve dans la liste des participants ou qu'on en est l'auteur
				{	
					$count = $connexion->prepare('SELECT COUNT(*) FROM mpFilSupp WHERE idFil=' . $donnees->id . ' AND idPseudo=' . $_SESSION['id']);
					$count->execute();
					$valeur = $count->fetchColumn();

					if($valeur == 0) // On vérifie que le message n'a pas été "supprimé"
					{
						if($i >= $pagination['min'] AND $i <= $pagination['max']) // Et qu'on liste les messages de la bonne page
						{
							$nbMessage = $connexion->query('SELECT COUNT(*) FROM mpMessage WHERE idFil=' . $donnees->id . ' AND type=0')->fetchColumn();

							if($donnees->etat == "1.0")
							{
								$image = "1.0";
							}
							elseif($nbMessage >= 1 AND $nbMessage < 21)
							{
								$image = "1.1";
								$connexion->exec('UPDATE mpFil SET etat="1.1" WHERE id=' . $donnees->id);
							}
							elseif($nbMessage >= 21 AND $nbMessage < 51)
							{
								$image = "1.2";
								$connexion->exec('UPDATE mpFil SET etat="1.2" WHERE id=' . $donnees->id);
							}
							elseif($nbMessage >= 51 AND $nbMessage < 101)
							{
								$image = "1.3";
								$connexion->exec('UPDATE mpFil SET etat="1.3" WHERE id=' . $donnees->id);
							}
							elseif($nbMessage >= 101)
							{
								$image = "1.4";
								$connexion->exec('UPDATE mpFil SET etat="1.4" WHERE id=' . $donnees->id);
							}

							echo '
							<tr>
								<td id="' . $donnees->id . '" name="supprimerTd" style="text-align: center;" class="pasSelect"><input type="checkbox" id="checkbox_' . $donnees->id . '" name="supprimer[]" value="' . $donnees->id . '" onchange="mpSupprimer(\'' . $donnees->id . '\');" /></td>
								<td id="' . $donnees->id . 'a" name="supprimerTd" style="text-align: center;"><img src="images/forum/' . $image . '.png"  style="vertical-align: middle;"/></td>
								<td id="' . $donnees->id . 'b" name="supprimerTd" style="text-align: left;"><a href="message.php?id=' . $donnees->id . '">' . stripslashes(htmlspecialchars($donnees->objet)) . '</a></td>
								<td id="' . $donnees->id . 'c" name="supprimerTd" style="text-align: center;">' . $nbMessage . '</td>
								<td id="' . $donnees->id . 'd" name="supprimerTd" style="text-align: center;">' . $pseudo . '</td>
								<td id="' . $donnees->id . 'e" name="supprimerTd" style="text-align: center;">' . date('d/m/Y\ H\hi', $donnees->timestamp) . '</td>
							</tr>
							';
							$nbMessage++;
							$i++;
							
						}
						else
						{
							$i++;
						}
					}	
				}	
			} // Puis on recommence pour chaque MP jusqu'à temps qu'on ait fini.

			if($nbMessage == 0) // Ah et si on a aucun message, on l'affiche.
			{
				echo '
				<tr>
					<td colspan="6" style="text-align: center;">Aucun message</td>
				</tr>
				';
			}
echo '
		</form>
	</table>
	<br />
	<br />
	<h3></h3>
	<div class="contenu">
		<span style="float: right;">' . $pagination['suivant'] . '</span>
		<span style="float: left;">' . $pagination['precedent'] . '</span>
		<center>' . $pagination['selectPage'] . '</center>
	</div>
</span>
';

if(isset($_POST['destinataires']) AND isset($_POST['objet']) AND isset($_POST['message']))
{
	if(!empty($_POST['destinataires']))
	{
		$ok = true;
		$destinataire = explode(",", $_POST['destinataires']);

		foreach ($destinataire as $des) 
		{	
			$count = $connexion->prepare('SELECT COUNT(*) FROM membres WHERE pseudo="' . $des . '"');
			$count->execute();
			$valeur = $count->fetchColumn();
			
			if($valeur == 0)
			{
				avert('Le pseudo ' . $des . ' n\'existe pas !');
				$ok = false;
				break;
			}

			if($des == $_SESSION['pseudo'])
			{
				avert('Vous ne pouvez pas vous ajouter !');
				$ok = false;
				break;
			}
		}

		if($ok == true)
		{
			if(!empty($_POST['objet']))
			{
				if(!empty($_POST['message']))
				{
					$envoi = $connexion->prepare("INSERT INTO mpFil VALUES('', :objet, :auteur, :participant, :etat, :timestamp)");
					$envoi->execute(array(
					'objet' => addslashes($_POST['objet']),
					'auteur' => $_SESSION['pseudo'],
					'participant' => $_POST['destinataires'],
					'etat' => '1.1',
					'timestamp' => time()
					));

					$idFil = $connexion->lastInsertId('mpFil');

					$envoi2 = $connexion->prepare("INSERT INTO mpMessage VALUES('', :idFil, :idPseudo, :pseudo, :message, :type, :timestamp)");
					$envoi2->execute(array(
					'idFil' => $idFil,
					'idPseudo' => $_SESSION['id'],
					'pseudo' => $_SESSION['pseudo'],
					'message' => addslashes($_POST['message']),
					'type' => '0',
					'timestamp' => time()
					));

					foreach ($destinataire as $des) 
					{	
						$envoi3 = $connexion->prepare("INSERT INTO mpNotif VALUES('', :idFil, :pseudo, :toPseudo, :timestamp)");
						$envoi3->execute(array(
						'idFil' => $idFil,
						'pseudo' => $_SESSION['pseudo'],
						'toPseudo' => $des,
						'timestamp' => time()
						));
					}
					
					info('Votre message a bien été envoyé !');
				}
				else
				{
					avert('Le message ne peut pas être vide! ');
				}
			}
			else
			{
				avert('L\'objet ne peut pas être vide !');
			}
		}
	}
	else
	{
		avert('Il doit y avoir au moins un destinataire !');
	}
}

echo '
<span id="ecrire" style="display: none;">
	<h3>Écrire un message</h3>
	<div class="contenu">
		<form method="post" id="envoyerForm">
			<label>Destinaires :</label>	<input type="text" name="destinataires" placeholder="Vous pouvez en mettre plusieurs en séparant avec des virgules comme Evosis,Timer." style="width: 74%;" /><br />
			<label>Objet :</label>			<input type="text" name="objet" placeholder="50 caractères maximum." style="width: 74%;" /><br />
			<center>Message :</center>
			<textarea name="message"></textarea>
		</form>
	</div>
</span>
';

if($_GET['action'])
{
	$action = $_GET['action'];
	echo '<script>mpMenu(\'' . $action . '\', ' . $page . ')</script>';
}

include('pied.php');
?>