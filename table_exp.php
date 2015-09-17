<?php
include('base.php');
include('tete.php');

siMembre();

$total = 0; // xp du niveau 1 = 0
$level;


	$tnl = 200; // base d'ajout
	$factor = 0.880102687; // multiplicateur
	$levels = 100; // total niveaux

echo '<table>
<tr>
			<th width="20%">Niveau</th>
			<th width="40%">EXP requis</th>
			<th width="40%">EXP restant</th>
		</tr>';

	for ($level = 1; $level <= 100; $level++)
	{

		$niveau[$level]['exp'] = (int) $total;
		$niveau[$level]['next'] = (int) $tnl;
		$total += $tnl;
		$tnl = $tnl * (1 + pow($factor, $level));

		$neededEXP = $niveau[$level]['exp'] - $donnees_membres->experience;

		if($neededEXP < 0)
		{
			$neededEXP = 0;
		}

		echo '
		<tr>
			<td>' . $level . '</td>
			<td>' . number_format($niveau[$level]['exp']) . '
			<td>' . number_format($neededEXP) . '
		</tr>
		';
	}

echo '</table>';

include('pied.php');
?>