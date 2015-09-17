<?php
include('base.php');
include('tete.php');

siMembre();

?>


<h3>Choix difficulté de jeu</h3>
<div class="contenu">
<span style="font-size: 18pt;">Facile</span>
<div class="separate"></div>
Aucun risque particulier. Vous ferez plus de dégâts à vos ennemis tandis qu'eux en feront moins.<br />
<b>EXP</b> x <b>0,35</b><br />
<b>Gains</b> x <b>0,20</b><br />
<b>Drops <font color="red">DÉSACTIVÉS</b></font>
<div class="separate"></div>
<br /><br />


<span style="font-size: 18pt;">Normal</span>
<div class="separate"></div>
Mode de jeu standard. Dégâts normaux pour tout le monde.<br />
<b>EXP</b> x <b>1</b><br />
<b>Gains</b> x <b>1</b><br />
<b>Drops <font color="green">activés</b></font>
<div class="separate"></div>
<br /><br />


<span style="font-size: 18pt;">Difficile</span>
<div class="separate"></div>
Habitués uniquement. Vos dégâts sont réduits, et vos ennemis sont plus puissants.<br />
<b>EXP</b> x <b>1,5</b><br />
<b>Gains</b> x <b>1,5</b><br />
<b>Drops <font color="green">activés, avec 1,5x plus de chances de drop</b></font>
<div class="separate"></div>
<br /><br />


<span style="font-size: 18pt;">Professionnel</span>
<div class="separate"></div>
Pros uniquement. Dégâts considérablement réduits, ainsi que votre santé.<br />
<b>EXP</b> x <b>2</b><br />
<b>Gains</b> x <b>2</b><br />
<b>Drops <font color="green">activés, avec 2x plus de chances de drop</b></font>
<div class="separate"></div>
<br /><br />


<span style="font-size: 18pt;">Cauchemar</span>
<div class="separate"></div>
Aucune aide. Aucune compétence. Usage d'objets limités. Armes limités. Solo uniquement. PVP mortel.<br />
<b>EXP</b> x <b>5</b><br />
<b>Gains</b> x <b>5</b><br />
<b>Drops <font color="green">activés, avec 5x plus de chances de drop</b></font>
<div class="separate"></div>
<br /><br />


<span style="font-size: 18pt;">Hardcore</span>
<div class="separate"></div>
1 seule vie pour terminer le jeu. Même règles que le mode cauchemar.<br />
<b>EXP</b> x <b>8</b><br />
<b>Gains</b> x <b>8</b><br />
<b>Drops <font color="green">activés, avec 8x plus de chances de drop</b></font>
</div>

<?php
include('pied.php');
?>