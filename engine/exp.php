<?php

if(isset($_SESSION['pseudo']))
{

	$total = 0; // xp du niveau 1 = 0
	$level;


	$tnl = 200; // base d'ajout
	$factor = 0.880102687; // multiplicateur
	$levels = 100; // total niveaux

	$r_donnees_membres = $connexion->query('SELECT * FROM membres WHERE id = ' . $_SESSION['id']);
	$donnees_membres = $r_donnees_membres->fetch(PDO::FETCH_ASSOC);

	for ($level = 1; $level <= 100; $level++)
	{

		$lvl_gagne = $donnees_membres['niveau'] + 1;

		$niveau[$level]['exp'] = (int) $total;
		$niveau[$level]['next'] = (int) $tnl;
		$total += $tnl;
		$tnl = $tnl * (1 + pow($factor, $level));
	}

	if($donnees_membres['niveau'] < 100)
	{
		if($donnees_membres['experience'] >= $niveau[$lvl_gagne]['exp'] AND $donnees_membres['lastLevel'] != $lvl_gagne)
		{
			$connexion->query('UPDATE membres SET niveau = ' . $lvl_gagne . ' WHERE id = ' . $_SESSION['id']);
			$connexion->query('UPDATE membres SET ec = (ec + 1000) WHERE id = ' . $_SESSION['id']);
			$connexion->query('UPDATE membres SET pb = (pb + 10) WHERE id = ' . $_SESSION['id']);
			$connexion->query('UPDATE membres SET pc = (pc + 1) WHERE id = ' . $_SESSION['id']);
			$connexion->query('UPDATE membres SET lastLevel = ' . $lvl_gagne . ' WHERE id = ' . $_SESSION['id']);
			$connexion->query("INSERT INTO notifications VALUES('', '" . $_SESSION['id'] . "', '2', 'Vous êtes désormais niveau " . $lvl_gagne . " !', '0', '0', '" . time() . "')");

			$count_perso = $connexion->query('SELECT COUNT(*) FROM personnages WHERE idPseudo = '.  $_SESSION['id'])->fetchColumn();

			if($count_perso > 0)
			{
				$ptsSup = 5 + $bonusPointCarac;
				$connexion->query('UPDATE personnages SET ptsCaracteristiques = (ptsCaracteristiques + ' . $ptsSup . ') WHERE idPseudo = '. $_SESSION['id']);
				$connexion->query('UPDATE personnages SET vitalite = (vitalite + ' . $vita_per_level . ') WHERE idPseudo = ' . $_SESSION['id']);
			}
			
		}
	}




	$r_donnees = $connexion->prepare('SELECT * FROM membres WHERE id = '. $_SESSION['id']);
	$r_donnees->execute();
	$donnees = $r_donnees->fetch(PDO::FETCH_OBJ);

	if($donnees->niveau <= 25)
	{
		$icon_rank = '♣';
	}
	elseif($donnees->niveau <= 50 AND $donnees->niveau > 25)
	{
		$icon_rank = '♦';
	}
	elseif($donnees->niveau <= 75 AND $donnees->niveau > 50)
	{
		$icon_rank = '♥';
	}
	elseif($donnees->niveau <= 100 AND $donnees->niveau > 75)
	{
		$icon_rank = '♠';
	}
}
?>