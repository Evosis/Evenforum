<?php
echo'
	<table style="border-collapse: collapse;" class="sousMenu" id="sousMenu" onmouseout="menuFermer(\'sousMenu\');">
		<tr>
			<th class="sousMenuTh" onmouseover="menuOuvrir(\'sousMenu\');" onclick="appLaunch(\'appTerminal\')">&nbsp;&nbsp;<img src="http://www.icone-png.com/png/37/37379.png" height="20" width="20" style="margin-bottom: -3px;" /> &nbsp;&nbsp; Terminal &nbsp;</th>
		</tr>
	</table>
	<table style="border-collapse: collapse;" class="sousMenu3" id="sousMenu3" onmouseout="menuFermer(\'sousMenu3\');">
		<tr>
			<th class="sousMenuTh" onmouseover="menuOuvrir(\'sousMenu3\');" onclick="appLaunch(\'appConfigBureau\')">&nbsp;&nbsp;<img src="http://icons.iconarchive.com/icons/tristan-edwards/sevenesque/1024/Preview-icon.png" height="20" width="20" style="margin-bottom: -3px;" /> &nbsp;&nbsp; Apparence du bureau &nbsp;</th>
		</tr>
	</table>
';
?>