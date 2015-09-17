<?php
include('base.php');
include('tete.php');

siMembre();

$r_donnees_connectes = $connexion->prepare('SELECT
				connectes.idPseudo AS `idDuPseudo`,
				connectes.timestamp AS `activite`,
				connectes.path AS `path`,
				connectes.ip AS `ip`,
				membres.id AS `idMembre`,
				membres.pseudo AS `pseudo`,
				membres.niveau AS `level`
				FROM connectes
				INNER JOIN membres
				ON membres.id = connectes.idPseudo');
$r_donnees_connectes->execute();

echo '

<table>

	<tr>
		<th width="20%">Niveau</th>
		<th width="20%">Pseudo / IP</th>
		<th width="30%">Location</th>
		<th width="30%">Vu il y a</th>
	</tr>

';

while($donnees_connectes = $r_donnees_connectes->fetch(PDO::FETCH_OBJ))
{
	if($donnees_connectes->idDuPseudo == 0)
	{
		$pseudo = htmlspecialchars($donnees_connectes->ip);
		$niveau = "Aucun niveau";
	}
	else
	{
		$pseudo = htmlspecialchars($donnees_connectes->pseudo);
		$niveau = '<font face="Arial" size="5">' . $icon_rank . '</font> <font size="5">' . $donnees_connectes->level . '</font>';
	}

	$temps = time() - $donnees_connectes->activite;

	if($temps < 60)
	{
		$derniere_activite = $temps . ' seconde(s)';
	}
	elseif($temps >= 60 AND $temps < 120)
	{
		$derniere_activite = '1 minute';
	}
	elseif($temps >= 120 AND $temps < 180)
	{
		$derniere_activite = '2 minutes';
	}
	elseif($temps >= 180 AND $temps < 240)
	{
		$derniere_activite = '3 minutes';
	}
	elseif($temps >= 240 AND $temps < 300)
	{
		$derniere_activite = '4 minutes';
	}
	elseif($temps > 300)
	{
		$derniere_activite = '5 minutes';
	}

	if($donnees_connectes->level <= 25)
	{
		$icon_rank = '♣';
	}
	elseif($donnees_connectes->level <= 50 AND $donnees_connectes->level > 25)
	{
		$icon_rank = '♦';
	}
	elseif($donnees_connectes->level <= 75 AND $donnees_connectes->level > 50)
	{
		$icon_rank = '♥';
	}
	elseif($donnees_connectes->level <= 99 AND $donnees_connectes->level > 75)
	{
		$icon_rank = '♠';
	}
	elseif($donnees_connectes->level == 100)
	{
		$icon_rank = '&#9884;';
	}

	echo '
	<tr>
		<td>' . $niveau . '</td>
		<td>' . $pseudo . '</td>
		<td>' . $donnees_connectes->path . '</td>
		<td>' . $derniere_activite . '</td>
	</tr>
	';

}

echo '
</table>
';

include('pied.php');

?>
