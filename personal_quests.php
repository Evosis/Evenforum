<?php
include('base.php');
include('tete.php');

siMembre();

?>


<h3>Quête personnelle</h3>
<div class="contenu">
<form method="post">
Proposez votre propre quête personnalisée à un membre !<br />
<p>Décidez des objectifs, de la récompense, et du temps maximal de validité.</p><br />

<h2>Informations de base</h2>
<label>Pseudo :</label>	<input type="text" name="pseudo" maxlenght="20" placeholder="Ce pseudo recevra la quête."><br />
<label>Titre de la quête :</label>	<input type="text" name="titre" maxlenght="60" placeholder="60 caractères maximum !"><br />
Description :<br />
<textarea name="description" placeholder="Hésitez pas à jouer RP dans votre description."></textarea>
<div class="separate"></div>

<h2>Objectif principal</h2>
<input type="radio" name="objectif" value="obj_objet" disabled> Donner un objet spécifique<br />
<input type="radio" name="objectif" value="obj_ecpb" checked> Donner une somme d'EC ou PB<br />
<input type="radio" name="objectif" value="obj_exp"> Donner de l'expérience<br />
<input type="radio" name="objectif" value="obj_perso"> Objectif personnalisé<br /><br />

<label>Objectif personnalisé :</label> <input type="text" name="objectif" placeholder="Compléter que si c'est un objectif perso.">
<div class="separate"></div>

<h2>Récompense si réussite</h2>
<input type="radio" name="gain" value="gain_objet" disabled> Un objet de votre inventaire<br />
<input type="radio" name="gain" value="gain_exp" checked> De l'expérience<br />
<input type="radio" name="gain" value="gain_ecpb"> Des EC / PB<br />
<input type="radio" name="gain" value="gain_nothing"> Aucun gain<br /><br />

<label> Total du gain :</label> <input type="text" name="gain_amont">
<div class="separate"></div>

<h2>Validité (durée de la quête)</h2>

<input type="radio" name="valide" value="infini" checked> Permanente (la quête sera disponible tant qu'elle n'a pas été terminée)<br />
<input type="radio" name="valide" value="perso"> Limitée (définissez le nombre d'heures avant expiration de la quête)<br /><br />

<label>Nombre d'heures :</label>	<input type="text" name="valide_perso" placeholder="Compléter que si c'est une validité limitée.">
<div class="separate"></div>
<input type="submit">


</form>
</div>