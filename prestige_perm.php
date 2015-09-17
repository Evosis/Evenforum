<?php
include('base.php');
include('tete.php');

siMembre();

$reponse = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $_SESSION['id'] . '');
$reponse->execute();
$donnees = $reponse->fetch(PDO::FETCH_OBJ);

$prestige = entier_romain($donnees->prestige);

echo '

<h3>Bonus permanents</h3>
<div class="contenu">

<center><h1>Tier 1</h1></center>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/1.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn I</span><br />
L\'EXP de base par posts est augmenté de <b>100</b>.<br />
<b>Catégorie de compétences Reborn débloqué</b><br /><br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/2.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn II</span><br />
Augmente de <b>5</b> le nombre d\'EC gagnés par post et topics.<br /><br /><br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/3.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn III</span><br />
Coût de Scythe Slash réduit de <b>1</b> point<br /><br /><br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/1.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn IV</span><br />
EXP supplémentaire : +15% d\'EXP permanent<br /><br /><br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/2.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn V</span><br />
EC supplémentaire : +12% d\'EC permanent<br /><br /><br /><br />
<div class="separate"></div>

<br /><br />

<center><h1>Tier 2</h1></center>


<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/4.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn VI</span><br />
Tous les temps d\'attente du site réduits de 5 secondes<br /><br /><br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/2.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn VII</span><br />
EC supplémentaire : +8% d\'EC permanent<br /><br /><br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/1.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn VIII</span><br />
EXP supplémentaire : +20% d\'EXP permanent<br /><br /><br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/1.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn IX</span><br />
EXP supplémentaire : +20% d\'EXP permanent<br /><br /><br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/3.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn X</span><br />
Coût de toutes les compétences de niveau 3 uniquement réduit de 1 point<br /><br /><br /><br />
<div class="separate"></div>


<br /><br />

<center><h1>Tier 3</h1></center>


<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/2.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn XI</span><br />
EC supplémentaire : +10% d\'EC permanent<br /><br /><br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/4.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn XII</span><br />
Tous les temps d\'attente du site réduits de 15 secondes<br /><br /><br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/1.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn XIII</span><br />
EXP supplémentaire : +30% d\'EXP permanent<br /><br /><br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/4.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn XIV</span><br />
Tous les temps d\'attente du site réduits de 15 secondes<br /><br /><br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/1.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn XV</span><br />
EXP supplémentaire : +20% d\'EXP permanent<br /><br /><br /><br />
<div class="separate"></div>



<br /><br />

<center><h1>Tier ♠</h1></center>


<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/3.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn XVI</span><br />
Coût de toutes les compétences de niveau 3 uniquement réduit de 1 point<br /><br /><br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/2.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn XVII</span><br />
EC supplémentaire : +10% d\'EC permanent<br /><br /><br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/4.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn XVIII</span><br />
Tous les temps d\'attente du site réduits au maximum<br /><br /><br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/1.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn XIX</span><br />
EXP supplémentaire : +60% d\'EXP permanent<br /><br /><br /><br />
<div class="separate"></div>

<span style="float: left; margin-right: 10px;"><img src="images/prestige_rewards/3.png" width="100" height="100" /></span>
<span style="font-size: 18pt; font-weight: bold;">Reborn XX</span><br />
Coût de toutes les compétences de niveau 4 uniquement réduit de 2 points<br /><br /><br /><br />
<div class="separate"></div>

</div>

';

include('pied.php');

?>