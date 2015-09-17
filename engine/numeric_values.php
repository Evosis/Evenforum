<?php

$EXP_post = 100;
$EXP_topic = 150;

$EC_post = rand(5,20);
$EC_topic = rand(10,35);

$temps_chaque_post = 30;
$temps_chaque_topic = 150;

$drop_range = 800;
$perkDrop = 0; // skill

$items_bag = 25;

$p_sante = 100;

$attaqueFront = 8;
$defense = 0;

$percent_atk_weapon = 0;
$diviseur_percent = 1.50;

$esquive = 10;
$perkEsquive = 0; // skill
$coup_critique = 1;
$perkCC = 0; // skill
$perkCC_damageMultiplier = 115; // skill 115 %

$soin_min = 2;
$soin_max = 10;

$scythe = 0;

$bonusPointCarac = 0;

$prestige_cost = 200000;

$max_heal_peer = 1;
$max_atk_weapon = 1;
$max_atk_fists = 1;
$max_obj_uses = 1;
$max_escape_attempt = 1;

$vita_per_level = 20;

$startup_turn_peer = 0;





if(isset($_SESSION['pseudo']))
{
	$countPerso = $connexion->query('SELECT COUNT(*) FROM personnages WHERE idPseudo = ' . $_SESSION['id'])->fetchColumn();

	if($countPerso > 0)
	{
		$perso = true;
	}
	else
	{
		$perso = false;
	}

	if($perso == true)
	{

		$r_donnees_perso = $connexion->prepare('SELECT * FROM personnages WHERE idPseudo = ' . $_SESSION['id']);
		$r_donnees_perso->execute();
		$donnees_perso = $r_donnees_perso->fetch(PDO::FETCH_OBJ);

		$r_donnees_membres = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $_SESSION['id']);
		$r_donnees_membres->execute();
		$donnees_membres = $r_donnees_membres->fetch(PDO::FETCH_OBJ);

		$donnees_intel = $donnees_perso->intelligence;
		$donnees_strengh = $donnees_perso->c_force;
		$donnees_chance = $donnees_perso->chance;
		$donnees_puissance = $donnees_perso->puissance;
		$donnees_agi = $donnees_perso->agilite;


			for ($i = 1; $i <= 23; $i++) {

				$count_perk[$i] = $connexion->query('SELECT COUNT(*) FROM competences WHERE idComp = ' . $i . ' AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

				if($count_perk[$i] > 0)
				{
					$r_donnees_comp[$i] = $connexion->prepare('SELECT * FROM competences WHERE idPseudo = ' . $_SESSION['id'] . ' AND idComp = ' . $i . '');
					$r_donnees_comp[$i]->execute();
					$donnees_comp[$i] = $r_donnees_comp[$i]->fetch(PDO::FETCH_OBJ);
				}

			}

			if($count_perk[1] == 1)
			{
				switch($donnees_comp[1]->niveau)
				{
					case 1:
					$boost_soins = $soin_min * 5 / 100;
					$soin_min = $soin_min + $boost_soins;

					$boost_soins2 = $soin_max * 5 / 100;
					$soin_max = $soin_max + $boost_soins2;
					break;

					case 2:
					$boost_soins = $soin_min * 14 / 100;
					$soin_min = $soin_min + $boost_soins;

					$boost_soins2 = $soin_max * 14 / 100;
					$soin_max = $soin_max + $boost_soins2;
					break;

					case 3:
					$boost_soins = $soin_min * 28 / 100;
					$soin_min = $soin_min + $boost_soins;

					$boost_soins2 = $soin_max * 5 / 100;
					$soin_max = $soin_max + $boost_soins2;
					break;

					case 4:
					$boost_soins = $soin_min * 50 / 100;
					$soin_min = $soin_min + $boost_soins;

					$boost_soins2 = $soin_max * 5 / 100;
					$soin_max = $soin_max + $boost_soins2;
					break;

				}
			}

			if($count_perk[2] == 1)
			{
				switch($donnees_comp[2]->niveau)
				{
					case 1:
					$boost_exp1 = $EXP_post * 7 / 100;
					$EXP_post = $EXP_post + $boost_exp1;

					$boost_exp2 = $EXP_topic * 7 / 100;
					$EXP_topic = $EXP_topic + $boost_exp2;
					break;

					case 2:
					$boost_exp1 = $EXP_post * 20 / 100;
					$EXP_post = $EXP_post + $boost_exp1;

					$boost_exp2 = $EXP_topic * 20 / 100;
					$EXP_topic = $EXP_topic + $boost_exp2;
					break;

					case 3:
					$boost_exp1 = $EXP_post * 60 / 100;
					$EXP_post = $EXP_post + $boost_exp1;

					$boost_exp2 = $EXP_topic * 60 / 100;
					$EXP_topic = $EXP_topic + $boost_exp2;
					break;

					case 4:
					$boost_exp1 = $EXP_post * 2;
					$EXP_post = $EXP_post + $boost_exp1;

					$boost_exp2 = $EXP_topic * 2;
					$EXP_topic = $EXP_topic + $boost_exp2;
					break;

				}
			}

			if($count_perk[3] == 1)
			{
				switch($donnees_comp[3]->niveau)
				{
					case 1:
					$p_sante = $p_sante + 100;
					break;

					case 2:
					$p_sante = $p_sante + 250;
					break;

					case 3:
					$p_sante = $p_sante + 500;
					break;

					case 4:
					$p_sante = $p_sante + 1250;
					break;

				}
			}


			if($count_perk[4] == 1)
			{
				switch($donnees_comp[4]->niveau)
				{
					case 1:
					$boost_ec = $addedVita * 20 / 100;
					$addedVita = $addedVita + $boost_ec;
					break;

					case 2:
					$boost_ec = $addedVita * 55 / 100;
					$addedVita = $addedVita + $boost_ec;
					break;

					case 3:
					$boost_ec = $addedVita * 85 / 100;
					$addedVita = $addedVita + $boost_ec;
					break;

					case 4:
					$boost_ec = $addedVita * 150 / 100;
					$addedVita = $addedVita + $boost_ec;
					break;

				}
			}

			if($count_perk[5] == 1)
			{
				switch($donnees_comp[5]->niveau)
				{
					case 1:
					$items_bag = $items_bag + 3;
					break;

					case 2:
					$items_bag = $items_bag + 7;
					break;

					case 3:
					$items_bag = $items_bag + 20;
					break;

					case 4:
					$items_bag = $items_bag + 50;
					break;

				}
			}

			if($count_perk[6] == 1)
			{
				switch($donnees_comp[6]->niveau)
				{
					case 1:
					$boost_cac = $attaqueFront * 35 / 100;
					$attaqueFront = $attaqueFront + $boost_cac;
					break;

					case 2:
					$boost_cac = $attaqueFront * 75 / 100;
					$attaqueFront = $attaqueFront + $boost_cac;
					break;

					case 3:
					$boost_cac = $attaqueFront * 150 / 100;
					$attaqueFront = $attaqueFront + $boost_cac;
					$max_atk_fists = 2;
					break;

					case 4:
					$boost_cac = $attaqueFront * 300 / 100;
					$attaqueFront = $attaqueFront + $boost_cac;
					$max_atk_fists = 2;
					break;

				}
			}


			if($count_perk[7] == 1)
			{
				switch($donnees_comp[7]->niveau)
				{
					case 1:
					$boost_force = $donnees_strengh * 3 / 100;
					$donnees_strengh = $donnees_strengh + $boost_force;
					break;

					case 2:
					$boost_force = $donnees_strengh * 8 / 100;
					$donnees_strengh = $donnees_strengh + $boost_force;
					break;

					case 3:
					$boost_force = $donnees_strengh * 18 / 100;
					$donnees_strengh = $donnees_strengh + $boost_force;
					break;

					case 4:
					$boost_force = $donnees_strengh * 40 / 100;
					$donnees_strengh = $donnees_strengh + $boost_force;
					break;

				}
			}


			if($count_perk[8] == 1)
			{
				switch($donnees_comp[8]->niveau)
				{
					case 1:
					$boost_intel = $donnees_intel * 3 / 100;
					$donnees_intel = $donnees_intel + $boost_intel;
					break;

					case 2:
					$boost_intel = $donnees_intel * 8 / 100;
					$donnees_intel = $donnees_intel + $boost_intel;
					break;

					case 3:
					$boost_intel = $donnees_intel * 18 / 100;
					$donnees_intel = $donnees_intel + $boost_intel;
					break;

					case 4:
					$boost_intel = $donnees_intel * 40 / 100;
					$donnees_intel = $donnees_intel + $boost_intel;
					break;
				}
			}


			if($count_perk[9] == 1)
			{
				switch($donnees_comp[9]->niveau)
				{
					case 1:
					$diviseur_percent = 1.43;
					break;

					case 2:
					$diviseur_percent = 1.35;
					break;

					case 3:
					$diviseur_percent = 1.25;
					break;

					case 4:
					$diviseur_percent = 1.10;
					break;
				}
			}

			if($count_perk[10] == 1)
			{
				switch($donnees_comp[10]->niveau)
				{
					case 1:
					$boost_power = $donnees_puissance * 3 / 100;
					$donnees_puissance = $donnees_puissance + $boost_power;
					break;

					case 2:
					$boost_power = $donnees_puissance * 8 / 100;
					$donnees_puissance = $donnees_puissance + $boost_power;
					break;

					case 3:
					$boost_power = $donnees_puissance * 18 / 100;
					$donnees_puissance = $donnees_puissance + $boost_power;
					break;

					case 4:
					$boost_power = $donnees_puissance * 40 / 100;
					$donnees_puissance = $donnees_puissance + $boost_power;
					break;

				}
			}


			if($count_perk[11] == 1)
			{
				switch($donnees_comp[11]->niveau)
				{
					case 1:
					$perkEsquive = 2;
					break;

					case 2:
					$perkEsquive = 4;
					break;

					case 3:
					$perkEsquive = 8;
					break;

					case 4:
					$perkEsquive = 13;
					break;

				}
			}

			if($count_perk[12] == 1)
			{
				switch($donnees_comp[12]->niveau)
				{
					case 1:
					$boost_agi = $donnees_agi * 3 / 100;
					$donnees_agi = $donnees_agi + $boost_agi;
					break;

					case 2:
					$boost_agi = $donnees_agi * 8 / 100;
					$donnees_agi = $donnees_agi + $boost_agi;
					break;

					case 3:
					$boost_agi = $donnees_agi * 18 / 100;
					$donnees_agi = $donnees_agi + $boost_agi;
					break;

					case 4:
					$boost_agi = $donnees_agi * 40 / 100;
					$donnees_agi = $donnees_agi + $boost_agi;
					break;

				}
			}


			if($count_perk[13] == 1)
			{
				switch($donnees_comp[13]->niveau)
				{
					case 1:
					$perkCC = 2;
					break;

					case 2:
					$perkCC = 4;
					break;

					case 3:
					$perkCC = 7;
					break;

					case 4:
					$perkCC = 10;
					break;

				}
			}

			if($count_perk[14] == 1)
			{
				switch($donnees_comp[14]->niveau)
				{
					case 1:
					$perkDrop = 50;
					break;

					case 2:
					$perkDrop = 100;
					break;

					case 3:
					$perkDrop = 175;
					break;

					case 4:
					$perkDrop = 300;
					break;

				}
			}

			if($count_perk[15] == 1)
			{
				switch($donnees_comp[15]->niveau)
				{
					case 1:
					$boost_chance = $donnees_chance * 3 / 100;
					$donnees_chance = $donnees_chance + $boost_chance;
					break;

					case 2:
					$boost_chance = $donnees_chance * 8 / 100;
					$donnees_chance = $donnees_chance + $boost_chance;
					break;

					case 3:
					$boost_chance = $donnees_chance * 18 / 100;
					$donnees_chance = $donnees_chance + $boost_chance;
					break;

					case 4:
					$boost_chance = $donnees_chance * 40 / 100;
					$donnees_chance = $donnees_chance + $boost_chance;
					break;

				}
			}

			if($count_perk[16] == 1)
			{
				$scythe = 2;
			}

			if($count_perk[17] == 1)
			{
				switch($donnees_comp[17]->niveau)
				{
					case 1:
					$bonusPointCarac = 2;
					break;

					case 2:
					$bonusPointCarac = 4;
					break;

					case 3:
					$bonusPointCarac = 6;
					break;

					case 4:
					$bonusPointCarac = 8;
					break;

				}
			}

			if($count_perk[18] == 1)
			{
				switch($donnees_comp[18]->niveau)
				{
					case 1:
					$skillDef = 5;
					break;

					case 2:
					$skillDef = 10;
					break;

					case 3:
					$skillDef = 18;
					break;

					case 4:
					$skillDef = 30;
					break;

				}
			}

			if($count_perk[19] == 1)
			{
				switch($donnees_comp[19]->niveau)
				{
					case 1:
					$temps_chaque_post = $temps_chaque_post - 3;
					$temps_chaque_topic = $temps_chaque_topic - 8;
					break;

					case 2:
					$temps_chaque_post = $temps_chaque_post - 8;
					$temps_chaque_topic = $temps_chaque_topic - 15;
					break;

					case 3:
					$temps_chaque_post = $temps_chaque_post - 15;
					$temps_chaque_topic = $temps_chaque_topic - 30;
					break;

					case 4:
					$reduce_temps_post = $temps_chaque_post * 50 / 100;
					$reduce_temps_topic = $temps_chaque_topic * 50 / 100;

					$temps_chaque_post = $temps_chaque_post - $reduce_temps_post;
					$temps_chaque_topic = $temps_chaque_topic - $reduce_temps_topic;
					break;

				}
			}
			if($count_perk[20] == 1)
			{
				switch($donnees_comp[20]->niveau)
				{
					case 1:
					$prestige_cost = $prestige_cost - 15000;
					break;

					case 2:
					$prestige_cost = $prestige_cost - 30000;
					break;

					case 3:
					$prestige_cost = $prestige_cost - 60000;
					break;

					case 4:
					$prestige_cost = $prestige_cost - 125000;
					break;
				}
			}
			if($count_perk[21] == 1)
			{
				switch($donnees_comp[21]->niveau)
				{
					case 1:
					$vita_per_level = $vita_per_level + 2;
					break;

					case 2:
					$vita_per_level = $vita_per_level + 4;
					break;

					case 3:
					$vita_per_level = $vita_per_level + 8;
					break;

					case 4:
					$vita_per_level = $vita_per_level + 15;
					break;
				}
			}
			if($count_perk[22] == 1)
			{
				switch($donnees_comp[22]->niveau)
				{
					case 1:
					$max_heal_peer = 2;
					break;

					case 2:
					$max_heal_peer = 3;
					break;

					case 3:
					$max_heal_peer = 4;
					break;

					case 4:
					$max_heal_peer = 5;
					break;
				}
			}
			if($count_perk[23] == 1)
			{
				switch($donnees_comp[23]->niveau)
				{
					case 1:
					$max_atk_weapon = 2;
					break;

					case 2:
					$percent_atk_weapon += 50;
					$max_atk_weapon = 2;
					break;

					case 3:
					$max_atk_weapon = 3;
					break;

					case 4:
					$percent_atk_weapon += 100;
					$max_atk_weapon = 3;
					break;
				}
			}


		$addedIntel = $donnees_intel * 2;
		$addedVita = $donnees_perso->vitalite * 2;
		$addedVie = $donnees_perso->vitalite;
		$addedAgi = (int) $donnees_agi / 10;
		$addedStrengh = (int) $donnees_strengh / 10;
		$addedChance = $donnees_chance;
		$addedAttaqueFront = (int) $donnees_strengh / 2;
		$addedPercentAtkWeapon = $donnees_puissance / $diviseur_percent;
		$addedDefense = (int) $donnees_strengh / 4;
		$addedEsquive = (int) $donnees_agi / 7;
		$addedCoupCritique = (int) $donnees_chance / 7;
		$addedMultiplierCC = (int) $donnees_puissance / 6;
		$addedSoinsMin = (int) $donnees_intel / 5;
		$addedSoinsMax = (int) $donnees_intel / 3;
		$addedStartupTurn = (int) $donnees_agi + (int) $donnees_intel + (int) $donnees_chance + (int) $donnees_strengh + (int) $donnees_puissance;






		$sante = (int) $p_sante + (int) $addedVie;
		$attaqueFront = (int) $attaqueFront + (int) $addedAttaqueFront;
		$defense = (int) $defense + (int) $addedDefense + $skillDef;
		$percent_atk_weapon = (int) $percent_atk_weapon + (int) $addedPercentAtkWeapon;
		$perkCC_damageMultiplier = (int) $perkCC_damageMultiplier + (int) $addedMultiplierCC;

		$soin_min = (int) $soin_min + (int) $addedSoinsMin;
		$soin_max = (int) $soin_max + (int) $addedSoinsMax;

		$esquive = (int) $esquive + (int) $addedEsquive + $perkEsquive;
		$coup_critique = (int) $coup_critique + (int) $addedCoupCritique + $perkCC;

		$startup_turn_peer = (int) $startup_turn_peer + (int) $addedStartupTurn;


		if($coup_critique >= 98)
		{
			$coup_critique = 98;
		}

		$realCoupCritique = 100 - $coup_critique;

		$EXP_post = $EXP_post + $addedIntel;
		$EXP_topic = $EXP_topic + $addedIntel;

		$EC_post = $EC_post + $addedVita;
		$EC_topic = $EC_topic + $addedVita;

		$temps_chaque_topic = $temps_chaque_topic - $addedAgi;
		$temps_chaque_post = $temps_chaque_post - $addedAgi;

		$drop_range = $drop_range - $addedChance - $perkDrop;

		$items_bag = (int) $items_bag + (int) $addedStrengh;


		$drop_engine = rand(0, $drop_range);

		if($temps_chaque_post <= 10)
		{
			$temps_chaque_post = 10;
		}

		if($drop_range <= 300)
		{
			$drop_range = 300;
		}

		if($temps_chaque_topic <= 60)
		{
			$temps_chaque_topic = 60;
		}

		if($esquive >= 65)
		{
			$esquive = 65;
		}

		if($attaque_min < 0)
		{
			$attaque_min = 0;
		}

	}
}



?>
