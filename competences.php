<?php
include('base.php');
include('tete.php');

siMembre();

$countPerso = $connexion->query('SELECT COUNT(*) FROM personnages WHERE idPseudo = ' . $_SESSION['id'] . ' AND killed = 0')->fetchColumn();

if($countPerso == 0)
{
	avert('Vous devez posséder un personnage non tué pour accéder aux compétences.');
	include('pied.php');
	exit;
}

$baseCost = 1000;
$addedNiveau = $donnees_membres->niveau * 1000;
$totalCost = $baseCost + $addedNiveau;

if(isset($_GET['action']))
{
	if($_GET['action'] == "reset")
	{
		$niveau = $donnees_membres->niveau;
		$ptsARendre = $niveau - 1;
		$ptsMax = $niveau - 1;


		if($donnees_membres->ec >= $totalCost)
		{


			if($donnees_membres->pc == $ptsMax)
			{
				avert('Vous n\'avez pas besoin de reset.');
			}
			else
			{
				$connexion->query('UPDATE membres SET pc = "' . $ptsARendre . '" WHERE id = ' . $_SESSION['id']);
				$connexion->query('UPDATE membres SET ec = (ec - ' . $totalCost . ') WHERE id = "' . $_SESSION['id'] . '"');
				$connexion->query('DELETE FROM competences WHERE idPseudo = "' . $_SESSION['id'] . '"');
				redirection('competences.php');
			}
		}
		else
		avert('Vous ne possédez pas au moins ' . $totalCost . ' EC.');
	}
	else
	avert('Action invalide.');
}

if(isset($_GET['take']))
{
	$idTake = (int) $_GET['take'];

	if($idTake > 0 AND $idTake <= 23)
	{
		switch($idTake)
		{
			case 1:

				$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 1 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[1][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 1');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[1][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '1', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[1][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[1][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;


			case 2:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 2 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[2][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 2');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[2][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '2', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[2][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[2][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;


			case 3:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 3 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[3][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 3');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[3][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '3', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[3][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[3][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;


			case 4:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 4 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[4][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 4');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[4][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '4', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[4][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[4][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;


			case 5:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 5 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[5][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 5');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[5][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '5', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[5][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[5][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;


			case 6:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 6 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[6][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 6');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[6][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '6', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[6][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[6][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;


			case 7:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 7 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[7][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 7');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[7][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '7', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[7][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[7][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;


			case 8:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 8 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[8][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 8');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[8][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '8', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[8][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[8][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;

			case 9:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 9 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[9][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 9');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[9][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '9', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[9][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[9][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;


			case 10:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 10 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[10][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 10');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[10][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '10', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[10][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[10][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;

			case 11:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 11 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[11][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 11');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[11][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '11', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[11][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[11][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;


			case 12:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 12 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[12][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 12');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[12][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '12', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[12][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[12][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;

			case 13:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 13 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[13][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 13');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[13][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '13', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[13][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[13][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;


			case 14:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 14 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[14][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 14');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[14][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '14', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[14][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[14][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;


			case 15:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 15 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[15][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 15');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[15][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '15', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[15][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[15][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;


			case 16:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 16 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[16][1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($count_perk_v == 0)
					{
						$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '16', '1', '" . time() . "')");
						$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[16][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
						redirection('competences.php');
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;


			case 17:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 17 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[17][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 17');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[17][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '17', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[17][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[17][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;


			case 18:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 18 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[18][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 18');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[18][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '18', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[18][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[18][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;


			case 19:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 19 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[19][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 19');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[19][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '19', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[19][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[19][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;

			case 20:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 20 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[20][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 20');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[20][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '20', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[20][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[20][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;

			case 21:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 21 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[21][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 21');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[21][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '21', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[21][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[21][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;

			case 22:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 22 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[22][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 22');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[22][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '22', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[22][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[22][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;

			case 23:

			$count_perk_v = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 23 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk_v == 0)
				{
					$prix_comp = $competence[23][1]['nbPoints'];
				}
				else
				{
					$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = 23');
					$r_donnees_comp->execute();
					$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

					$prix_comp = $competence[23][$donnees_comp->niveau + 1]['nbPoints'];
				}

				if($donnees_membres->pc >= $prix_comp)
				{
					if($donnees_comp->niveau <= 3)
					{
						if($count_perk_v == 0)
						{
							$connexion->query("INSERT INTO competences VALUES('', '" . $_SESSION['id'] . "', '23', '1', '" . time() . "')");
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[23][1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
						else
						{
							$connexion->query('UPDATE competences SET niveau = (niveau + 1) WHERE idComp = ' . $idTake . '');
							$connexion->query('UPDATE membres SET pc = (pc - "' . $competence[23][$donnees_comp->niveau + 1]['nbPoints'] . '") WHERE id = ' . $_SESSION['id'] . '');
							redirection('competences.php');
						}
					}
					else
					avert('Niveau maximal déjà atteint.');
				}
				else
				avert('Pas assez de points de compétence.');

			break;
		}
	}
}


for ($i = 1; $i <= 30; $i++) {

	$count_perk[$i] = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = ' . $i . ' AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

	$r_donnees_comp = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = ' . $i . '');
	$r_donnees_comp->execute();
	$donnees_comp = $r_donnees_comp->fetch(PDO::FETCH_OBJ);

		if($count_perk[$i] == 0)
		{
			$nivSuiv[$i] = 1;
			$bouton[1][$i] = '<a href="competences.php?take=' . $i . '"><button>Apprendre</button></a>';
			$bouton[2][$i] = '';
			$bouton[3][$i] = '';
			$bouton[4][$i] = '';

			$tdColor[1][$i] = '';
			$tdColor[2][$i] = '';
			$tdColor[3][$i] = '';
			$tdColor[4][$i] = '';

			$prix[$i] = '<b>' . $competence[$i][$nivSuiv[$i]]['nbPoints'] . '</b> point(s)';
			$next[$i] = '<b>Prochainement</b> : ' . $competence[$i][$nivSuiv[$i]]['dp'] . '';
		}
		elseif($donnees_comp->niveau == 1)
		{
			$bouton[1][$i] = '';
			$bouton[2][$i] = '<a href="competences.php?take=' . $i . '"><button>Améliorer</button></a>';
			$bouton[3][$i] = '';
			$bouton[4][$i] = '';

			$tdColor[1][$i] = 'style="background-color: #c9d2ff;"';
			$tdColor[2][$i] = '';
			$tdColor[3][$i] = '';
			$tdColor[4][$i] = '';

			$nivActuel[$i] = $competence[$i][$donnees_comp->niveau]['dp'] . '<br />';
			//$bouton[$i] = '<a href="competences.php?take=' . $i . '"><button>Améliorer</button></a>';
			$prix[$i] = '<b>' . $competence[$i][$nivSuiv[$i]]['nbPoints'] . '</b> point(s)';
		}
		elseif($donnees_comp->niveau == 2)
		{
			$bouton[1][$i] = '';
			$bouton[2][$i] = '';
			$bouton[3][$i] = '<a href="competences.php?take=' . $i . '"><button>Améliorer</button></a>';
			$bouton[4][$i] = '';

			$tdColor[1][$i] = 'style="background-color: #c9d2ff;"';
			$tdColor[2][$i] = 'style="background-color: #c9d2ff;"';
			$tdColor[3][$i] = '';
			$tdColor[4][$i] = '';

			$nivActuel[$i] = $competence[$i][$donnees_comp->niveau]['dp'] . '<br />';
			//$bouton[$i] = '<a href="competences.php?take=' . $i . '"><button>Améliorer</button></a>';
			$prix[$i] = '<b>' . $competence[$i][$nivSuiv[$i]]['nbPoints'] . '</b> point(s)';
		}
		elseif($donnees_comp->niveau == 3)
		{
			$bouton[1][$i] = '';
			$bouton[2][$i] = '';
			$bouton[3][$i] = '';
			$bouton[4][$i] = '<a href="competences.php?take=' . $i . '"><button>Améliorer</button></a>';

			$tdColor[1][$i] = 'style="background-color: #c9d2ff;"';
			$tdColor[2][$i] = 'style="background-color: #c9d2ff;"';
			$tdColor[3][$i] = 'style="background-color: #c9d2ff;"';
			$tdColor[4][$i] = '';

			$nivActuel[$i] = $competence[$i][$donnees_comp->niveau]['dp'] . '<br />';
			//$bouton[$i] = '<a href="competences.php?take=' . $i . '"><button>Améliorer</button></a>';
			$prix[$i] = '<b>' . $competence[$i][$nivSuiv[$i]]['nbPoints'] . '</b> point(s)';
		}
		elseif($donnees_comp->niveau == 4)
		{
			$nivSuiv[$i] = 4;
			$nivActuel[$i] = $competence[$i][4]['dp'] . '<br />';
			$bouton[1][$i] = '';
			$bouton[2][$i] = '';
			$bouton[3][$i] = '';
			$bouton[4][$i] = '';

			$tdColor[1][$i] = 'style="background-color: #c9d2ff;"';
			$tdColor[2][$i] = 'style="background-color: #c9d2ff;"';
			$tdColor[3][$i] = 'style="background-color: #c9d2ff;"';
			$tdColor[4][$i] = 'style="background-color: #c9d2ff;"';

			$prix[$i] = '';
			$next[$i] = 'Niveau maximum atteint';
		}

}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////// SCYTHE SLASH EXCEPTION //////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

 $count_perk_s = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = 16 AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

if($count_perk_s == 0)
{
	$nivSuiv[16] = 1;
	$nivActuel[16] = "Compétence non apprise<br />";
	$bouton[16] = '<a href="competences.php?take=16"><button>Apprendre</button></a>';
	$prix[16] = 'Coûte <b>' . $competence[$i][$nivSuiv[16]]['nbPoints'] . '</b> point(s) de compétence<br /><br />';
	$next[16] = '<b>Prochainement</b> : ' . $competence[16][1]['dp'] . '';

	$tdColor[1][16] = '';
}
else
{
	$nivSuiv[16] = 1;
	$nivActuel[16] = $competence[16][1]['dp'] . '<br />';
	$bouton[16] = '';
	$prix[16] = '<br /><br />';
	$next[16] = 'Niveau maximum atteint';

	$tdColor[1][16] = 'style="background-color: #c9d2ff;"';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo '
<h3>Compétences</h3>
<div class="contenu">
<h1><center>Points de compétence : ' . (int) $donnees_membres->pc . '</center></h1><br />
<center><a href="competences.php?action=reset"><button>Réinitialiser les compétences, coûte <font color="#f02243">' . number_format($totalCost) . '</font> EC (' . number_format($baseCost) . ' + ' . number_format($addedNiveau) . ')</button></a></center>
</div>

<h3>Compétences diverses et uniques</h3>
<div class="contenu">
<!--
<span style="float: left; margin-right: 10px;">
<img src="images/competences/scytheslash2.png" width="110" height="110" />
</span>
<span style="font-size: 16pt; font-weight: bold;">' . $competence[16][$nivSuiv[16]]['nom'] . '</span> <span style="float: right;">' . $bouton[16] . '</span>
<br />
Coûte <b>10</b> point(s) de compétence<br /><br />
Effet actuel : ' . $nivActuel[16] . '
' . $next[16] . '
-->

<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 50%;">Effet</th>
	<th style="width: 20%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][16] . '><img src="images/competences/scytheslash2.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][16] . '>' . $competence[16][$nivSuiv[16]]['nom'] . '</td>
	<td ' . $tdColor[1][16] . '>' . $competence[16][1]['dp'] . '</td>
	<td ' . $tdColor[1][16] . '><b>' . $competence[16][1]['nbPoints'] . '</b> points</td>
	<td ' . $tdColor[1][16] . '>' . $bouton[16] . '</td>

</tr>

</table>


<br /><br />
<div class="separate"></div>
<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 50%;">Effet</th>
	<th style="width: 20%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][17] . '><img src="images/competences/deadlystrike.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][17] . '>' . $competence[17][1]['nom'] . '</td>
	<td ' . $tdColor[1][17] . '>' . $competence[17][1]['dp'] . '</td>
	<td ' . $tdColor[1][17] . '><b>' . $competence[17][1]['nbPoints'] . '</b> points</td>
	<td ' . $tdColor[1][17] . '>' . $bouton[1][17] . '</td>

</tr>

<tr>
	<td ' . $tdColor[2][17] . '><img src="images/competences/deadlystrike.png" width="40" height="40" /></td>
	<td ' . $tdColor[2][17] . '>' . $competence[17][2]['nom'] . '</td>
	<td ' . $tdColor[2][17] . '>' . $competence[17][2]['dp'] . '</td>
	<td ' . $tdColor[2][17] . '><b>' . $competence[17][2]['nbPoints'] . '</b> points</td>
	<td ' . $tdColor[2][17] . '>' . $bouton[2][17] . '</td>

</tr>

<tr>
	<td ' . $tdColor[3][17] . '><img src="images/competences/deadlystrike.png" width="40" height="40" /></td>
	<td ' . $tdColor[3][17] . '>' . $competence[17][3]['nom'] . '</td>
	<td ' . $tdColor[3][17] . '>' . $competence[17][3]['dp'] . '</td>
	<td ' . $tdColor[3][17] . '><b>' . $competence[17][3]['nbPoints'] . '</b> points</td>
	<td ' . $tdColor[3][17] . '>' . $bouton[3][17] . '</td>

</tr>

<tr>
	<td ' . $tdColor[4][17] . '><img src="images/competences/deadlystrike.png" width="40" height="40" /></td>
	<td ' . $tdColor[4][17] . '>' . $competence[17][4]['nom'] . '</td>
	<td ' . $tdColor[4][17] . '>' . $competence[17][4]['dp'] . '</td>
	<td ' . $tdColor[4][17] . '><b>' . $competence[17][4]['nbPoints'] . '</b> points</td>
	<td ' . $tdColor[4][17] . '>' . $bouton[4][17] . '</td>

</tr>

</table>
<br /><br />

<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 50%;">Effet</th>
	<th style="width: 20%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][20] . '><img src="images/competences/hailtotheking.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][20] . '>' . $competence[20][1]['nom'] . '</td>
	<td ' . $tdColor[1][20] . '>' . $competence[20][1]['dp'] . '</td>
	<td ' . $tdColor[1][20] . '><b>' . $competence[20][1]['nbPoints'] . '</b> points</td>
	<td ' . $tdColor[1][20] . '>' . $bouton[1][20] . '</td>

</tr>

<tr>
	<td ' . $tdColor[2][20] . '><img src="images/competences/hailtotheking.png" width="40" height="40" /></td>
	<td ' . $tdColor[2][20] . '>' . $competence[20][2]['nom'] . '</td>
	<td ' . $tdColor[2][20] . '>' . $competence[20][2]['dp'] . '</td>
	<td ' . $tdColor[2][20] . '><b>' . $competence[20][2]['nbPoints'] . '</b> points</td>
	<td ' . $tdColor[2][20] . '>' . $bouton[2][20] . '</td>

</tr>

<tr>
	<td ' . $tdColor[3][20] . '><img src="images/competences/hailtotheking.png" width="40" height="40" /></td>
	<td ' . $tdColor[3][20] . '>' . $competence[20][3]['nom'] . '</td>
	<td ' . $tdColor[3][20] . '>' . $competence[20][3]['dp'] . '</td>
	<td ' . $tdColor[3][20] . '><b>' . $competence[20][3]['nbPoints'] . '</b> points</td>
	<td ' . $tdColor[3][20] . '>' . $bouton[3][20] . '</td>

</tr>

<tr>
	<td ' . $tdColor[4][20] . '><img src="images/competences/hailtotheking.png" width="40" height="40" /></td>
	<td ' . $tdColor[4][20] . '>' . $competence[20][4]['nom'] . '</td>
	<td ' . $tdColor[4][20] . '>' . $competence[20][4]['dp'] . '</td>
	<td ' . $tdColor[4][20] . '><b>' . $competence[20][4]['nbPoints'] . '</b> points</td>
	<td ' . $tdColor[4][20] . '>' . $bouton[4][20] . '</td>

</tr>

</table>
</div>

<h3><img src="images/caracteristiques/vie.png" height="40" width="40" /> Compétences sur la vitalité</h3>
<div class="contenu">
<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 50%;">Effet</th>
	<th style="width: 20%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][3] . '><img src="images/competences/heartless.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][3] . '>' . $competence[3][1]['nom'] . '</td>
	<td ' . $tdColor[1][3] . '>' . $competence[3][1]['dp'] . '</td>
	<td ' . $tdColor[1][3] . '><b>' . $competence[3][1]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[1][3] . '>' . $bouton[1][3] . '</td>

</tr>

<tr>
	<td ' . $tdColor[2][3] . '><img src="images/competences/heartless.png" width="40" height="40" /></td>
	<td ' . $tdColor[2][3] . '>' . $competence[3][2]['nom'] . '</td>
	<td ' . $tdColor[2][3] . '>' . $competence[3][2]['dp'] . '</td>
	<td ' . $tdColor[2][3] . '><b>' . $competence[3][2]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[2][3] . '>' . $bouton[2][3] . '</td>

</tr>

<tr>
	<td ' . $tdColor[3][3] . '><img src="images/competences/heartless.png" width="40" height="40" /></td>
	<td ' . $tdColor[3][3] . '>' . $competence[3][3]['nom'] . '</td>
	<td ' . $tdColor[3][3] . '>' . $competence[3][3]['dp'] . '</td>
	<td ' . $tdColor[3][3] . '><b>' . $competence[3][3]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[3][3] . '>' . $bouton[3][3] . '</td>

</tr>

<tr>
	<td ' . $tdColor[4][3] . '><img src="images/competences/heartless.png" width="40" height="40" /></td>
	<td ' . $tdColor[4][3] . '>' . $competence[3][4]['nom'] . '</td>
	<td ' . $tdColor[4][3] . '>' . $competence[3][4]['dp'] . '</td>
	<td ' . $tdColor[4][3] . '><b>' . $competence[3][4]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[4][3] . '>' . $bouton[4][3] . '</td>

</tr>

</table>
<br /><br />
<div class="separate"></div>

<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 70%;">Effet</th>
	<th style="width: 15%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][4] . '><img src="images/competences/bloodmoney.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][4] . '>' . $competence[4][1]['nom'] . '</td>
	<td ' . $tdColor[1][4] . '>' . $competence[4][1]['dp'] . '</td>
	<td ' . $tdColor[1][4] . '><b>' . $competence[4][1]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[1][4] . '>' . $bouton[1][4] . '</td>

</tr>

<tr>
	<td ' . $tdColor[2][4] . '><img src="images/competences/bloodmoney.png" width="40" height="40" /></td>
	<td ' . $tdColor[2][4] . '>' . $competence[4][2]['nom'] . '</td>
	<td ' . $tdColor[2][4] . '>' . $competence[4][2]['dp'] . '</td>
	<td ' . $tdColor[2][4] . '><b>' . $competence[4][2]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[2][4] . '>' . $bouton[2][4] . '</td>

</tr>

<tr>
	<td ' . $tdColor[3][4] . '><img src="images/competences/bloodmoney.png" width="40" height="40" /></td>
	<td ' . $tdColor[3][4] . '>' . $competence[4][3]['nom'] . '</td>
	<td ' . $tdColor[3][4] . '>' . $competence[4][3]['dp'] . '</td>
	<td ' . $tdColor[3][4] . '><b>' . $competence[4][3]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[3][4] . '>' . $bouton[3][4] . '</td>

</tr>

<tr>
	<td ' . $tdColor[4][4] . '><img src="images/competences/bloodmoney.png" width="40" height="40" /></td>
	<td ' . $tdColor[4][4] . '>' . $competence[4][4]['nom'] . '</td>
	<td ' . $tdColor[4][4] . '>' . $competence[4][4]['dp'] . '</td>
	<td ' . $tdColor[4][4] . '><b>' . $competence[4][4]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[4][4] . '>' . $bouton[4][4] . '</td>

</tr>

</table>
<br /><br />

</table>
<br /><br />
<div class="separate"></div>

<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 70%;">Effet</th>
	<th style="width: 15%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][21] . '><img src="images/competences/heartbreaker.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][21] . '>' . $competence[21][1]['nom'] . '</td>
	<td ' . $tdColor[1][21] . '>' . $competence[21][1]['dp'] . '</td>
	<td ' . $tdColor[1][21] . '><b>' . $competence[21][1]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[1][21] . '>' . $bouton[1][21] . '</td>

</tr>

<tr>
	<td ' . $tdColor[2][21] . '><img src="images/competences/heartbreaker.png" width="40" height="40" /></td>
	<td ' . $tdColor[2][21] . '>' . $competence[21][2]['nom'] . '</td>
	<td ' . $tdColor[2][21] . '>' . $competence[21][2]['dp'] . '</td>
	<td ' . $tdColor[2][21] . '><b>' . $competence[21][2]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[2][21] . '>' . $bouton[2][21] . '</td>

</tr>

<tr>
	<td ' . $tdColor[3][21] . '><img src="images/competences/heartbreaker.png" width="40" height="40" /></td>
	<td ' . $tdColor[3][21] . '>' . $competence[21][3]['nom'] . '</td>
	<td ' . $tdColor[3][21] . '>' . $competence[21][3]['dp'] . '</td>
	<td ' . $tdColor[3][21] . '><b>' . $competence[21][3]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[3][21] . '>' . $bouton[3][21] . '</td>

</tr>

<tr>
	<td ' . $tdColor[4][21] . '><img src="images/competences/heartbreaker.png" width="40" height="40" /></td>
	<td ' . $tdColor[4][21] . '>' . $competence[21][4]['nom'] . '</td>
	<td ' . $tdColor[4][21] . '>' . $competence[21][4]['dp'] . '</td>
	<td ' . $tdColor[4][21] . '><b>' . $competence[21][4]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[4][21] . '>' . $bouton[4][21] . '</td>

</tr>

</table>
</div>

<h3><img src="images/caracteristiques/force.png" height="40" width="40" /> Compétences sur la force</h3>
<div class="contenu">
<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 70%;">Effet</th>
	<th style="width: 15%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][5] . '><img src="images/competences/bagguy.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][5] . '>' . $competence[5][1]['nom'] . '</td>
	<td ' . $tdColor[1][5] . '>' . $competence[5][1]['dp'] . '</td>
	<td ' . $tdColor[1][5] . '><b>' . $competence[5][1]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[1][5] . '>' . $bouton[1][5] . '</td>

</tr>

<tr>
	<td ' . $tdColor[2][5] . '><img src="images/competences/bagguy.png" width="40" height="40" /></td>
	<td ' . $tdColor[2][5] . '>' . $competence[5][2]['nom'] . '</td>
	<td ' . $tdColor[2][5] . '>' . $competence[5][2]['dp'] . '</td>
	<td ' . $tdColor[2][5] . '><b>' . $competence[5][2]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[2][5] . '>' . $bouton[2][5] . '</td>

</tr>

<tr>
	<td ' . $tdColor[3][5] . '><img src="images/competences/bagguy.png" width="40" height="40" /></td>
	<td ' . $tdColor[3][5] . '>' . $competence[5][3]['nom'] . '</td>
	<td ' . $tdColor[3][5] . '>' . $competence[5][3]['dp'] . '</td>
	<td ' . $tdColor[3][5] . '><b>' . $competence[5][3]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[3][5] . '>' . $bouton[3][5] . '</td>

</tr>

<tr>
	<td ' . $tdColor[4][5] . '><img src="images/competences/bagguy.png" width="40" height="40" /></td>
	<td ' . $tdColor[4][5] . '>' . $competence[5][4]['nom'] . '</td>
	<td ' . $tdColor[4][5] . '>' . $competence[5][4]['dp'] . '</td>
	<td ' . $tdColor[4][5] . '><b>' . $competence[5][4]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[4][5] . '>' . $bouton[4][5] . '</td>

</tr>

</table>
<br /><br />
<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 70%;">Effet</th>
	<th style="width: 15%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][6] . '><img src="images/competences/punch.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][6] . '>' . $competence[6][1]['nom'] . '</td>
	<td ' . $tdColor[1][6] . '>' . $competence[6][1]['dp'] . '</td>
	<td ' . $tdColor[1][6] . '><b>' . $competence[6][1]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[1][6] . '>' . $bouton[1][6] . '</td>

</tr>

<tr>
	<td ' . $tdColor[2][6] . '><img src="images/competences/punch.png" width="40" height="40" /></td>
	<td ' . $tdColor[2][6] . '>' . $competence[6][2]['nom'] . '</td>
	<td ' . $tdColor[2][6] . '>' . $competence[6][2]['dp'] . '</td>
	<td ' . $tdColor[2][6] . '><b>' . $competence[6][2]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[2][6] . '>' . $bouton[2][6] . '</td>

</tr>

<tr>
	<td ' . $tdColor[3][6] . '><img src="images/competences/punch.png" width="40" height="40" /></td>
	<td ' . $tdColor[3][6] . '>' . $competence[6][3]['nom'] . '</td>
	<td ' . $tdColor[3][6] . '>' . $competence[6][3]['dp'] . '</td>
	<td ' . $tdColor[3][6] . '><b>' . $competence[6][3]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[3][6] . '>' . $bouton[3][6] . '</td>

</tr>

<tr>
	<td ' . $tdColor[4][6] . '><img src="images/competences/punch.png" width="40" height="40" /></td>
	<td ' . $tdColor[4][6] . '>' . $competence[6][4]['nom'] . '</td>
	<td ' . $tdColor[4][6] . '>' . $competence[6][4]['dp'] . '</td>
	<td ' . $tdColor[4][6] . '><b>' . $competence[6][4]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[4][6] . '>' . $bouton[4][6] . '</td>

</tr>

</table>
<br /><br />
<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 70%;">Effet</th>
	<th style="width: 15%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][7] . '><img src="images/competences/mystrengh.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][7] . '>' . $competence[7][1]['nom'] . '</td>
	<td ' . $tdColor[1][7] . '>' . $competence[7][1]['dp'] . '</td>
	<td ' . $tdColor[1][7] . '><b>' . $competence[7][1]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[1][7] . '>' . $bouton[1][7] . '</td>

</tr>

<tr>
	<td ' . $tdColor[2][7] . '><img src="images/competences/mystrengh.png" width="40" height="40" /></td>
	<td ' . $tdColor[2][7] . '>' . $competence[7][2]['nom'] . '</td>
	<td ' . $tdColor[2][7] . '>' . $competence[7][2]['dp'] . '</td>
	<td ' . $tdColor[2][7] . '><b>' . $competence[7][2]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[2][7] . '>' . $bouton[2][7] . '</td>

</tr>

<tr>
	<td ' . $tdColor[3][7] . '><img src="images/competences/mystrengh.png" width="40" height="40" /></td>
	<td ' . $tdColor[3][7] . '>' . $competence[7][3]['nom'] . '</td>
	<td ' . $tdColor[3][7] . '>' . $competence[7][3]['dp'] . '</td>
	<td ' . $tdColor[3][7] . '><b>' . $competence[7][3]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[3][7] . '>' . $bouton[3][7] . '</td>

</tr>

<tr>
	<td ' . $tdColor[4][7] . '><img src="images/competences/mystrengh.png" width="40" height="40" /></td>
	<td ' . $tdColor[4][7] . '>' . $competence[7][4]['nom'] . '</td>
	<td ' . $tdColor[4][7] . '>' . $competence[7][4]['dp'] . '</td>
	<td ' . $tdColor[4][7] . '><b>' . $competence[7][4]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[4][7] . '>' . $bouton[4][7] . '</td>

</tr>

</table>
<br /><br />
<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 70%;">Effet</th>
	<th style="width: 15%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][18] . '><img src="images/competences/bettershield.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][18] . '>' . $competence[18][1]['nom'] . '</td>
	<td ' . $tdColor[1][18] . '>' . $competence[18][1]['dp'] . '</td>
	<td ' . $tdColor[1][18] . '><b>' . $competence[18][1]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[1][18] . '>' . $bouton[1][18] . '</td>

</tr>

<tr>
	<td ' . $tdColor[2][18] . '><img src="images/competences/bettershield.png" width="40" height="40" /></td>
	<td ' . $tdColor[2][18] . '>' . $competence[18][2]['nom'] . '</td>
	<td ' . $tdColor[2][18] . '>' . $competence[18][2]['dp'] . '</td>
	<td ' . $tdColor[2][18] . '><b>' . $competence[18][2]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[2][18] . '>' . $bouton[2][18] . '</td>

</tr>

<tr>
	<td ' . $tdColor[3][18] . '><img src="images/competences/bettershield.png" width="40" height="40" /></td>
	<td ' . $tdColor[3][18] . '>' . $competence[18][3]['nom'] . '</td>
	<td ' . $tdColor[3][18] . '>' . $competence[18][3]['dp'] . '</td>
	<td ' . $tdColor[3][18] . '><b>' . $competence[18][3]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[3][18] . '>' . $bouton[3][18] . '</td>

</tr>

<tr>
	<td ' . $tdColor[4][18] . '><img src="images/competences/bettershield.png" width="40" height="40" /></td>
	<td ' . $tdColor[4][18] . '>' . $competence[18][4]['nom'] . '</td>
	<td ' . $tdColor[4][18] . '>' . $competence[18][4]['dp'] . '</td>
	<td ' . $tdColor[4][18] . '><b>' . $competence[18][4]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[4][18] . '>' . $bouton[4][18] . '</td>

</tr>

</table>

</div>


<h3><img src="images/caracteristiques/intelligence.png" height="40" width="40" /> Compétences sur l\'intelligence</h3>
<div class="contenu">
<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 70%;">Effet</th>
	<th style="width: 15%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][1] . '><img src="images/competences/watchingthestars.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][1] . '>' . $competence[1][1]['nom'] . '</td>
	<td ' . $tdColor[1][1] . '>' . $competence[1][1]['dp'] . '</td>
	<td ' . $tdColor[1][1] . '><b>' . $competence[1][1]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[1][1] . '>' . $bouton[1][1] . '</td>

</tr>

<tr>
	<td ' . $tdColor[2][1] . '><img src="images/competences/watchingthestars.png" width="40" height="40" /></td>
	<td ' . $tdColor[2][1] . '>' . $competence[1][2]['nom'] . '</td>
	<td ' . $tdColor[2][1] . '>' . $competence[1][2]['dp'] . '</td>
	<td ' . $tdColor[2][1] . '><b>' . $competence[1][2]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[2][1] . '>' . $bouton[2][1] . '</td>

</tr>

<tr>
	<td ' . $tdColor[3][1] . '><img src="images/competences/watchingthestars.png" width="40" height="40" /></td>
	<td ' . $tdColor[3][1] . '>' . $competence[1][3]['nom'] . '</td>
	<td ' . $tdColor[3][1] . '>' . $competence[1][3]['dp'] . '</td>
	<td ' . $tdColor[3][1] . '><b>' . $competence[1][3]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[3][1] . '>' . $bouton[3][1] . '</td>

</tr>

<tr>
	<td ' . $tdColor[4][1] . '><img src="images/competences/watchingthestars.png" width="40" height="40" /></td>
	<td ' . $tdColor[4][1] . '>' . $competence[1][4]['nom'] . '</td>
	<td ' . $tdColor[4][1] . '>' . $competence[1][4]['dp'] . '</td>
	<td ' . $tdColor[4][1] . '><b>' . $competence[1][4]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[4][1] . '>' . $bouton[4][1] . '</td>

</tr>

</table>
<br /><br />
<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 70%;">Effet</th>
	<th style="width: 15%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][2] . '><img src="images/competences/fairywand.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][2] . '>' . $competence[2][1]['nom'] . '</td>
	<td ' . $tdColor[1][2] . '>' . $competence[2][1]['dp'] . '</td>
	<td ' . $tdColor[1][2] . '><b>' . $competence[2][1]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[1][2] . '>' . $bouton[1][2] . '</td>

</tr>

<tr>
	<td ' . $tdColor[2][2] . '><img src="images/competences/fairywand.png" width="40" height="40" /></td>
	<td ' . $tdColor[2][2] . '>' . $competence[2][2]['nom'] . '</td>
	<td ' . $tdColor[2][2] . '>' . $competence[2][2]['dp'] . '</td>
	<td ' . $tdColor[2][2] . '><b>' . $competence[2][2]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[2][2] . '>' . $bouton[2][2] . '</td>

</tr>

<tr>
	<td ' . $tdColor[3][2] . '><img src="images/competences/fairywand.png" width="40" height="40" /></td>
	<td ' . $tdColor[3][2] . '>' . $competence[2][3]['nom'] . '</td>
	<td ' . $tdColor[3][2] . '>' . $competence[2][3]['dp'] . '</td>
	<td ' . $tdColor[3][2] . '><b>' . $competence[2][3]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[3][2] . '>' . $bouton[3][2] . '</td>

</tr>

<tr>
	<td ' . $tdColor[4][2] . '><img src="images/competences/fairywand.png" width="40" height="40" /></td>
	<td ' . $tdColor[4][2] . '>' . $competence[2][4]['nom'] . '</td>
	<td ' . $tdColor[4][2] . '>' . $competence[2][4]['dp'] . '</td>
	<td ' . $tdColor[4][2] . '><b>' . $competence[2][4]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[4][2] . '>' . $bouton[4][2] . '</td>

</tr>

</table>
<br /><br />
<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 70%;">Effet</th>
	<th style="width: 15%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][8] . '><img src="images/competences/themaster.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][8] . '>' . $competence[8][1]['nom'] . '</td>
	<td ' . $tdColor[1][8] . '>' . $competence[8][1]['dp'] . '</td>
	<td ' . $tdColor[1][8] . '><b>' . $competence[8][1]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[1][8] . '>' . $bouton[1][8] . '</td>

</tr>

<tr>
	<td ' . $tdColor[2][8] . '><img src="images/competences/themaster.png" width="40" height="40" /></td>
	<td ' . $tdColor[2][8] . '>' . $competence[8][2]['nom'] . '</td>
	<td ' . $tdColor[2][8] . '>' . $competence[8][2]['dp'] . '</td>
	<td ' . $tdColor[2][8] . '><b>' . $competence[8][2]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[2][8] . '>' . $bouton[2][8] . '</td>

</tr>

<tr>
	<td ' . $tdColor[3][8] . '><img src="images/competences/themaster.png" width="40" height="40" /></td>
	<td ' . $tdColor[3][8] . '>' . $competence[8][3]['nom'] . '</td>
	<td ' . $tdColor[3][8] . '>' . $competence[8][3]['dp'] . '</td>
	<td ' . $tdColor[3][8] . '><b>' . $competence[8][3]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[3][8] . '>' . $bouton[3][8] . '</td>

</tr>

<tr>
	<td ' . $tdColor[4][8] . '><img src="images/competences/themaster.png" width="40" height="40" /></td>
	<td ' . $tdColor[4][8] . '>' . $competence[8][4]['nom'] . '</td>
	<td ' . $tdColor[4][8] . '>' . $competence[8][4]['dp'] . '</td>
	<td ' . $tdColor[4][8] . '><b>' . $competence[8][4]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[4][8] . '>' . $bouton[4][8] . '</td>

</tr>

</table>
<br /><br />
<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 70%;">Effet</th>
	<th style="width: 15%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][22] . '><img src="images/competences/morehealing.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][22] . '>' . $competence[22][1]['nom'] . '</td>
	<td ' . $tdColor[1][22] . '>' . $competence[22][1]['dp'] . '</td>
	<td ' . $tdColor[1][22] . '><b>' . $competence[22][1]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[1][22] . '>' . $bouton[1][22] . '</td>

</tr>

<tr>
	<td ' . $tdColor[2][22] . '><img src="images/competences/morehealing.png" width="40" height="40" /></td>
	<td ' . $tdColor[2][22] . '>' . $competence[22][2]['nom'] . '</td>
	<td ' . $tdColor[2][22] . '>' . $competence[22][2]['dp'] . '</td>
	<td ' . $tdColor[2][22] . '><b>' . $competence[22][2]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[2][22] . '>' . $bouton[2][22] . '</td>

</tr>

<tr>
	<td ' . $tdColor[3][22] . '><img src="images/competences/morehealing.png" width="40" height="40" /></td>
	<td ' . $tdColor[3][22] . '>' . $competence[22][3]['nom'] . '</td>
	<td ' . $tdColor[3][22] . '>' . $competence[22][3]['dp'] . '</td>
	<td ' . $tdColor[3][22] . '><b>' . $competence[22][3]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[3][22] . '>' . $bouton[3][22] . '</td>

</tr>

<tr>
	<td ' . $tdColor[4][22] . '><img src="images/competences/morehealing.png" width="40" height="40" /></td>
	<td ' . $tdColor[4][22] . '>' . $competence[22][4]['nom'] . '</td>
	<td ' . $tdColor[4][22] . '>' . $competence[22][4]['dp'] . '</td>
	<td ' . $tdColor[4][22] . '><b>' . $competence[22][4]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[4][22] . '>' . $bouton[4][22] . '</td>

</tr>

</table>

</div>



<h3><img src="images/caracteristiques/puissance.png" height="40" width="40" /> Compétences sur la puissance</h3>
<div class="contenu">
<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 70%;">Effet</th>
	<th style="width: 15%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][9] . '><img src="images/competences/overkill.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][9] . '>' . $competence[9][1]['nom'] . '</td>
	<td ' . $tdColor[1][9] . '>' . $competence[9][1]['dp'] . '</td>
	<td ' . $tdColor[1][9] . '><b>' . $competence[9][1]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[1][9] . '>' . $bouton[1][9] . '</td>

</tr>

<tr>
	<td ' . $tdColor[2][9] . '><img src="images/competences/overkill.png" width="40" height="40" /></td>
	<td ' . $tdColor[2][9] . '>' . $competence[9][2]['nom'] . '</td>
	<td ' . $tdColor[2][9] . '>' . $competence[9][2]['dp'] . '</td>
	<td ' . $tdColor[2][9] . '><b>' . $competence[9][2]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[2][9] . '>' . $bouton[2][9] . '</td>

</tr>

<tr>
	<td ' . $tdColor[3][9] . '><img src="images/competences/overkill.png" width="40" height="40" /></td>
	<td ' . $tdColor[3][9] . '>' . $competence[9][3]['nom'] . '</td>
	<td ' . $tdColor[3][9] . '>' . $competence[9][3]['dp'] . '</td>
	<td ' . $tdColor[3][9] . '><b>' . $competence[9][3]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[3][9] . '>' . $bouton[3][9] . '</td>

</tr>

<tr>
	<td ' . $tdColor[4][9] . '><img src="images/competences/overkill.png" width="40" height="40" /></td>
	<td ' . $tdColor[4][9] . '>' . $competence[9][4]['nom'] . '</td>
	<td ' . $tdColor[4][9] . '>' . $competence[9][4]['dp'] . '</td>
	<td ' . $tdColor[4][9] . '><b>' . $competence[9][4]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[4][9] . '>' . $bouton[4][9] . '</td>

</tr>

</table>
<br /><br />
<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 70%;">Effet</th>
	<th style="width: 15%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][10] . '><img src="images/competences/bleed.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][10] . '>' . $competence[10][1]['nom'] . '</td>
	<td ' . $tdColor[1][10] . '>' . $competence[10][1]['dp'] . '</td>
	<td ' . $tdColor[1][10] . '><b>' . $competence[10][1]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[1][10] . '>' . $bouton[1][10] . '</td>

</tr>

<tr>
	<td ' . $tdColor[2][10] . '><img src="images/competences/bleed.png" width="40" height="40" /></td>
	<td ' . $tdColor[2][10] . '>' . $competence[10][2]['nom'] . '</td>
	<td ' . $tdColor[2][10] . '>' . $competence[10][2]['dp'] . '</td>
	<td ' . $tdColor[2][10] . '><b>' . $competence[10][2]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[2][10] . '>' . $bouton[2][10] . '</td>

</tr>

<tr>
	<td ' . $tdColor[3][10] . '><img src="images/competences/bleed.png" width="40" height="40" /></td>
	<td ' . $tdColor[3][10] . '>' . $competence[10][3]['nom'] . '</td>
	<td ' . $tdColor[3][10] . '>' . $competence[10][3]['dp'] . '</td>
	<td ' . $tdColor[3][10] . '><b>' . $competence[10][3]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[3][10] . '>' . $bouton[3][10] . '</td>

</tr>

<tr>
	<td ' . $tdColor[4][10] . '><img src="images/competences/bleed.png" width="40" height="40" /></td>
	<td ' . $tdColor[4][10] . '>' . $competence[10][4]['nom'] . '</td>
	<td ' . $tdColor[4][10] . '>' . $competence[10][4]['dp'] . '</td>
	<td ' . $tdColor[4][10] . '><b>' . $competence[10][4]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[4][10] . '>' . $bouton[4][10] . '</td>

</tr>

</table>

<br /><br />
<table style="width: 100%">
<tr>
	<th> </th>
	<th style="width: 20%;">Compétence</th>
	<th style="width: 70%;">Effet</th>
	<th style="width: 15%;">Coût</th>
	<th style="width: 10%;"> </th>
</tr>

<tr>
	<td ' . $tdColor[1][23] . '><img src="images/competences/sword1.png" width="40" height="40" /></td>
	<td ' . $tdColor[1][23] . '>' . $competence[23][1]['nom'] . '</td>
	<td ' . $tdColor[1][23] . '>' . $competence[23][1]['dp'] . '</td>
	<td ' . $tdColor[1][23] . '><b>' . $competence[23][1]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[1][23] . '>' . $bouton[1][23] . '</td>

</tr>

<tr>
	<td ' . $tdColor[2][23] . '><img src="images/competences/sword1.png" width="40" height="40" /></td>
	<td ' . $tdColor[2][23] . '>' . $competence[23][2]['nom'] . '</td>
	<td ' . $tdColor[2][23] . '>' . $competence[23][2]['dp'] . '</td>
	<td ' . $tdColor[2][23] . '><b>' . $competence[23][2]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[2][23] . '>' . $bouton[2][23] . '</td>

</tr>

<tr>
	<td ' . $tdColor[3][23] . '><img src="images/competences/sword1.png" width="40" height="40" /></td>
	<td ' . $tdColor[3][23] . '>' . $competence[23][3]['nom'] . '</td>
	<td ' . $tdColor[3][23] . '>' . $competence[23][3]['dp'] . '</td>
	<td ' . $tdColor[3][23] . '><b>' . $competence[23][3]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[3][23] . '>' . $bouton[3][23] . '</td>

</tr>

<tr>
	<td ' . $tdColor[4][23] . '><img src="images/competences/sword1.png" width="40" height="40" /></td>
	<td ' . $tdColor[4][23] . '>' . $competence[23][4]['nom'] . '</td>
	<td ' . $tdColor[4][23] . '>' . $competence[23][4]['dp'] . '</td>
	<td ' . $tdColor[4][23] . '><b>' . $competence[23][4]['nbPoints'] . '</b> point(s)</td>
	<td ' . $tdColor[4][23] . '>' . $bouton[4][23] . '</td>

</tr>

</table>

</div>



<h3><img src="images/caracteristiques/agilite.png" height="40" width="40" /> Compétences sur l\'agilité</h3>
<div class="contenu">
<span style="float: left; margin-right: 10px;">
<img src="images/competences/dodge.png" width="110" height="110" />
</span>

<span style="font-size: 16pt; font-weight: bold;">' . $competence[11][$nivSuiv[11]]['nom'] . '</span> <span style="float: right;">' . $bouton[11] . '</span>
<br />
' . $prix[11] . '
Effet actuel : ' . $nivActuel[11] . '
' . $next[11] . '
<br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;">
<img src="images/competences/wind.png" width="110" height="110" />
</span>

<span style="font-size: 16pt; font-weight: bold;">' . $competence[12][$nivSuiv[12]]['nom'] . '</span> <span style="float: right;">' . $bouton[12] . '</span>
<br />
' . $prix[12] . '
Effet actuel : ' . $nivActuel[12] . '
' . $next[12] . '
<br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;">
<img src="images/competences/stopwatch.png" width="110" height="110" />
</span>

<span style="font-size: 16pt; font-weight: bold;">' . $competence[19][$nivSuiv[19]]['nom'] . '</span> <span style="float: right;">' . $bouton[19] . '</span>
<br />
' . $prix[19] . '
Effet actuel : ' . $nivActuel[19] . '
' . $next[19] . '
</div>



<h3><img src="images/caracteristiques/chance.png" height="40" width="40" /> Compétences sur la chance</h3>
<div class="contenu">
<span style="float: left; margin-right: 10px;">
<img src="images/competences/deadbastard.png" width="110" height="110" />
</span>

<span style="font-size: 16pt; font-weight: bold;">' . $competence[13][$nivSuiv[13]]['nom'] . '</span> <span style="float: right;">' . $bouton[13] . '</span>
<br />
' . $prix[13] . '
Effet actuel : ' . $nivActuel[13] . '
' . $next[13] . '
<br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;">
<img src="images/competences/thesearcher.png" width="110" height="110" />
</span>

<span style="font-size: 16pt; font-weight: bold;">' . $competence[14][$nivSuiv[14]]['nom'] . '</span> <span style="float: right;">' . $bouton[14] . '</span>
<br />
' . $prix[14] . '
Effet actuel : ' . $nivActuel[14] . '
' . $next[14] . '
<br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;">
<img src="images/competences/luckycharm.png" width="110" height="110" />
</span>

<span style="font-size: 16pt; font-weight: bold;">' . $competence[15][$nivSuiv[15]]['nom'] . '</span> <span style="float: right;">' . $bouton[15] . '</span>
<br />
' . $prix[15] . '
Effet actuel : ' . $nivActuel[15] . '
' . $next[15] . '

</div>

';

if($donnees_membres->prestige > 0)
{
	echo '
	<h3>Compétences du mode Reborn</h3>
	<div class="contenu">

	<span style="float: left; margin-right: 10px;">
	<img src="images/competences/reborn1.png" width="110" height="110" />
	</span>

	<span style="font-size: 16pt; font-weight: bold;">' . $competence[24][$nivSuiv[24]]['nom'] . '</span> <span style="float: right;">' . $bouton[24] . '</span>
	<br />
	' . $prix[24] . '
	Effet actuel : ' . $nivActuel[24] . '
	' . $next[24] . '
	<br /><br />
	<div class="separate"></div>

	<span style="float: left; margin-right: 10px;">
	<img src="images/competences/reborn3.png" width="110" height="110" />
	</span>

	<span style="font-size: 16pt; font-weight: bold;">' . $competence[25][$nivSuiv[25]]['nom'] . '</span> <span style="float: right;">' . $bouton[25] . '</span>
	<br />
	' . $prix[25] . '
	Effet actuel : ' . $nivActuel[25] . '
	' . $next[25] . '
	<br /><br />
	<div class="separate"></div>

	<span style="float: left; margin-right: 10px;">
	<img src="images/competences/reborn8.png" width="110" height="110" />
	</span>

	<span style="font-size: 16pt; font-weight: bold;">' . $competence[26][$nivSuiv[26]]['nom'] . '</span> <span style="float: right;">' . $bouton[26] . '</span>
	<br />
	' . $prix[26] . '
	Effet actuel : ' . $nivActuel[26] . '
	' . $next[26] . '
	<br /><br />
	<div class="separate"></div>

	<span style="float: left; margin-right: 10px;">
	<img src="images/competences/reborn13.png" width="110" height="110" />
	</span>

	<span style="font-size: 16pt; font-weight: bold;">' . $competence[27][$nivSuiv[27]]['nom'] . '</span> <span style="float: right;">' . $bouton[27] . '</span>
	<br />
	' . $prix[27] . '
	Effet actuel : ' . $nivActuel[27] . '
	' . $next[27] . '
	<br /><br />
	<div class="separate"></div>

	<span style="float: left; margin-right: 10px;">
	<img src="images/competences/reborn17.png" width="110" height="110" />
	</span>

	<span style="font-size: 16pt; font-weight: bold;">' . $competence[28][$nivSuiv[28]]['nom'] . '</span> <span style="float: right;">' . $bouton[28] . '</span>
	<br />
	' . $prix[28] . '
	Effet actuel : ' . $nivActuel[28] . '
	' . $next[28] . '
	<br /><br />
	<div class="separate"></div>

	<span style="float: left; margin-right: 10px;">
	<img src="images/competences/reborn20.png" width="110" height="110" />
	</span>

	<span style="font-size: 16pt; font-weight: bold;">' . $competence[29][$nivSuiv[29]]['nom'] . '</span> <span style="float: right;">' . $bouton[29] . '</span>
	<br />
	' . $prix[29] . '
	Effet actuel : ' . $nivActuel[29] . '
	' . $next[29] . '
	<br /><br />
	<div class="separate"></div>

	</div>
	';
}



include('pied.php');
?>
