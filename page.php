<?php
include('base.php');
include('tete.php');

siMembre();

if(isset($_GET['compte']))
{
	$compteMembre = $_GET['compte'];

 	$r_count_nb_membres = $connexion->prepare('SELECT COUNT(*) FROM membres WHERE pseudo = "' . $compteMembre . '"');
 	$r_count_nb_membres->execute();
 	$count_nb_membres = $r_count_nb_membres->fetchColumn();

 	if($count_nb_membres > 0)
 	{
 		$r_donnees_membres = $connexion->prepare('SELECT * FROM membres WHERE pseudo = "' . $compteMembre . '"');
 		$r_donnees_membres->execute();
 		$donnees_membres = $r_donnees_membres->fetch(PDO::FETCH_OBJ);

 		$countNbPersos = $connexion->query('SELECT COUNT(*) FROM personnages WHERE idPseudo = ' . $donnees_membres->id . '')->fetchColumn();

 		if($countNbPersos > 0)
 		{
	 		$r_donnees_perso = $connexion->prepare('SELECT * FROM personnages WHERE idPseudo = ' . $donnees_membres->id . '');
	 		$r_donnees_perso->execute();
	 		$donnees_perso = $r_donnees_perso->fetch(PDO::FETCH_OBJ);
	 	}



 		// gars ou fille
 		switch($donnees_membres->sexe)
 		{
 			case 1:
 			$background = '#d6d5ff';
 			$border = '#8979ff';
 			break;

 			case 2:
 			$background = '#f1d5ff';
 			$border = '#e079ff';
 			break;

 		}

 		$timestamp = $donnees_membres->timestamp;
		$mois_fr = array('', 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
		list($jour, $mois, $annee) = explode('/', date('d/n/Y', $timestamp));
		$inscrit_le = $jour . ' ' . $mois_fr[$mois] . ' ' . $annee;

		$lastCo = date('d/m/Y\ à H\hi', $donnees_membres->lastConnexion);

		if($donnees_membres->prestige == 0)
		{
			$niveauAvancement = $donnees_membres->niveau / 4; // 25
			$niveauPasses = $donnees_membres->niveau;
		}
		else
		{
			$niveauAvancement = 25;
			$niveauPasses = 100;
		}

		if($donnees_membres->prestige < 10)
		{
			$prestigeAvancement = $donnees_membres->prestige * 3; // 55
			$prestigePasses = $donnees_membres->prestige;
		}
		else
		{
			$prestigeAvancement = 30;
			$prestigePasses = 10;
		}

		$scoreFinal = (int) $niveauAvancement + (int) $prestigeAvancement;

		if($donnees_membres->description == "")
		{
			$dp = "Aucune description.";
		}
		else
		{
			$dp = nl2br(bbCode(stripslashes(htmlspecialchars($donnees_membres->description))));
		}

		switch($donnees_perso->choixArme)
		{
			case 1:
			$specialisation = '<b>Épéiste</b>';
			$bonus = '<span style="color: #4f0082;">En tant qu\'épéiste, vous gagnez 50% de vitalité et 125% de puissance supplémentaire pour chaque point dépensé dans la catégorie concernée !</span>';
			break;

			case 2:
			$specialisation = '<b>Voleur</b>';
			$bonus = '<span style="color: #4f0082;">En tant que voleur, vous gagnez 20% de vitalité et 150% d\'agilité supplémentaire pour chaque point dépensé dans la catégorie concernée !</span>';
			break;

			case 3:
			$specialisation = '<b>Sauvage</b>';
			$bonus = '<span style="color: #4f0082;">En tant que sauvage, vous gagnez 200% de force supplémentaire pour chaque point dépensé dans la catégorie concernée !</span>';
			break;

			case 4:
			$specialisation = '<b>Barbare</b>';
			$bonus = '<span style="color: #4f0082;">En tant que barbare, vous gagnez 75% de vitalité et 100% de puissance supplémentaire pour chaque point dépensé dans la catégorie concernée !</span>';
			break;

			case 5:
			$specialisation = '<b>Élitiste</b>';
			$bonus = '<span style="color: #4f0082;">En tant qu\'élitiste, vous gagnez 100% de vitalité et 75% de puissance supplémentaire pour chaque point dépensé dans la catégorie concernée !</span>';
			break;

			case 6:
			$specialisation = '<b>Sniper</b>';
			$bonus = '<span style="color: #4f0082;">En tant que sniper, vous gagnez 50% de vitalité et 125% de chance supplémentaire pour chaque point dépensé dans la catégorie concernée !</span>';
			break;

			case 7:
			$specialisation = '<b>Magicien</b>';
			$bonus = '<span style="color: #4f0082;">En tant que magicien, vous gagnez 5% de vitalité, 100% de puissance et 30% d\'intelligence supplémentaire pour chaque point dépensé dans la catégorie concernée !</span>';
			break;

			case 8:
			$specialisation = '<b>Ange Gardien</b>';
			$bonus = '<span style="color: #4f0082;">En tant qu\'ange gardien, vous gagnez 50% de vitalité et 125% d\'intelligence supplémentaire pour chaque point dépensé dans la catégorie concernée !</span>';
			break;

			default:
			$specialisation = 'Sans spécialisation';
		}


 		echo '
 		<div class="pageInfoPseudo" style="background: ' . $background . ';">
 			
 			<span style="float: left;">
 			<img src="' . $donnees_membres->avatar . '" height="150" width="150" style="margin-right: 20px; border: 4px solid ' . $border . '; border-radius: 4px;" />
 			</span>

 			<!--<span style="float: right;">
 				<img src="images/ranks/' . $donnees_membres->niveau . '.png" width="150" height="150"/>
 			</span>-->


 			<div class="pseudo">
 			' . htmlspecialchars($donnees_membres->pseudo) . '';
				if($countNbPersos > 0)
			 	{
			 		echo '
					, ' . htmlspecialchars($donnees_perso->nomPerso) . '
			 		';
			 	}
			 echo '
 			</div>
 		</div>

 		<h3>Présentation</h3>
 		<div class="contenu" style="margin-bottom: 60px;">
 		' . $dp . '
 		</div>
 		
 		<h3>Progression</h3>
 		<div class="contenu" style="margin-bottom: 60px;">
 		<label><b>Progression totale :</b></label><progress value="' . $scoreFinal . '" max="100"></progress>	' . $scoreFinal . ' %<br /><br /><span style="float: right; margin-top: -45px;"><img src="images/ranks/' . $donnees_membres->niveau . '.png" width="150" height="150" /></span>
 		<label><b>Niveaux passés :</b></label>	' . $niveauPasses . ' / 100<br />
 		<label><b>Prestiges passés :</b></label> ' . $prestigePasses . ' / 10<br />
 		<label><b>Quête principale :</b></label> 0 / 0<br />
 		<label><b>Quête secondaire :</b></label> 0 / 0<br />
 		<label><b>Objets possédés :</b></label> 0 / 0

 		</div>



';

if($_SESSION['id'] != $donnees_membres->id)
{
	echo '

	 	<h3>Actions</h3>
	 	<div class="contenu">
	 	<input type="button" value="Ajouter en tant qu\'ami"> <input type="button" value="Proposer un échange"> <input type="button" value="Donner / Offrir">  
	 	</div>
 		';
}
 		
 	}
 	else
 	avert('Eh bah non. Personne porte ce nom.');

}

include('pied.php');
?>