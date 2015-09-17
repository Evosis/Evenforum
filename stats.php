<?php
include('base.php');
include('tete.php');

siMembre();

$countPerso = $connexion->query('SELECT COUNT(*) FROM personnages WHERE idPseudo = ' . $_SESSION['id'])->fetchColumn();

if($countPerso == 0)
{
	if(isset($_POST['nom']))
	{
		if($_POST['nom'] != "")
		{
			if(preg_match("#^[a-zA-Z]{3,15}$#", $_POST['nom']))
			{
				$insert_bdd = $connexion->prepare("INSERT INTO personnages VALUES('', :idPseudo, :nomPerso, :choixArme, :vitalite, :force, :intel, :dext, :agilite, :chance, :ptsCarac, :timestamp, :killed)");
				$insert_bdd->execute(array(
				'idPseudo' => $_SESSION['id'],
				'nomPerso' => $_POST['nom'],
				'choixArme' => 0,
				'vitalite' => 0,
				'force' => 0,
				'intel' => 0,
				'dext' => 0,
				'agilite' => 0,
				'chance' => 0,
				'ptsCarac' => 0,
				'timestamp' => time(),
				'killed' => 0
				));

				redirection('stats.php');
			}
			else
			avert('Nom de personnage invalide');
		}
		else
		avert('Nom de personnage invalide');
	}


	echo '
	<h3>Créer un personnage</h3>
	<div class="contenu">
	<form method="post">
	En créant votre personnage sur l\'Even, vous pourrez profiter des fonctions telles que les compétences, les caractéristiques, les quêtes, ainsi que toutes les autres
	fonctions qui sont liés au RPG inclu au site.<br /><br />
	Pour commencer, veuillez donner un nom à votre personnage. <b>Il ne peut pas dépasser 15 caractères, doit au moins faire 3 caractères, et il doit se composer uniquement de caractères alphabétique.</b><br /><br />

	<label>Nom de votre perso :</label>		<input type="text" name="nom" maxlength="15"><br />
	<input type="submit">
	</form>
	</div>
	';

	include('pied.php');
	exit;
}

$countPerso = $connexion->query('SELECT COUNT(*) FROM personnages WHERE idPseudo = ' . $_SESSION['id'] . ' AND killed = 0')->fetchColumn();

if($countPerso == 0)
{
	avert('Vous devez posséder un personnage non tué pour accéder aux caractéristiques.');
	include('pied.php');
	exit;
}

$r_donnees_perso = $connexion->prepare('SELECT * FROM personnages WHERE idPseudo = ' . $_SESSION['id']);
$r_donnees_perso->execute();
$donnees_perso = $r_donnees_perso->fetch(PDO::FETCH_OBJ);

if($donnees_perso->choixArme == 0)
{

	if(isset($_GET['choixArme']))
	{
		if($donnees_perso->choixArme == 0)
		{
			$choixArme = (int) $_GET['choixArme'];

			if($choixArme > 0 AND $choixArme < 9)
			{
				switch($choixArme)
				{
					case 1:
					$connexion->query("INSERT INTO inventaire VALUES('', '" . $_SESSION['id'] . "', '43', '1', '" . $_SESSION['pseudo'] . "', '" . $donnees_perso->nomPerso . "', '" . time() . "')");
					break;

					case 2:
					$connexion->query("INSERT INTO inventaire VALUES('', '" . $_SESSION['id'] . "', '44', '1', '" . $_SESSION['pseudo'] . "', '" . $donnees_perso->nomPerso . "', '" . time() . "')");
					break;

					case 3:
					$connexion->query("INSERT INTO inventaire VALUES('', '" . $_SESSION['id'] . "', '45', '1', '" . $_SESSION['pseudo'] . "', '" . $donnees_perso->nomPerso . "', '" . time() . "')");
					break;

					case 4:
					$connexion->query("INSERT INTO inventaire VALUES('', '" . $_SESSION['id'] . "', '46', '1', '" . $_SESSION['pseudo'] . "', '" . $donnees_perso->nomPerso . "', '" . time() . "')");
					break;

					case 5:
					$connexion->query("INSERT INTO inventaire VALUES('', '" . $_SESSION['id'] . "', '47', '1', '" . $_SESSION['pseudo'] . "', '" . $donnees_perso->nomPerso . "', '" . time() . "')");
					break;

					case 6:
					$connexion->query("INSERT INTO inventaire VALUES('', '" . $_SESSION['id'] . "', '48', '1', '" . $_SESSION['pseudo'] . "', '" . $donnees_perso->nomPerso . "', '" . time() . "')");
					break;

					case 7:
					$connexion->query("INSERT INTO inventaire VALUES('', '" . $_SESSION['id'] . "', '49', '1', '" . $_SESSION['pseudo'] . "', '" . $donnees_perso->nomPerso . "', '" . time() . "')");
					break;

					case 8:
					$connexion->query("INSERT INTO inventaire VALUES('', '" . $_SESSION['id'] . "', '50', '1', '" . $_SESSION['pseudo'] . "', '" . $donnees_perso->nomPerso . "', '" . time() . "')");
					break;

				}


				$connexion->query('UPDATE personnages SET choixArme = ' . $choixArme . ' WHERE idPseudo = ' . $_SESSION['id'] . '');
				redirection('stats.php');
			}
			else
			avert('ERR_OUT_OF_RANGE');
		}
		else
		avert('ERR_EXPIRED');
	}


	echo '
	<h3>Choix de la spécialisation</h3>
	<div class="contenu">
	Veuillez choisir votre spécialisation. Vous pouvez par la suite le changer en activant un objet spécial donné dans le futur. Une arme de départ vous sera donné.

	<div class="separate"></div>
	<a href="stats.php?choixArme=1">L\'Épéiste</a><br />
	L\'épéiste ne peut pas utiliser de sorts. Son arme est l\'épée. Cette classe est orientée sur l\'équilibre entre les statistiques et les dégâts d\'arme. Peut utiliser les armes améliorées et enchantées.
	<br /><br />
	<b>+ 1 Épée de débutant</b><br />
	<b>+ 50% de points de vitalité offerts par point dépensé</b><br />
	<b>+ 125% de points de puissance offerts par point dépensé</b>
	<div class="separate"></div>


	<a href="stats.php?choixArme=2">Le Voleur</a><br />
	Le voleur ne peut pas utiliser de sorts. Son arme est la dague. Cette classe est plus efficace avec beaucoup d\'agilité. Ses dégâts sont basés sur la chance principalement. Peut utiliser les armes améliorées et enchantées.
	<br /><br />
	<b>+ 1 Dagues du débutant</b><br />
	<b>+ 20% de points de vitalité offerts par point dépensé</b><br />
	<b>+ 150% de points d\'agilité offerts par point dépensé</b>
	<div class="separate"></div>


	<a href="stats.php?choixArme=3">Le Sauvage</a><br />
	Le sauvage ne peut pas utiliser de sorts. Son arme est la hache à main. Cette classe utilise principalement la force pour être efficace. Ils sont aussi efficaces avec les armes qu\'au corps-à-corps. Peut utiliser les armes améliorées et enchantées.
	<br /><br />
	<b>+ 1 Hache du débutant</b><br />
	<b>+ 200% de points de force offerts par point dépensé</b>
	<div class="separate"></div>


	<a href="stats.php?choixArme=4">Le Barbare</a><br />
	Le barbare ne peut pas utiliser de sorts. Son arme est la hache d\'arme. Cette classe compte surtout sur la puissance des armes pour montrer de quoi il est capable. <b>Ne peut pas</b> utiliser d\'armes améliorés ou enchantés.
	<br /><br />
	<b>+ 1 Hache d\'arme du débutant</b><br />
	<b>+ 75% de points de vitalité offerts par point dépensé</b><br />
	<b>+ 100% de points de puissance offerts par point dépensé</b>
	<div class="separate"></div>


	<a href="stats.php?choixArme=5">L\'Élitiste</a><br />
	L\'élitiste ne peut pas utiliser de sorts. Son arme est l\'espadon. Cette classe est identique au barbare, seules les armes changent. Cependant, il possède un peu plus de vitalité que de force. <b>Ne peut pas</b> utiliser d\'armes améliorés ou enchantés.
	<br /><br />
	<b>+ 1 Espadon du débutant</b><br />
	<b>+ 100% de points de vitalité offerts par point dépensé</b><br />
	<b>+ 75% de points de puissance offerts par point dépensé</b>
	<div class="separate"></div>


	<a href="stats.php?choixArme=6">Le Sniper</a><br />
	Le sniper ne peut pas utiliser de sorts. Son arme est un arc. Il devra compter sur sa chance pour viser correctement... Peut utiliser des armes améliorés ou enchantés.
	<br /><br />
	<b>+ 1 Arc du débutant</b><br />
	<b>+ 50% de points de vitalité offerts par point dépensé</b><br />
	<b>+ 125% de points de chance offerts par point dépensé</b>
	<div class="separate"></div>


	<a href="stats.php?choixArme=7">Le Magicien</a><br />
	Le magicien peut utiliser des sorts. Son arme est un bâton. Adepte de la magie, il devra compter sur la puissance de son bâton pour survivre. Peut utiliser des armes améliorés ou enchantés.
	<br /><br />
	<b>+ 1 Bâton de débutant</b><br />
	<b>+ 100% de points de puissance offerts par point dépensé</b><br />
	<b>+ 60% de points d\'intelligence offerts par point dépensé</b>
	<div class="separate"></div>


	<a href="stats.php?choixArme=8">L\'Ange Gardien</a><br />
	L\'ange gardien peut utiliser des sorts. Son arme est une baguette. Aussi compétent que le magicien, cette classe est spécialisée dans les soins. Peut utiliser des armes améliorés ou enchantés.
	<br /><br />
	<b>+ 1 Baguette du débutant</b><br />
	<b>+ 50% de points de vitalité offerts par point dépensé</b><br />
	<b>+ 125% de points d\'intelligence offerts par point dépensé</b>
	</div>
	';

	include('pied.php');
	exit;


}



if(isset($_POST['addVita']))
{
	$vita = (int) $_POST['addVita'];
	$spendedVita = (int) $_POST['addVita'];

	if($vita > 0)
	{
		if($vita <= $donnees_perso->ptsCaracteristiques)
		{
			switch($donnees_perso->choixArme)
			{
				case 1:
				$boost_vita = $vita * 50 / 100;
				$vita = $vita + (int) $boost_vita;
				break;

				case 2:
				$boost_vita = $vita * 20 / 100;
				$vita = $vita + (int) $boost_vita;
				break;

				case 4:
				$boost_vita = $vita * 75 / 100;
				$vita = $vita + (int) $boost_vita;
				break;

				case 5:
				$boost_vita = $vita * 100 / 100;
				$vita = $vita + (int) $boost_vita;
				break;

				case 6:
				$boost_vita = $vita * 50 / 100;
				$vita = $vita + (int) $boost_vita;
				break;


				case 8:
				$boost_vita = $vita * 50 / 100;
				$vita = $vita + (int) $boost_vita;
				break;
			}


			$connexion->query('UPDATE personnages SET vitalite = (vitalite + ' . $vita . ') WHERE idPseudo = ' . $_SESSION['id']);
			$connexion->query('UPDATE personnages SET ptsCaracteristiques = (ptsCaracteristiques - ' . $spendedVita . ') WHERE idPseudo = ' . $_SESSION['id']);
			redirection('stats.php');
		}
		else
		{
			avert('Vous voulez dépenser plus de points que vous en avez.');
		}
	}
	else
	{
		avert('Impossible de donner une valeur nulle ou incorrecte.');
	}
}

if(isset($_POST['addForce']))
{
	$force = (int) $_POST['addForce'];
	$spendedForce = (int) $_POST['addForce'];

	if($force > 0)
	{
		if($force <= $donnees_perso->ptsCaracteristiques)
		{

			switch($donnees_perso->choixArme)
			{
				case 3:
				$boost_force = $force * 200 / 100;
				$force = $force + (int) $boost_force;
				break;
			}

			$connexion->query('UPDATE personnages SET c_force = (c_force + ' . $force . ') WHERE idPseudo = ' . $_SESSION['id']);
			$connexion->query('UPDATE personnages SET ptsCaracteristiques = (ptsCaracteristiques - ' . $spendedForce . ') WHERE idPseudo = ' . $_SESSION['id']);
			redirection('stats.php');
		}
		else
		{
			avert('Vous voulez dépenser plus de points que vous en avez.');
		}
	}
	else
	{
		avert('Impossible de donner une valeur nulle ou incorrecte.');
	}
}

if(isset($_POST['addIntel']))
{
	$intel = (int) $_POST['addIntel'];
	$spendedIntel = (int) $_POST['addIntel'];

	if($intel > 0)
	{
		if($intel <= $donnees_perso->ptsCaracteristiques)
		{

			switch($donnees_perso->choixArme)
			{
				case 7:
				$boost_intel = $intel * 60 / 100;
				$intel = $intel + (int) $boost_intel;
				break;

				case 8:
				$boost_intel = $intel * 125 / 100;
				$intel = $intel + (int) $boost_intel;
				break;
			}

			$connexion->query('UPDATE personnages SET intelligence = (intelligence + ' . $intel . ') WHERE idPseudo = ' . $_SESSION['id']);
			$connexion->query('UPDATE personnages SET ptsCaracteristiques = (ptsCaracteristiques - ' . $spendedIntel . ') WHERE idPseudo = ' . $_SESSION['id']);
			redirection('stats.php');
		}
		else
		{
			avert('Vous voulez dépenser plus de points que vous en avez.');
		}
	}
	else
	{
		avert('Impossible de donner une valeur nulle ou incorrecte.');
	}
}

if(isset($_POST['addPower']))
{
	$power = (int) $_POST['addPower'];
	$spendedPower = (int) $_POST['addPower'];

	if($power > 0)
	{
		if($power <= $donnees_perso->ptsCaracteristiques)
		{
			switch($donnees_perso->choixArme)
			{
				case 1:
				$boost_power = $power * 125 / 100;
				$power = $power + (int) $boost_power;
				break;

				case 4:
				$boost_power = $power * 100 / 100;
				$power = $power + (int) $boost_power;
				break;

				case 5:
				$boost_power = $power * 75 / 100;
				$power = $power + (int) $boost_power;
				break;

				case 7:
				$boost_power = $power * 100 / 100;
				$power = $power + (int) $boost_power;
				break;
			}

			$connexion->query('UPDATE personnages SET puissance = (puissance + ' . $power . ') WHERE idPseudo = ' . $_SESSION['id']);
			$connexion->query('UPDATE personnages SET ptsCaracteristiques = (ptsCaracteristiques - ' . $spendedPower . ') WHERE idPseudo = ' . $_SESSION['id']);
			redirection('stats.php');
		}
		else
		{
			avert('Vous voulez dépenser plus de points que vous en avez.');
		}
	}
	else
	{
		avert('Impossible de donner une valeur nulle ou incorrecte.');
	}
}

if(isset($_POST['addAgi']))
{
	$agi = (int) $_POST['addAgi'];
	$spendedAgi = (int) $_POST['addAgi'];

	if($agi > 0)
	{
		if($agi <= $donnees_perso->ptsCaracteristiques)
		{
			switch($donnees_perso->choixArme)
			{
				case 2:
				$boost_agi = $agi * 150 / 100;
				$agi = $agi + (int) $boost_agi;
				break;
			}

			$connexion->query('UPDATE personnages SET agilite = (agilite + ' . $agi . ') WHERE idPseudo = ' . $_SESSION['id']);
			$connexion->query('UPDATE personnages SET ptsCaracteristiques = (ptsCaracteristiques - ' . $spendedAgi . ') WHERE idPseudo = ' . $_SESSION['id']);
			redirection('stats.php');
		}
		else
		{
			avert('Vous voulez dépenser plus de points que vous en avez.');
		}
	}
	else
	{
		avert('Impossible de donner une valeur nulle ou incorrecte.');
	}
}

if(isset($_POST['addChance']))
{
	$chance = (int) $_POST['addChance'];
	$spendedChance = (int) $_POST['addChance'];

	if($chance > 0)
	{
		if($chance <= $donnees_perso->ptsCaracteristiques)
		{
			switch($donnees_perso->choixArme)
			{
				case 6:
				$boost_chance = $chance * 125 / 100;
				$chance = $chance + (int) $boost_chance;
				break;
			}

			$connexion->query('UPDATE personnages SET chance = (chance + ' . $chance . ') WHERE idPseudo = ' . $_SESSION['id']);
			$connexion->query('UPDATE personnages SET ptsCaracteristiques = (ptsCaracteristiques - ' . $spendedChance . ') WHERE idPseudo = ' . $_SESSION['id']);
			redirection('stats.php');
		}
		else
		{
			avert('Vous voulez dépenser plus de points que vous en avez.');
		}
	}
	else
	{
		avert('Impossible de donner une valeur nulle ou incorrecte.');
	}
}

switch($donnees_perso->choixArme)
{
	case 1:
	$specialisation = ', <b>épéiste</b>';
	$bonus = '<span style="color: #4f0082; font-size: 16pt;">VITALITÉ : <b>+50%</b><br /> PUISSANCE : <b>+125%</b></span>';
	break;

	case 2:
	$specialisation = ', <b>voleur</b>';
	$bonus = '<span style="color: #4f0082; font-size: 16pt;">VITALITÉ : <b>+20%</b><br /> AGILITÉ : <b>+150%</b></span>';
	break;

	case 3:
	$specialisation = ', <b>sauvage</b>';
	$bonus = '<span style="color: #4f0082; font-size: 16pt;">FORCE : <b>+200%</b><br /></span>';
	break;

	case 4:
	$specialisation = ', <b>barbare</b>';
	$bonus = '<span style="color: #4f0082; font-size: 16pt;">VITALITÉ : <b>+75%</b><br /> PUISSANCE : <b>+100%</b></span>';
	break;

	case 5:
	$specialisation = ', <b>élitiste</b>';
	$bonus = '<span style="color: #4f0082; font-size: 16pt;">VITALITÉ : <b>+100%</b><br /> PUISSANCE : <b>+75%</b></span>';
	break;

	case 6:
	$specialisation = ', <b>sniper</b>';
	$bonus = '<span style="color: #4f0082; font-size: 16pt;">VITALITÉ : <b>+50%</b><br /> CHANCE : <b>+125%</b></span>';
	break;

	case 7:
	$specialisation = ', <b>magicien</b>';
	$bonus = '<span style="color: #4f0082; font-size: 16pt;">PUISSANCE : <b>+100%</b><br />INTELLIGENCE : <b>+60%</b></span>';
	break;

	case 8:
	$specialisation = ', <b>ange gardien</b>';
	$bonus = '<span style="color: #4f0082; font-size: 16pt;">VITALITÉ : <b>+50%</b><br />INTELLIGENCE : <b>+125%</b></span>';
	break;

	default:
	$specialisation = '';
}

$r_donnees_membre = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $_SESSION['id'] . '');
$r_donnees_membre->execute();
$donnees_membre = $r_donnees_membre->fetch(PDO::FETCH_OBJ);

if($donnees_membre->prestige > 0)
{
	$reborn = ', <span style="font-size: 16pt; color: #ff4b4b;">REBORN NIVEAU ' . $donnees_membre->prestige . '</span>';
}
else
{
	$reborn = '';
}

echo '

<h3></h3>
<div class="contenu">
<span style="float: left; margin-right: 15px;"><img style="border: 1px solid #9e9e9e;" src="' . $donnees_membre->avatar . '" width="190" height="190" /></span>

<span style="font-size: 22pt;">' . htmlspecialchars($donnees_perso->nomPerso) . $specialisation . '</span><br />
<span style="font-size: 16pt;"><b>NIVEAU ' . $donnees_membre->niveau . '</b></span>
' . $reborn . '<br /><br /><br />

<span style="font-size: 12pt;">BONUS DE CLASSE :</span><br />
' . $bonus . '<br /><br /><br />

<table style="width: 48%; float: left;">

	<tr>
		<th></th>
		<th></th>
	</tr>

	<tr>
		<td>Vie</td>
		<td style="font-weight: bold;">' . number_format($sante) . ' / ' . number_format($sante) . '</td>
	</tr>

	<tr>
		<td>Attaque au corps-à-corps</td>
		<td style="font-weight: bold;">' . (int) $attaqueFront . ' (x' . $max_atk_fists . ')</td>
	</tr>

	<tr>
		<td>Bonus de dégâts à l\'arme (%)</td>
		<td style="font-weight: bold;">' . (int) $percent_atk_weapon . '% ( P / ' . $diviseur_percent . ' - x' . $max_atk_weapon . ')</td>
	</tr>

	<tr>
		<td>Défense</td>
		<td style="font-weight: bold;">' . (int) $defense . '</td>
	</tr>

	<tr>
		<td>Soins</td>
		<td style="font-weight: bold;">' . (int) $soin_min . ' à ' . (int) $soin_max . ' PV (x' . $max_heal_peer . ')</td>
	</tr>

	<tr>
		<td>Esquive (%)</td>
		<td style="font-weight: bold;">' . (int) $esquive . '%</td>
	</tr>

	<tr>
		<td>Coup critique</td>
		<td style="font-weight: bold;">1 chance sur ' . (int) $realCoupCritique . '</td>
	</tr>

	<tr>
		<td>Multiplicateur de dégâts si CC (%)</td>
		<td style="font-weight: bold;">' . $perkCC_damageMultiplier . '%</td>
	</tr>

	<tr>
		<td>Indice de courage</td>
		<td style="font-weight: bold;">' . $startup_turn_peer . '</td>
	</tr>

</table>

<table style="width: 48%; float: right;">

<tr>
		<th></th>
		<th></th>
	</tr>

	<tr>
		<td>EXP par post</td>
		<td style="font-weight: bold;">' . (int) $EXP_post . ' EXP</td>
	</tr>

	<tr>
		<td>EXP par topic</td>
		<td style="font-weight: bold;">' . (int) $EXP_topic . ' EXP</td>
	</tr>

	<tr>
		<td>Temps entre chaque posts</td>
		<td style="font-weight: bold;">' . (int) $temps_chaque_post . ' secondes</td>
	</tr>

	<tr>
		<td>Temps entre chaque topics</td>
		<td style="font-weight: bold;">' . (int) $temps_chaque_topic . ' secondes</td>
	</tr>

	<tr>
		<td>Chances de drop</td>
		<td style="font-weight: bold;">1 chance sur ' . (int) $drop_range . '</td>
	</tr>

	<tr>
		<td>Objets max. dans votre sac</td>
		<td style="font-weight: bold;">' . (int) $items_bag . '</td>
	</tr>

	<tr>
		<td>Coût du mode Reborn</td>
		<td style="font-weight: bold;">' . number_format($prestige_cost) . ' EC</td>
	</tr>

	<tr>
		<td> </td>
		<td> </td>
	</tr>
	<tr>
		<td> </td>
		<td> </td>
	</tr>



</table>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

<div class="separate"></div>
<span style="font-size: 16pt; font-weight: bold;">Caractéristiques</span> <span style="font-size: 16pt; font-weight: bold; float: right;"><label>Points dispo :</label>			' . $donnees_perso->ptsCaracteristiques . '</span>
<div class="separate"></div><br />

<form method="post">

<table style="width: 100%;">
<tr>
	<th width="5%"></th>
	<th width="60%"></th>
	<th width="10%">Points</th>
	<th width="10%">+</th>
</tr>

<tr>
	<td><img src="images/caracteristiques/vie.png" height="40" width="40" /></td>
	<td style="text-align: left; font-size: 16px; font-weight: bold;">Vitalité</td>
	<td style="font-weight: bold;">' . number_format($donnees_perso->vitalite) . '</td>
	<td><input type="text" name="addVita" style="width:40px;"> <input type="submit" value="+" style="min-width: 10px;"></td>
</tr>

</form>
<form method="post">

<tr>
	<td><img src="images/caracteristiques/force.png" height="40" width="40" /></td>
	<td style="text-align: left; font-size: 16px; font-weight: bold;">Force</td>
	<td style="font-weight: bold;">' . number_format($donnees_strengh) . '</td>
	<td><input type="text" name="addForce" style="width:40px;"> <input type="submit" value="+" style="min-width: 10px;"></td>
</tr>
</form>
<form method="post">

<tr>
	<td><img src="images/caracteristiques/intelligence.png" height="40" width="40" /></td>
	<td style="text-align: left; font-size: 16px; font-weight: bold;">Intelligence</td>
	<td style="font-weight: bold;">' . number_format($donnees_intel) . '</td>
	<td><input type="text" name="addIntel" style="width:40px;"> <input type="submit" value="+" style="min-width: 10px;"></td>
</tr>
</form>

<form method="post">


<tr>
	<td><img src="images/caracteristiques/puissance.png" height="40" width="40" /></td>
	<td style="text-align: left; font-size: 16px; font-weight: bold;">Puissance</td>
	<td style="font-weight: bold;">' . number_format($donnees_puissance) . '</td>
	<td><input type="text" name="addPower" style="width:40px;"> <input type="submit" value="+" style="min-width: 10px;"></td>
</tr>

</form>
<form method="post">
<tr>
	<td><img src="images/caracteristiques/agilite.png" height="40" width="40" /></td>
	<td style="text-align: left; font-size: 16px; font-weight: bold;">Agilité</td>
	<td style="font-weight: bold;">' . number_format($donnees_agi) . '</td>
	<td><input type="text" name="addAgi" style="width:40px;"> <input type="submit" value="+" style="min-width: 10px;"></td>
</tr>
</form>
<form method="post">

<tr>
	<td><img src="images/caracteristiques/chance.png" height="40" width="40" /></td>
	<td style="text-align: left; font-size: 16px; font-weight: bold;">Chance</td>
	<td style="font-weight: bold;">' . number_format($donnees_chance) . '</td>
	<td><input type="text" name="addChance" style="width:40px;"> <input type="submit" value="+" style="min-width: 10px;"></td>
</tr>

</form>

</table>
<br />

<a href="http://localhost/aide.php#guide3">En savoir plus sur les caractéristiques</a>
</div>


';

include('pied.php');
?>
