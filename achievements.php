<?php
include('base.php');
include('tete.php');

siMembre();

$r_donnees_ach = $connexion->query('SELECT * FROM achievements WHERE idPseudo = ' . $_SESSION['id']);
$r_donnees_ach->execute();
$donnees_ach = $r_donnees_ach->fetch(PDO::FETCH_OBJ);

$nbAchs = $connexion->query('SELECT COUNT(*) FROM achievements WHERE idPseudo = ' . $_SESSION['id'])->fetchColumn();
$possede = 0;


for ($i = 1; $i <= 58; $i++) {

	/*if($achievement[$i]['hidden'] == false)
	{

	}*/

	$r_donnees_ach = $connexion->query('SELECT * FROM achievements WHERE idPseudo = ' . $_SESSION['id']);
	$r_donnees_ach->execute();
	$donnees_ach = $r_donnees_ach->fetch(PDO::FETCH_OBJ);


	$unlocked_ach[$i] = $connexion->query('SELECT COUNT(*) FROM achievements WHERE idAchievement = ' . $i . ' AND idPseudo = ' . $_SESSION['id'])->fetchColumn(); 

	/*$timestamp = $donnees_ach->timestamp;
	$mois_fr = array('', 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
	list($jour, $mois, $annee) = explode('/', date('d/n/Y', $timestamp));
	$unlocked_le[$i] = $jour . ' ' . $mois_fr[$mois] . ' ' . $annee . ' à ' . date('H\ : i\ : s', $timestamp);*/


	if($unlocked_ach[$i] == 0)
	{
		$texte_lock[$i] = '<span style="float: right; color: red; font-weight: bold; font-size: 12pt;">Verrouillé</span>';
		$icon_style[$i] = 0;
	}
	else
	{
		$texte_lock[$i] = '<span style="float: right; font-weight: bold; font-size: 12pt;">Déverrouillé !</span>';
		$icon_style[$i] = 1;
	}

}

$progress_ach = (int) $nbAchs * 100 / 58;

if($donnees_membres->prestige > 0)
{
	$value_progress_niveau10 = 10;
	$value_progress_niveau26 = 26;
	$value_progress_niveau51 = 51;
	$value_progress_niveau76 = 76;
	$value_progress_niveau100 = 100;
}
else
{
	$value_progress_niveau10 = $donnees_membres->niveau;
	$value_progress_niveau26 = $donnees_membres->niveau;
	$value_progress_niveau51 = $donnees_membres->niveau;
	$value_progress_niveau76 = $donnees_membres->niveau;
	$value_progress_niveau100 = $donnees_membres->niveau;
}

	$membredepuis = ceil((time() - $donnees_membres->timestamp) / 60 / 60 / 24);
	$membredepuis = number_format($membredepuis, 0, '', ',');


echo '


<h3>Succès</h3>
<div class="contenu">
Voici vos succès (ou achievements en anglais). Réalisez une tâche précise pour remporter le succès !<br /><br />

<center><span style="font-size: 18pt; font-weight: bold;"><img src="images/notifications/defis.png" width="25" height="25" /> ' . $nbAchs . ' / 58</span></center><br />
<center><span style="font-size: 12pt;">' . (int) $progress_ach . '% terminé</span></center>
</div>
<br />

<div class="contenu" id="accordion">

<h3><b>Quête principale : quest_name</b></h3>
<div class="contenu">

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_main_quest1/teaser_' . $icon_style[44] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . stripslashes($achievement[44]['nom']) . $texte_lock[44] . '</span><br />
' . $achievement[44]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_main_quest1/teaser_' . $icon_style[45] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . stripslashes($achievement[45]['nom']) . $texte_lock[45] . '</span><br />
' . $achievement[45]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_main_quest1/teaser_' . $icon_style[46] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . stripslashes($achievement[46]['nom']) . $texte_lock[46] . '</span><br />
' . $achievement[46]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_main_quest1/teaser_' . $icon_style[47] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . stripslashes($achievement[47]['nom']) . $texte_lock[47] . '</span><br />
' . $achievement[47]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_main_quest1/teaser_' . $icon_style[48] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . stripslashes($achievement[48]['nom']) . $texte_lock[48] . '</span><br />
' . $achievement[48]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_main_quest1/teaser_' . $icon_style[49] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . stripslashes($achievement[49]['nom']) . $texte_lock[49] . '</span><br />
' . $achievement[49]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_main_quest1/teaser_' . $icon_style[50] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . stripslashes($achievement[50]['nom']) . $texte_lock[50] . '</span><br />
' . $achievement[50]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_main_quest1/teaser_' . $icon_style[51] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . stripslashes($achievement[51]['nom']) . $texte_lock[51] . '</span><br />
' . $achievement[51]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_main_quest1/teaser_' . $icon_style[52] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . stripslashes($achievement[52]['nom']) . $texte_lock[52] . '</span><br />
' . $achievement[52]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_main_quest1/teaser_' . $icon_style[53] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . stripslashes($achievement[53]['nom']) . $texte_lock[53] . '</span><br />
' . $achievement[53]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_main_quest1/teaser_' . $icon_style[54] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . stripslashes($achievement[54]['nom']) . $texte_lock[54] . '</span><br />
' . $achievement[54]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_main_quest1/teaser_' . $icon_style[55] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . stripslashes($achievement[55]['nom']) . $texte_lock[55] . '</span><br />
' . $achievement[55]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_main_quest1/teaser_' . $icon_style[56] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . stripslashes($achievement[56]['nom']) . $texte_lock[56] . '</span><br />
' . $achievement[56]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_main_quest1/teaser_' . $icon_style[57] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . stripslashes($achievement[57]['nom']) . $texte_lock[57] . '</span><br />
' . $achievement[57]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_main_quest1/teaser_' . $icon_style[58] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . stripslashes($achievement[58]['nom']) . $texte_lock[58] . '</span><br />
' . $achievement[58]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>


</div>



<h3>Catégorie du forumeur</h3>
<div class="contenu">

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_forum_package/messages1_' . $icon_style[31] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[31]['nom'] . $texte_lock[31] . '</span><br />
' . stripslashes($achievement[31]['dp']) . '<br /><br /><br />

<progress value="' . $count_messages . '" max="1"></progress> <b>' . $count_messages . ' / 1</b><br />


<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_forum_package/messages2_' . $icon_style[32] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[32]['nom'] . $texte_lock[32] . '</span><br />
' . $achievement[32]['dp'] . '<br /><br /><br />
<progress value="' . $count_messages . '" max="100"></progress> <b>' . $count_messages . ' / 100</b><br />


<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_forum_package/messages3_' . $icon_style[33] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[33]['nom'] . $texte_lock[33] . '</span><br />
' . $achievement[33]['dp'] . '<br /><br /><br />
<progress value="' . $count_messages . '" max="1000"></progress> <b>' . $count_messages . ' / 1,000</b><br />


<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_forum_package/messages4_' . $icon_style[34] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[34]['nom'] . $texte_lock[34] . '</span><br />
' . $achievement[34]['dp'] . '<br /><br /><br />
<progress value="' . $count_messages . '" max="5000"></progress> <b>' . $count_messages . ' / 5,000</b><br />


<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_forum_package/messages5_' . $icon_style[35] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[35]['nom'] . $texte_lock[35] . '</span><br />
' . $achievement[35]['dp'] . '<br /><br /><br />
<progress value="' . $count_messages . '" max="20000"></progress> <b>' . $count_messages . ' / 20,000</b><br />


<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_forum_package/messages6_' . $icon_style[36] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[36]['nom'] . $texte_lock[36] . '</span><br />
' . $achievement[36]['dp'] . '<br /><br /><br />
<progress value="' . $count_messages . '" max="100000"></progress> <b>' . $count_messages . ' / 100,000</b><br />


<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_forum_package/modo_' . $icon_style[37] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[37]['nom'] . $texte_lock[37] . '</span><br />
' . $achievement[37]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_forum_package/timer1_' . $icon_style[38] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[38]['nom'] . $texte_lock[38] . '</span><br />
' . $achievement[38]['dp'] . '<br /><br />
<br />
<progress value="' . $membredepuis . '" max="5"></progress> <b>' . $membredepuis . ' / 5</b>
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_forum_package/timer2_' . $icon_style[39] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[39]['nom'] . $texte_lock[39] . '</span><br />
' . $achievement[39]['dp'] . '<br /><br />
<br />
<progress value="' . $membredepuis . '" max="20"></progress> <b>' . $membredepuis . ' / 20</b>
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_forum_package/timer3_' . $icon_style[40] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[40]['nom'] . $texte_lock[40] . '</span><br />
' . $achievement[40]['dp'] . '<br /><br />
<br />
<progress value="' . $membredepuis . '" max="80"></progress> <b>' . $membredepuis . ' / 80</b>
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_forum_package/timer4_' . $icon_style[41] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[41]['nom'] . $texte_lock[41] . '</span><br />
' . $achievement[41]['dp'] . '<br /><br />
<br />
<progress value="' . $membredepuis . '" max="160"></progress> <b>' . $membredepuis . ' / 160</b>
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_forum_package/timer5_' . $icon_style[42] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[42]['nom'] . $texte_lock[42] . '</span><br />
' . $achievement[42]['dp'] . '<br /><br />
<br />
<progress value="' . $membredepuis . '" max="360"></progress> <b>' . $membredepuis . ' / 360</b>
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dlc_forum_package/timer6_' . $icon_style[43] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[43]['nom'] . $texte_lock[43] . '</span><br />
' . $achievement[43]['dp'] . '<br /><br /><br />
<progress value="' . $membredepuis . '" max="720"></progress> <b>' . $membredepuis . ' / 720</b>

</div>


<h3>Catégorie de la progression du niveau</h3>
<div class="contenu">

<div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/level10_' . $icon_style[1] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[1]['nom'] . $texte_lock[1] . '</span><br />
' . $achievement[1]['dp'] . '<br /><br />
<br />
<progress value="' . $value_progress_niveau10 . '" max="10"></progress> <b>' . $value_progress_niveau10 . ' / 10</b>
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/level25_' . $icon_style[2] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[2]['nom'] . $texte_lock[2] . '</span><br />
' . $achievement[2]['dp'] . '<br /><br />
<br />
<progress value="' . $value_progress_niveau26 . '" max="26"></progress> <b>' . $value_progress_niveau26 . ' / 26</b>
<br />
<div class="separate"></div>


<span style="float: left; margin-right: 10px;"><img src="images/achievements/level50_' . $icon_style[3] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[3]['nom'] . $texte_lock[3] . '</span><br />
' . $achievement[3]['dp'] . '<br /><br />
<br />
<progress value="' . $value_progress_niveau51 . '" max="51"></progress> <b>' . $value_progress_niveau51 . ' / 51</b>
<br />
<div class="separate"></div>


<span style="float: left; margin-right: 10px;"><img src="images/achievements/level75_' . $icon_style[4] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[4]['nom'] . $texte_lock[4] . '</span><br />
' . $achievement[4]['dp'] . '<br /><br />
<br />
<progress value="' . $value_progress_niveau76 . '" max="76"></progress> <b>' . $value_progress_niveau76 . ' / 76</b>
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/level100_' . $icon_style[5] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[5]['nom'] . $texte_lock[5] . '</span><br />
' . $achievement[5]['dp'] . '<br /><br />
<br />
<progress value="' . $value_progress_niveau100 . '" max="100"></progress> <b>' . $value_progress_niveau100 . ' / 100</b>
<br />

</div>
</div>




<h3>Catégorie du mode Reborn</h3>
<div class="contenu">
<span style="float: left; margin-right: 10px;"><img src="images/achievements/prestige_' . $icon_style[6] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[6]['nom'] . $texte_lock[6] . '</span><br />
' . $achievement[6]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>


<span style="float: left; margin-right: 10px;"><img src="images/achievements/prestige2_' . $icon_style[7] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[7]['nom'] . $texte_lock[7] . '</span><br />
' . $achievement[7]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>


<span style="float: left; margin-right: 10px;"><img src="images/achievements/prestige5_' . $icon_style[8] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[8]['nom'] . $texte_lock[8] . '</span><br />
' . $achievement[8]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>


<span style="float: left; margin-right: 10px;"><img src="images/achievements/prestige10_' . $icon_style[9] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . stripslashes($achievement[9]['nom']) . $texte_lock[9] . '</span><br />
' . $achievement[9]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/prestige20_' . $icon_style[10] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[10]['nom'] . $texte_lock[10] . '</span><br />
' . $achievement[10]['dp'] . '<br /><br />
<br />
<br />
</div>

<h3>Catégorie des compétences</h3>
<div class="contenu">
<span style="float: left; margin-right: 10px;"><img src="images/achievements/scytheslash_' . $icon_style[11] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[11]['nom'] . $texte_lock[11] . '</span><br />
' . stripslashes($achievement[11]['dp']) . '<br /><br />
<br />
<br />
<div class="separate"></div>


<span style="float: left; margin-right: 10px;"><img src="images/achievements/xpachieve1_' . $icon_style[12] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[12]['nom'] . $texte_lock[12] . '</span><br />
' . $achievement[12]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>


<span style="float: left; margin-right: 10px;"><img src="images/achievements/skill1_' . $icon_style[13] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[13]['nom'] . $texte_lock[13] . '</span><br />
' . $achievement[13]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>


<span style="float: left; margin-right: 10px;"><img src="images/achievements/skill2_' . $icon_style[14] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[14]['nom'] . $texte_lock[14] . '</span><br />
' . $achievement[14]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>


<span style="float: left; margin-right: 10px;"><img src="images/achievements/skill3_' . $icon_style[15] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[15]['nom'] . $texte_lock[15] . '</span><br />
' . $achievement[15]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>


<span style="float: left; margin-right: 10px;"><img src="images/achievements/skill4_' . $icon_style[16] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[16]['nom'] . $texte_lock[16] . '</span><br />
' . $achievement[16]['dp'] . '<br /><br />
<br />
<br />

</div>




<h3>Catégorie des caractéristiques</h3>
<div class="contenu">
<span style="float: left; margin-right: 10px;"><img src="images/achievements/healthach1_' . $icon_style[17] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[17]['nom'] . $texte_lock[17] . '</span><br />
' . $achievement[17]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/healthach2_' . $icon_style[18] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[18]['nom'] . $texte_lock[18] . '</span><br />
' . $achievement[18]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/criticalhit_' . $icon_style[19] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[19]['nom'] . $texte_lock[19] . '</span><br />
' . $achievement[19]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dodge_' . $icon_style[20] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[20]['nom'] . $texte_lock[20] . '</span><br />
' . $achievement[20]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/healer_' . $icon_style[21] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[21]['nom'] . $texte_lock[21] . '</span><br />
' . $achievement[21]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/shield_' . $icon_style[22] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[22]['nom'] . $texte_lock[22] . '</span><br />
' . $achievement[22]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/op_' . $icon_style[23] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[23]['nom'] . $texte_lock[23] . '</span><br />
' . $achievement[23]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/goodfists_' . $icon_style[24] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[24]['nom'] . $texte_lock[24] . '</span><br />
' . $achievement[24]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/bags_' . $icon_style[25] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[25]['nom'] . $texte_lock[25] . '</span><br />
' . $achievement[25]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/useful_' . $icon_style[26] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[26]['nom'] . $texte_lock[26] . '</span><br />
' . $achievement[26]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/achievements/dropper_' . $icon_style[27] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[27]['nom'] . $texte_lock[27] . '</span><br />
' . $achievement[27]['dp'] . '<br /><br />
<br />
<br />
</div>


<!--
<h3>Catégorie des quêtes secondaires et personnelles</h3>
<div class="contenu">
</div>
-->


<h3>Catégorie des succès divers</h3>
<div class="contenu">
<span style="float: left; margin-right: 10px;"><img src="images/achievements/money1_' . $icon_style[28] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[28]['nom'] . $texte_lock[28] . '</span><br />
' . $achievement[28]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>


<span style="float: left; margin-right: 10px;"><img src="images/achievements/forum1_' . $icon_style[29] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[29]['nom'] . $texte_lock[29] . '</span><br />
' . $achievement[29]['dp'] . '<br /><br />
<br />
<br />
<div class="separate"></div>


<span style="float: left; margin-right: 10px;"><img src="images/achievements/secret_' . $icon_style[30] . '.png" width="100" height="100" /></span>
<span style="font-size: 15pt; font-weight: bold;">' . $achievement[30]['nom'] . $texte_lock[30] . '</span><br />
' . $achievement[30]['dp'] . '<br /><br />
<br />
<br />


</div>
</div>

';


include('pied.php');
?>