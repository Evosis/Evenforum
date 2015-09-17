<?php
include('base.php');
include('tete.php');

siMembre();

$r_donnees_membre = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $_SESSION['id'] . '');
$r_donnees_membre->execute();
$donnees_membre = $r_donnees_membre->fetch(PDO::FETCH_OBJ);

$exp_next = $niveau[$donnees_membre->niveau + 1]['exp'] - $donnees_membre->experience;

if($donnees_membre->prestige > 0)
{
	$rankPrestige = 'Prestige <b>' . entier_romain($donnees_membre->prestige) . '</b>';
}
else
{
	$rankPrestige = '';
}

if($donnees_membre->acces >= 20)
{
	$premium = true;
}
else
{
	$premium = false;
}

echo '


<h3>État de votre compte</h3>
<div class="contenu">
<img style="float: left; margin-right: 15px;" src="images/ranks/' . $donnees_membre->niveau . '.png" width="150" height="150" />
<span style="font-size: 16pt;">	<b>Rang ' . $donnees_membre->niveau . '</span><br />
								Emblème de ' . $name_rank . '</b><br /><br />
								<label>EXP total :</label>	' . number_format($donnees_membre->experience) . ' points d\'EXP<br />
								'; if($donnees_membre->niveau != 100) { echo '
								<label>Prochain niveau :</label>	<b>' . number_format($exp_next) . ' points d\'EXP</b>'; } else { echo '<b>Niveau maximal atteint.</b>'; } echo '

								<br /><br />' . $rankPrestige . '<br />

</div>

';

if($premium == false)
{
	echo 

	'<h3>Compte Premium</h3>
	<div class="contenu">
	<img style="float: left; margin-right: 25px;" src="images/design/premium.png" width="200" height="200" />
	<span style="font-size: 16pt;">	<b>Premium non activé sur ce compte !</b></span><span style="float: right;"><a href="premium.php">Passer Premium</a></span><br /><br />
	Devenez Premium dès maintenant pour profiter des avantages suivants :<br />
	<ul>
		<li>Des événements spéciaux uniquement pour les membres</li>
		<li>Des compétences et des objets supplémentaires</li>
		<li>Une seconde quête principale scénarisée</li>
		<li>Du double EXP fréquemment</li>
		<li>Avoir accès aux fonctions futures en early access</li>
		<li>Pseudonyme de couleur orangé</li>
	</ul>
	</div>

	';
}
else
{
	echo '
	<h3>Compte Premium</h3>
	<div class="contenu">
	<img style="float: left; margin-right: 25px;" src="images/design/premium.png" width="100" height="100" />
	<span style="font-size: 16pt;">	<b>Premium actif !</b></span>
	</div>
	';
}

echo '

<h3>Fonctions</h3>
<div class="contenu">
<ul>
	<li><a href="prestige.php">Mode Prestige</a></li>
	<li><a href="boutique_prestige.php">Boutique de prestige</a></li>
	<li><a href="#">???</a></li>
	<li><a href="#">???</a></li>
	<li><a href="#">???</a></li>
	<li><a href="veteran_reward.php">Veteran d\'EvenForum</a></li>
</ul>
</div>

';

include('pied.php');
?>