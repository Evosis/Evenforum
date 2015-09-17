<?php
include('base.php');
include('tete.php');

siMembre();

if($donnees_membres->niveau < 5 AND $donnees_membres->prestige == 0)
{
	avert('Vous devez être au minimum niveau 5 pour débloquer l\'accès aux quêtes.');
	include('pied.php');
	exit;
}

$count_quests_ended = $connexion->query('SELECT COUNT(*) FROM quests_membre WHERE reussite = 1 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

?>

<h3>Statistiques</h3>
<div class="contenu">
<b><label>Quêtes terminées :</label></b>	<?php echo (int) $count_quests_ended; ?>
</div>

<h3>Quêtes disponibles</h3>
<div class="contenu">

<table style="width: 100%">

	<tr>
		<th width="40%">Nom de la quête</th>
		<th width="20%">De</th>
		<th width="20%">Type</th>
		<th width="20%">Statut</th>
	</tr>

<?php


$r_donnees_quetes_membre = $connexion->prepare('SELECT * FROM quests_membre WHERE idPseudo = ' . $_SESSION['id'] . '');
$r_donnees_quetes_membre->execute();

while($donnees_quetes_membre = $r_donnees_quetes_membre->fetch(PDO::FETCH_OBJ))
{
	$r_donnees_quetes = $connexion->prepare('SELECT * FROM quests WHERE id = ' . $donnees_quetes_membre->idQuete);
	$r_donnees_quetes->execute();
	$donnees_quetes = $r_donnees_quetes->fetch(PDO::FETCH_OBJ);

	switch($donnees_quetes->type)
	{
		case 1:
		$type = "Quête principale";
		break;

		case 2:
		$type = "Quête secondaire";
		break;

		default:
		$type = "???";
	}

	switch($donnees_quetes_membre->reussite)
	{
		case 0:
		$statut = "En cours";
		break;

		case 1:
		$statut = "Terminée";
		break;
	}

	echo '
	<tr>
		<td style="text-align: left;"><a href="quetes.php?details=' . $donnees_quetes->id . '">' . htmlspecialchars($donnees_quetes->titreQuest) . '</a></td>
		<td>' . htmlspecialchars($donnees_quetes->nomPersoQuest) . '</td>
		<td>' . $type . '</td>
		<td>' . $statut . '</td>
	</tr>
	';


}

?>

</table>
</div>

<?php
include('pied.php');
?>