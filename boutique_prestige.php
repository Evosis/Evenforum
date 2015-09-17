<?php
include('base.php');
include('tete.php');

$r_donnees_membres = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $_SESSION['id']);
$r_donnees_membres->execute();
$donnees_membres = $r_donnees_membres->fetch(PDO::FETCH_OBJ);

if($donnees_membres->prestige == 0)
{
	avert('Accès interdit.');
	include('pied.php');
	exit;
}


if(isset($_GET['take']))
{
	$idTake = (int) $_GET['take'];

	if($idTake > 0 AND $idTake < 21)
	{
		switch($idTake)
		{
			case 1:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 2)
				{
					$connexion->query('UPDATE membres SET experience = (experience + 10000) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 2) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 2:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 7)
				{
					$connexion->query('UPDATE membres SET experience = (experience + 30000) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 7) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 3:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 22)
				{
					$connexion->query('UPDATE membres SET experience = (experience + 100000) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 22) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 4:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 4)
				{
					$connexion->query('UPDATE membres SET ec = (ec + 5000) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 4) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 5:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 60)
				{
					$connexion->query('UPDATE membres SET ec = (ec + 50000) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 60) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 6:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 200)
				{
					$connexion->query('UPDATE membres SET ec = (ec + 250000) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 200) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 7:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 20)
				{
					$connexion->query('UPDATE personnages SET vitalite = (vitalite + 100) WHERE idPseudo = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 20) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 8:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 20)
				{
					$connexion->query('UPDATE personnages SET c_force = (c_force + 100) WHERE idPseudo = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 20) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 9:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 20)
				{
					$connexion->query('UPDATE personnages SET intelligence = (intelligence + 100) WHERE idPseudo = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 20) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;
			

			case 10:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 20)
				{
					$connexion->query('UPDATE personnages SET dexterite = (dexterite + 100) WHERE idPseudo = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 20) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 11:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 20)
				{
					$connexion->query('UPDATE personnages SET chance = (chance + 100) WHERE idPseudo = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 20) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 12:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 20)
				{
					$connexion->query('UPDATE personnages SET agilite = (agilite + 100) WHERE idPseudo = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 20) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 13:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 100)
				{
					$connexion->query('UPDATE personnages SET vitalite = (vitalite + 300) WHERE idPseudo = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 100) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 14:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 100)
				{
					$connexion->query('UPDATE personnages SET c_force = (c_force + 300) WHERE idPseudo = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 100) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 15:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 100)
				{
					$connexion->query('UPDATE personnages SET intelligence = (intelligence + 300) WHERE idPseudo = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 100) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 16:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 100)
				{
					$connexion->query('UPDATE personnages SET dexterite = (dexterite + 300) WHERE idPseudo = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 100) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 17:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 100)
				{
					$connexion->query('UPDATE personnages SET chance = (chance + 300) WHERE idPseudo = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 100) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 18:

			if($donnees_membres->lastPrestige != $donnees_membres->prestige)
			{
				if($donnees_membres->ptsPrestige >= 100)
				{
					$connexion->query('UPDATE personnages SET agilite = (agilite + 300) WHERE idPseudo = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET ptsPrestige = (ptsPrestige - 100) WHERE id = ' . $_SESSION['id']);
					$connexion->query('UPDATE membres SET lastPrestige = ' . $donnees_membres->prestige . ' WHERE id = ' . $_SESSION['id']);
					info('Bonus choisi.');
				}
				else
				avert('Pas assez de points.');
			}
			else
			avert('Le prestige suivant est requis...');

			break;

			case 19:
			avert('Update #13 requise');
			break;

			case 20:
			avert('Update #13 requise');
			break;


			default:
			avert('Unknown id');

		}
	}
}

?>

<h3>Points</h3>
<div class="contenu">
<h1><?php echo number_format($donnees_membres->ptsPrestige); ?> points de prestige</h1>
Un seul bonus peut être sélectionné par prestige. Si un bonus a été sélectionné, impossible d'en reprendre un autre avant d'avoir passé le prestige suivant. <br />
Si aucun bonus n'est sélectionné, le nombre de bonus ne se cumule pas.<br />
Les points non-dépensés sont gardés.
</div>

<table>

	<tr>
		<th width="80%">Bonus</th>
		<th width="20%">Points requis</th>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=1">+ 10.000 EXP de départ</a></td>
		<td>2</td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=2">+ 30.000 EXP de départ</a></td>
		<td>7</td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=3">+ 100.000 EXP de départ</a></td>
		<td>22</td>
	</tr>

	<tr>
		<td> </td>
		<td> </td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=4">+ 5.000 EC de départ</a></td>
		<td>4</td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=5">+ 50.000 EC de départ</a></td>
		<td>60</td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=6">+ 250.000 EC de départ</a></td>
		<td>200</td>
	</tr>

	<tr>
		<td> </td>
		<td> </td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=7">+ 100 points de vitalité</a></td>
		<td>20</td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=8">+ 100 points de force</a></td>
		<td>20</td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=9">+ 100 points d'intelligence</a></td>
		<td>20</td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=10">+ 100 points de dextérité</a></td>
		<td>20</td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=11">+ 100 points de chance</a></td>
		<td>20</td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=12">+ 100 points d'agilité</a></td>
		<td>20</td>
	</tr>

	<tr>
		<td> </td>
		<td> </td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=13">+ 300 points de vitalité</a></td>
		<td>100</td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=14">+ 300 points de force</a></td>
		<td>100</td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=15">+ 300 points d'intelligence</a></td>
		<td>100</td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=16">+ 300 points de dextérité</a></td>
		<td>100</td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=17">+ 300 points de chance</a></td>
		<td>100</td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=18">+ 300 points d'agilité</a></td>
		<td>100</td>
	</tr>

	<tr>
		<td> </td>
		<td> </td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=19">Tuer votre personnage</a></td>
		<td>10</td>
	</tr>

	<tr>
		<td style="text-align: left;"><a href="boutique_prestige.php?take=20">Réinitialisation de vos données</a></td>
		<td>10</td>
	</tr>
</table>

<?php
include('pied.php');
?>