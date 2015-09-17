<?php
include('head.php');

if(isset($_SESSION['id']))
{
	$menuGauche = '
	<span class="menuNom" onmouseover="menuOuvrir(\'sousMenu\');" onmouseout="menuFermer(\'sousMenu\');">&nbsp;&nbsp;Applications&nbsp;</span>
	<span class="menuNom">&nbsp;Places&nbsp;</span>
	<span class="menuNom" onmouseover="menuOuvrir(\'sousMenu3\');" onmouseout="menuFermer(\'sousMenu3\');">&nbsp;Système&nbsp;</span>';
	$menuDroit = '<span class="menuNom" onmouseover="menuOuvrir(\'sousMenu2\');" onmouseout="menuFermer(\'sousMenu2\');">&nbsp;' . $_SESSION['pseudo'] . '&nbsp;&nbsp;</span>';
}
else
{
	$menuGauche = '';
	$menuDroit = '<span class="menuNom">&nbsp;Invité&nbsp;&nbsp;</span>';
}

echo '
	<div class="os">
			<table style="border-collapse: collapse;" width="100%" class="barreHaut" id="barreHaut">
				<th class="menuGauche">
				' . $menuGauche . '
				</th>
				<th class="menuCentre">
					' . date('H\:i', time()) . '
				</th>
				<th class="menuDroit">
					' . $menuDroit . '
				</th>
			</table>
			<span id="sousMenuTable">
';

if(isset($_SESSION['id']))
{
	include('menuGauche.php');
	include('menuDroit.php');
	echo '</span>
	<span class="bureau" id="bureau">';
}
else
{
	echo '</span>
	<span class="bureau" id="bureau">';
	include('connexion.php');
}
?>