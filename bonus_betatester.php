<?php

if(isset($_SESSION['pseudo']))
{
	$timestamp_mini = 1435159488;

	$if_recu = $connexion->query('SELECT COUNT(*) FROM bonusRecu6 WHERE idPseudo = ' . $_SESSION['id'])->fetchColumn();

	if($if_recu == 0)
	{
		$r_donnees_membres = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $_SESSION['id'] . '');
		$r_donnees_membres->execute();
		$donnees_membres = $r_donnees_membres->fetch(PDO::FETCH_OBJ);

		$timestamp_membre = $donnees_membres->timestamp;
		if($timestamp_mini > $timestamp_membre)
		{
			notification($_SESSION['id'], 1, "EvenForum 6 va bientôt fermer ses portes pour accueillir EvenForum 7.\n\n [b]Pour vos remercier de votre inscription, 2 objets de 3 exemplaires ont été ajoutés à votre inventaire.[/b]", $connexion);
			$connexion->query("INSERT INTO inventaire VALUES('', '" . $_SESSION['id'] . "', '51', '3', 'Code Purple', 'CP6', '" . time() . "')");
			$connexion->query("INSERT INTO inventaire VALUES('', '" . $_SESSION['id'] . "', '26', '3', 'Code Purple', 'CP6', '" . time() . "')");
			$connexion->query("INSERT INTO bonusRecu6 VALUES('', '" . $_SESSION['id'] . "')");
		}
	}
}

?>