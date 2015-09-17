<?php
include('base.php');
include('tete.php');

if(!isset($_SESSION['pseudo']))
{
	avert('Veuillez d\'abord vous connecter');
	include('pied.php');
	exit;
}


$r_donnees_message = $connexion->prepare('SELECT * FROM messages ORDER BY id DESC LIMIT 0,30');
$r_donnees_message->execute();

?>

<?php

while($donnees_message = $r_donnees_message->fetch(PDO::FETCH_OBJ))
{

	$r_donnees_membre = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $donnees_message->idAuteur . '');
	$r_donnees_membre->execute();
	$donnees_membre = $r_donnees_membre->fetch(PDO::FETCH_OBJ);

	if($donnees_membre->niveau <= 25)
	{
		$icon_rank = '♣';
	}
	elseif($donnees_membre->niveau <= 50 AND $donnees_membre->niveau > 25)
	{
		$icon_rank = '♦';
	}
	elseif($donnees_membre->niveau <= 75 AND $donnees_membre->niveau > 50)
	{
		$icon_rank = '♥';
	}
	elseif($donnees_membre->niveau <= 100 AND $donnees_membre->niveau > 75)
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
					<img src="http://www.evenforum.com/' . $donnees_membre->avatar . '" />
				</div>
				' . $donnees_membre->pseudo . '

				<div class="date_envoi">
					Envoyé le ' . $poste_le . '
				</div>
			</div>
			<b><font size="5" face="Arial">' . $icon_rank . '</font> <font size="4">' . $donnees_membre->niveau . '</font></b><br />
			EXP : <b>' . number_format($donnees_membre->experience) . '</b>
			<br />
			<div class="separate"></div>
			' . nl2br(bbCode(stripslashes(htmlspecialchars($donnees_message->message)))) . '
	</div>

	';
}

include('pied.php');

?>