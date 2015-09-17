<?php
include('base.php');
include('tete.php');

siMembre();

$nb_notif = $connexion->query('SELECT COUNT(*) FROM notifications WHERE idPseudo = ' . $_SESSION['id'])->fetchColumn();
$nb_notif_non_lues = $connexion->query('SELECT COUNT(*) FROM notifications WHERE idPseudo = ' . $_SESSION['id'] . ' AND vue = 0')->fetchColumn();

$r_notif = $connexion->prepare('SELECT * FROM notifications WHERE idPseudo = ' . $_SESSION['id'] . ' ORDER BY id DESC LIMIT 0,25');
$r_notif->execute();

if($nb_notif_non_lues > 0)
{
	$connexion->query('UPDATE notifications SET vue = 1 WHERE idPseudo = ' . $_SESSION['id']);
}

$r_donnees_membres = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $_SESSION['id']);
$r_donnees_membres->execute();
$donnees_membres = $r_donnees_membres->fetch(PDO::FETCH_OBJ);

if($donnees_membres->acces >= 80)
{

	if(isset($_POST['pseudo']))
	{
		if($_POST['pseudo'] == "")
		{
			$ToAll = true;
		}
		else
		{
			$ToAll = false;
		}

			if($ToAll == false)
			{
				$r_count_membre = $connexion->prepare('SELECT COUNT(*) FROM membres WHERE pseudo = "' . $_POST['pseudo'] . '"');
				$r_count_membre->execute();
				$count_membre = $r_count_membre->fetchColumn();



				if($count_membre > 0)
				{
					$r_donnees_membre = $connexion->prepare('SELECT * FROM membres WHERE pseudo = "' . $_POST['pseudo'] . '"');
					$r_donnees_membre->execute();
					$donnees_membre = $r_donnees_membre->fetch(PDO::FETCH_OBJ);

					if($_POST['typeNotif'] > 0 AND $_POST['typeNotif'] < 9)
					{
						if($_POST['textNotif'] != "")
						{
							$envoi = $connexion->prepare("INSERT INTO notifications VALUES('', :idPseudo, :typeNotif, :texte, :hidden, :vue, :timestamp)");
							$envoi->execute(array(
							'idPseudo' => $donnees_membre->id,
							'typeNotif' => $_POST['typeNotif'],
							'texte' => $_POST['textNotif'],
							'hidden' => 0,
							'vue' => 0,
							'timestamp' => time()
							));

							info('Notification envoyée à ' . htmlspecialchars($_POST['pseudo']) . '');
						}
						else
						avert('Notif. incorrecte');
					}
					else
					avert('Type incorrect');
				}
				else
				avert('Membre inconnu');
			}
			else
			{
				$r_all_membres = $connexion->prepare('SELECT * FROM membres');
				$r_all_membres->execute();

				if($_POST['typeNotif'] > 0 AND $_POST['notif'] < 4)
				{
					if($_POST['textNotif'] != "")
					{
						while($all_membres = $r_all_membres->fetch(PDO::FETCH_OBJ))
						{
							$envoi = $connexion->prepare("INSERT INTO notifications VALUES('', :idPseudo, :typeNotif, :texte, :hidden, :vue, :timestamp)");
							$envoi->execute(array(
							'idPseudo' => $all_membres->id,
							'typeNotif' => $_POST['typeNotif'],
							'texte' => $_POST['textNotif'],
							'hidden' => 0,
							'vue' => 0,
							'timestamp' => time()
							));
						}

						info('Notification envoyée à tout le monde.');
					}
					else
					avert('Notif. incorrecte');
				}
				else
				avert('Type incorrect');
			}
	}


	echo '
	<h3>Admin : Envoyer une notification</h3>
	<div class="contenu">
	<form method="post">

		<label>Pseudo concerné :</label>	<input type="text" name="pseudo" placeholder="Laissez vide pour envoyer à tous les membres !" style="width: 300px;"><br />
		<label>Type de notification :</label>	

			<select name="typeNotif">
				<option value="1" selected>Notification générale</option>
				<option value="2">Notification de niveau</option>
				<option value="3">Notification de quête</option>
				<option value="7">Notification de drop</option>
				<option value="8">Notification de succès</option>
				<option value="4" disabled>Notification de vente au marché</option>
				<option value="5" disabled>Notification d\'échange</option>
				<option value="6" disabled>Notification spéciale</option>
			</select>
			<br /><br />

		<label>Texte :</label>	<br />
		<textarea name="textNotif" placeholder="BBCode activé ainsi que le retour à la ligne."></textarea>
		<div class="separate"></div>
		<input type="submit">
	</form>
	</div>


	';
}


echo '

<h3>Notifications</h3>
<div class="contenu">
<label>Nombre de notification reçues :</label><b>' . $nb_notif . '</b>	<br />
<label>Nombre de notif. non-lues :</label><b>' . $nb_notif_non_lues . '</b>	
</div>

';

if($nb_notif == 0)
{
	include('pied.php');
	exit;
}

echo '
<table>
	<tr>
		<th>Type</th>
		<th>Notification</th>
		<th>Reçu le</th>
	</tr>

';

while($notification = $r_notif->fetch(PDO::FETCH_OBJ))
{
	switch($notification->type)
	{
		case 1:
		// Notif générale...
		$imgType = '<img src="images/notifications/warn.png" width="25" height="25" title="Notification générale" />';
		break;

		case 2:
		// Montée de niveau ou autres...
		$imgType = '<img src="images/notifications/upgrade.png" width="25" height="25" title="Notification sur le niveau" />';
		break;

		case 3:
		// Quests
		$imgType = '<img src="images/notifications/quest.png" width="25" height="25" title="Notification de quête" />';
		break;

		case 7:
		// Drop
		$imgType = '<img src="images/notifications/bag.png" width="25" height="25" title="Notification de drop" />';
		break;

		case 8:
		// Achievements
		$imgType = '<img src="images/notifications/defis.png" width="25" height="25" title="Notification de succès obtenu" />';
		break;

		default:
		$imgType = '<img src="images/notifications/warn.png" width="25" height="25" title="Notification générale" />';
	}

	echo '

	<tr>
		<td width="10%">' . $imgType . '</td>
		<td width="70%" style="text-align: left;">' . nl2br(bbCode(htmlspecialchars($notification->texte))) . '</td>
		<td width="20%">' .  date('d/m/Y\ à H\hi', $notification->timestamp) . '</td>
	</tr>

	';


}

echo '
</table>
<br /><br />
';

include('pied.php');

?>