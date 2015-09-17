<?php
switch($donnees_item_choisi->id) // MENU ITEM ENGINE
{
	case 26:
	$actions = '<a href="inventaire.php?infoItem=' . $idItemChoisi . '&useItem=26"><input type="button" value="Ouvrir"></a>';
	break;

	case 51:
	$actions = '<a href="inventaire.php?infoItem=' . $idItemChoisi . '&useItem=51"><input type="button" value="Boire"></a>';
	break;
}

if(isset($_GET['useItem'])) // INTERACTION ENGINE
{
	$idItem = (int) $_GET['useItem'];

	switch($idItem)
	{
		case 26:

		if($countIfExist > 0) // si il a l'item
		{
				$connexion->query('UPDATE membres SET ec = (ec + 20000) WHERE pseudo = "' . $_SESSION['pseudo'] . '"');

				if($donnees_inv_choisi->quantite > 1)
				{
					$connexion->query('UPDATE inventaire SET quantite = (quantite - 1) WHERE idPseudo = ' . $_SESSION['id'] . ' AND idItem = ' . $idItem . '');
					redirection('inventaire.php?infoItem=' . $idItemChoisi . '');
				}
				elseif($donnees_inv_choisi->quantite == 1)
				{
					$connexion->query('DELETE FROM inventaire WHERE idItem = ' . $idItem . '');
					redirection('inventaire.php');
				}

		}
		else
		avert('ERR_NOT_THE_OWNER');

		break;


		case 51:

		if($countIfExist > 0) // si il a l'item
		{
				$connexion->query('UPDATE membres SET experience = (experience + 50000) WHERE pseudo = "' . $_SESSION['pseudo'] . '"');

				if($donnees_inv_choisi->quantite > 1)
				{
					$connexion->query('UPDATE inventaire SET quantite = (quantite - 1) WHERE idPseudo = ' . $_SESSION['id'] . ' AND idItem = ' . $idItem . '');
					redirection('inventaire.php?infoItem=' . $idItemChoisi . '');
				}
				elseif($donnees_inv_choisi->quantite == 1)
				{
					$connexion->query('DELETE FROM inventaire WHERE idItem = ' . $idItem . '');
					redirection('inventaire.php');
				}

		}
		else
		avert('ERR_NOT_THE_OWNER');

		break;
	}
	
}

?>