<?php
switch($donnees_item_choisi->id) // MENU ITEM ENGINE
{
	case 26:
	$actions = '<a href="inventaire.php?infoItem=' . $idItemChoisi . '&useItem=26"><input type="button" value="Ouvrir"></a>';
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
			if($_SESSION['acces'] >= 20) // PREMIUM ITEM!
			{
				giveEC(20000, $_SESSION['pseudo'], $connexion);

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
			avert('Vous devez posséder un compte premium pour utiliser cet objet.');
		}
		else
		avert('ERR_NOT_THE_OWNER');

		break;
	}
	
}

?>