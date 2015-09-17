<?php
include('base.php');
include('tete.php');

siMembre();

$reponse = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $_SESSION['id'] . '');
$reponse->execute();
$donnees = $reponse->fetch(PDO::FETCH_OBJ);

if($donnees->niveau != 100)
{
	avert('Vous devez atteindre le niveau Lys 100 pour avoir accès au mode Reborn.');
	include('pied.php');
	exit;
}

if(isset($_GET['ok']))
{
	if($donnees->niveau == 100)
	{
		if($donnees->ec >= $prestige_cost)
		{
			if($donnees->prestige != 20)
			{

				$connexion->query('UPDATE membres SET niveau = 1 WHERE id = ' . $_SESSION['id']);
				$connexion->query('UPDATE membres SET experience = 0 WHERE id = ' . $_SESSION['id']);
				$connexion->query('UPDATE membres SET pc = 0 WHERE id = ' . $_SESSION['id']);
				$connexion->query('UPDATE membres SET prestige = (prestige + 1) WHERE id = ' . $_SESSION['id']);
				$connexion->query('UPDATE membres SET ec = (ec - ' . $prestige_cost . ') WHERE id = ' . $_SESSION['id']);
				$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige + 10) WHERE id = ' . $_SESSION['id']);
				$connexion->query('UPDATE personnages SET vitalite = (100 + (vitalite / 5)), c_force = (c_force / 5), agilite = (agilite / 5), intelligence = (intelligence / 5), chance = (chance / 5), puissance = (puissance / 5) WHERE idPseudo = ' . $_SESSION['id'] . '');
				$connexion->query('UPDATE personnages SET ptsCaracteristiques = 0 WHERE idPseudo = ' . $_SESSION['id']);
				$connexion->query('DELETE FROM competences WHERE idPseudo = ' . $_SESSION['id']);
				info('player.resetStats::done');
			}
			else
			avert('Vous avez déjà atteint le dernier niveau du mode Reborn.');

		}
		else
		avert('Le mode Reborn coûte ' . number_format($prestige_cost) . ' EC. Vous n\'en avez pas assez.');
	}
}


echo '
<h3>Mode Reborn</h3>
<div class="contenu">

Vous êtes sur le point de passer en mode Reborn.<br />
<p>
Ce mode permet de recommencer votre progression dans les niveaux à zéro. Toute les caractéristiques seront divisés par 5, excepté la vitalité qui a une base d\'ajout de 100, puis la vitalité actuelle divisée par 5 également. Seuls les objets de votre inventaire sera conservé.<br /><br />
<b>ATTENTION</b> Si vous possédez plus d\'objets que prévu après avoir réinitialisé, le drop sera désactivé ainsi que les achats du marché jusqu\'à avoir récupéré la force nécéssaire.
</p>

<p>
Le mode Reborn coûte <b>' . number_format($prestige_cost) . ' EC</b>. Cette somme sera prélevée par la suite.</p>

<p>
Impossible de revenir en arrière. Soyez sûr de vouloir passer en mode Reborn.</p>

<center><a href="prestige.php?ok">Accepter</a> - <a href="index.php">Refuser</a></center>
</div>
';


include('pied.php');
?>