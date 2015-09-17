<?php
include('../base.php');

if($_POST['app'] == "appTerminal")
{
	echo '
		
		<div class="appFenetreMenu" id="appTerminalMenu" onmousedown="bouger(event,\'appTerminal\');" onmouseup="stop_bouge(event,\'appTerminal\');">Terminal ' . $_SESSION['pseudo'] . '@evenforum:~$</div>
		<div class="appFenetreBouton" style="float: right;">
		<a href="#" title="Agrandir la fenêtre" class="appAgrandir" onmousedown="appAgrandir(\'appTerminal\')">&bull;</a> &nbsp;&nbsp; 
		<a href="#" title="Réduire la fenêtre" class="appReduire" onmousedown="appReduire(\'appTerminal\')">&bull;</a> &nbsp;&nbsp; 
		<a href="#" title="Fermer la fenêtre" class="appFermer" onmousedown="appFermer(\'appTerminal\')">&bull;</a> </div>

		<div class="appFenetreContenu" id="appTerminalContenu">
		<span id="appTerminalReponse"></span>
		' . $_SESSION['pseudo'] . '@evenforum:~$ <span id="appTerminalSaisie"></span><span id="appTerminalUnderscore"></span>
		</div>
		<input id="appTerminalInput" style="margin-left: -99999px; margin-top: -99999;" onblur="appTerminalUnderscoreBlur()" onkeypress="if(event.keyCode==13){appTerminalEnter(\'' . $_SESSION['pseudo'] . '\');}"/>
	';
}
elseif($_POST['app'] == "appConfigBureau")
{
	echo '
		
		<div class="appFenetreMenu" id="appConfigBureauMenu" onmousedown="bouger(event,\'appConfigBureau\');" onmouseup="stop_bouge(event,\'appConfigBureau\');">Apparence du bureau</div>
		<div class="appFenetreBouton" style="float: right;">
		<a href="#" title="Agrandir la fenêtre" class="appAgrandir" onmousedown="appAgrandir(\'appConfigBureau\')">&bull;</a> &nbsp;&nbsp; 
		<a href="#" title="Réduire la fenêtre" class="appReduire" onmousedown="appReduire(\'appConfigBureau\')">&bull;</a> &nbsp;&nbsp; 
		<a href="#" title="Fermer la fenêtre" class="appFermer" onmousedown="appFermer(\'appConfigBureau\')">&bull;</a> </div>

		<div class="appFenetreContenu" id="appConfigBureauContenu">
		
		</div>
	';
}

?>