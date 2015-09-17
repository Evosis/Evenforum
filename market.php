<?php
include('base.php');
include('tete.php');

siMembre();

$req_donnees = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $_SESSION['id']);
$req_donnees->execute();
$donnees_membres = $req_donnees->fetch(PDO::FETCH_OBJ);


echo '
<h3>Le marché</h3>
<div class="contenu">
<h1><font color="#00c240">' . number_format($donnees_membres->ec) . ' EC</font> </h1>
Dépensez vos EC dans le marché. Mettez en vente vos objets. Proposez des échanges aux membres.
</div>

<h3>Catégorie</h3>
<div class="contenu">
<b>Veuillez choisir la catégorie de l\'objet que vous recherchez.</b>
<div class="separate"></div>
<h2>Équipements</h2>
<li><a href="market.php?cat=1">Armes normales</a></li>
<li><a href="market.php?cat=2">Armes enchantées</a></li>
<li><a href="market.php?cat=3">Armes démoniaques</a></li>
<br />
<li><a href="market.php?cat=4">Armures normales</a></li>
<li><a href="market.php?cat=5">Armures enchantées</a></li>
<div class="separate"></div>
<h2>Consommables</h2>
<li><a href="market.php?cat=6">Consommables droppable</a></li>
<li><a href="market.php?cat=7">Consommables indroppable</a></li>
<li><a href="market.php?cat=8">Consommables premium</a></li>
<div class="separate"></div>
<h2>Ressources</h2>
<li><a href="market.php?cat=9">Ressources droppable</a></li>

</div>

';

include('pied.php');

?>