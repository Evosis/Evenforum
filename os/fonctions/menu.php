<?php
include('base.php');

if(isset($_POST['coMenu']))
{
	if(isset($_SESSION['id']))
	{
		include('iMenu.php');
		include('pMenu.php');

		echo '
			<th class="pMenu">
				<span class="sMenu" onmouseover="oMenu(\'ssMenu\');" onmouseout="fMenu(\'ssMenu\');">&nbsp;&nbsp;Applications&nbsp;</span><span class="sMenu">&nbsp;Places&nbsp;</span><span class="sMenu">&nbsp;Système&nbsp;</span>
			</th>
			<th class="tMenu">
				' . date('H\:i', time()) . '
			</th>
			<th class="iMenu">
				<span class="sMenu" onmouseover="oMenu(\'ssMenu2\');" onmouseout="fMenu(\'ssMenu2\');">&nbsp;' . $_SESSION['pseudo'] . '&nbsp;&nbsp;</span>
			</th>
			</table>
			<table style="border-collapse: collapse;" class="ssMenu" id="ssMenu" onmouseout="fMenu(\'ssMenu\');">
			<tr>
				<th class="sThMenu" onmouseover="oMenu(\'ssMenu\');">&nbsp;&nbsp;Site&nbsp;</th>
			</tr>
			<tr>
				<th class="sThMenu" onmouseover="oMenu(\'ssMenu\');">&nbsp;&nbsp;Forum&nbsp;</th>
			</tr>
			</table>
			<table style="border-collapse: collapse;" class="ssMenu2" id="ssMenu2" onmouseout="fMenu(\'ssMenu2\');">
			<tr>
				<th class="sThMenu" onmouseover="oMenu(\'ssMenu2\');" onclick="deconnexion(); return false;">&nbsp;&nbsp;Déconnexion&nbsp;</th>
			</tr>
		';
	}
	else
	{
		echo '1';
	}
}

?>