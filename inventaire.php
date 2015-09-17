<?php
include('base.php');
include('tete.php');

siMembre();

$r_donnees_membres = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $_SESSION['id']);
$r_donnees_membres->execute();
$donnees_membres = $r_donnees_membres->fetch(PDO::FETCH_OBJ);

$r_donnees_inventaire = $connexion->prepare('SELECT * FROM inventaire WHERE idPseudo = ' . $_SESSION['id'] . ' ORDER BY id DESC');
$r_donnees_inventaire->execute();

$nb_items = $connexion->query('SELECT COUNT(*) FROM inventaire WHERE idPseudo = ' . $_SESSION['id'])->fetchColumn();

$objets_restant = $items_bag - $nb_items;

if($objets_restant > 0)
{
	$objets_restant = 0;
	$statut = '<b><font color="green">Drop activé</font></b>';
}
else
{
	$statut = '<b><font color="red">Drop désactivé</font></b>';
}

echo '

<h3>Inventaire</h3>
<div class="contenu">
<label>Objets différents en tout :</label>		<b>' . $nb_items . '</b><br />
<label>Objets différents max. :</label>	<b>' . $items_bag . '</b><br /><br />
' . $statut . '
</div>

<div class="inventaireListe">
<table style="width: 385px; display: inline-block;">
	<tr>
		<th width="10%">#</th>
		<th width="70%">Objet</th>
		<th width="20%">Qté</th>
	</tr>
';

while($donnees_inventaire = $r_donnees_inventaire->fetch(PDO::FETCH_OBJ))
{

	$r_donnees_items = $connexion->prepare('SELECT * FROM items WHERE id = ' . $donnees_inventaire->idItem . '');
	$r_donnees_items->execute();
	$donnees_items = $r_donnees_items->fetch(PDO::FETCH_OBJ);

	switch($donnees_items->type)
	{
		case 1:
		$imgType = '<img src="images/inventaire/ressource.png" width="30" height="30" title="Ressource" />';
		break;

		case 2:
		$imgType = '<img src="images/inventaire/stuff.png" width="30" height="30" title="Équipement" />';
		break;

		case 3:
		$imgType = '<img src="images/inventaire/potion.png" width="30" height="30" title="Consommable" />';
		break;

		case 4:
		$imgType = '<img src="images/inventaire/inclassable.png" width="30" height="30" title="Inclassable" />';
		break;

		case 5:
		$imgType = '<img src="images/inventaire/premium.png" width="30" height="30" title="Objet premium" />';
		break;

		case 6:
		$imgType = '<img src="images/inventaire/quest.png" width="30" height="30" title="Objet de quête" />';
		break;

		case 20:
		$imgType = '<img src="images/inventaire/armes/sword.png" width="30" height="30" title="Épée" />';
		break;

		case 21:
		$imgType = '<img src="images/inventaire/armes/dague.png" width="30" height="30" title="Dague" />';
		break;

		case 22:
		$imgType = '<img src="images/inventaire/armes/axe.png" width="30" height="30" title="Hache" />';
		break;

		case 23:
		$imgType = '<img src="images/inventaire/armes/greataxe.png" width="30" height="30" title="Hache d\'arme" />';
		break;

		case 24:
		$imgType = '<img src="images/inventaire/armes/greatsword.png" width="30" height="30" title="Espadon" />';
		break;

		case 25:
		$imgType = '<img src="images/inventaire/armes/bow.png" width="30" height="30" title="Arc" />';
		break;

		case 26:
		$imgType = '<img src="images/inventaire/armes/staff.png" width="30" height="30" title="Bâton magique" />';
		break;

		case 27:
		$imgType = '<img src="images/inventaire/armes/baguette.png" width="30" height="30" title="Baguette" />';
		break;

	}



	echo '
	<tr>
		<td>' . $imgType . '</td>
		<td style="text-align: left;"><a href="inventaire.php?infoItem=' . $donnees_inventaire->id . '">' . $donnees_items->nom_item . '</a></td>
		<td>' . $donnees_inventaire->quantite . '</td>
	</tr>
	';
}

echo '
</table>

<div class="inventaireStats">

';

if(!isset($_GET['infoItem']))
{
	echo '<h1>Sélectionnez un objet pour voir ses stats.</h1></div></div>';
	include('pied.php');
	exit;
}

if(isset($_GET['infoItem']))
{
	$idItemChoisi = (int) $_GET['infoItem'];

	$r_countIfExist = $connexion->prepare('SELECT COUNT(*) FROM inventaire WHERE id = ' . $idItemChoisi . '');
	$r_countIfExist->execute();
	$countIfExist = $r_countIfExist->fetchColumn();

	if($countIfExist > 0)
	{
		$r_donnees_inv_choisi = $connexion->prepare('SELECT * FROM inventaire WHERE id = ' . $idItemChoisi . '');
		$r_donnees_inv_choisi->execute();
		$donnees_inv_choisi = $r_donnees_inv_choisi->fetch(PDO::FETCH_OBJ);

		if($donnees_inv_choisi->idPseudo == $_SESSION['id'])
		{
			$r_donnees_item_choisi = $connexion->prepare('SELECT * FROM items WHERE id = ' . $donnees_inv_choisi->idItem);
			$r_donnees_item_choisi->execute();
			$donnees_item_choisi = $r_donnees_item_choisi->fetch(PDO::FETCH_OBJ);

			switch($donnees_item_choisi->revente)
			{
				case 0:
				$vendable = '<b><font color="red">Impossible a vendre / échanger.</font></b>';
				break;

				case 1:
				$vendable = '<font color="green">Vendable / Échangeable</font>';
				break;
			}


			include('engine/effect_item.php');

			echo '
			<span style="font-weight: bold; font-size: 12pt; float: left; line-height: 2;">'. $donnees_item_choisi->nom_item . ' (<span style="font-weight: normal;">x ' . $donnees_inv_choisi->quantite . '</span>)</span><span style="float:right; font-size: 12pt; line-height: 2;">Niveau ' . $donnees_item_choisi->niveauRequis . '</span>
			<br /><br />
			<div class="separate"></div>
			<span style="float: left; font-weight: bold; font-size: 11pt; line-height: 0.8;">' . $vendable . '</span><span style="float: right; font-weight: bold; font-size: 13pt; line-height: 0.8;">' . number_format($donnees_item_choisi->prixBase) . ' EC</span>

			<!--
			A appartenu en premier à : <b>' . $donnees_inv_choisi->first_owner_perso . '</b> (' . $donnees_inv_choisi->first_owner_pseudo . ')<br />
			--><br />
			<div class="separate"></div>
			<b>Description :</b><br /><br />
			'. bbCode(nl2br(htmlspecialchars($donnees_item_choisi->description))) . '
			<div class="separate"></div>
			<br />
			' . $actions . '


			';
		}
		else
		{
			avert('Cet objet n\'est pas à vous');
		}

	}
	else
	{
		avert('Cet objet existe pas.');
	}



}

echo '</div></div>
';

include('pied.php');

?>
