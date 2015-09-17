<?php

echo '
	<script>
		setInterval(\'connexion()\', 0);
		setInterval(\'inscription()\', 0);
	</script>

	<div class="connexion" id="connexion">
	<span id="bCo">
	<form>
		<center><img src="images/design/logo.png" height="5%" width="25%" /><br /><br />
		Bienvenue sur Evenforum</center><br /><br />

		<label for="pseudo">Pseudo:</label> <input type="text" id="pseudo" class="labelCo" /><br /><br />
		<label for="pass">Mot de passe:</label> <input type="password" id="pass" class="labelCo" /><br /><br />
		<span style="float: right;"><input type="button" value="Inscription" class="inputCo" onclick="switchCo(); return false;" />&nbsp;&nbsp;<input type="button" value="Connexion" class="inputCo" onclick="coFunc(); return false;" /></span>
		<span style="float: left; color: red;" id="cErreur"></span>
	</form>
	</span>
	<span id="bCoCours" style="display: none;">
	<center>Connexion en cours</center>
	</span>
	</div>

	<div class="inscription" id="inscription">
	<span id="bIns">
	<form>
		<center>Inscription sur Evenforum</center><br /><br />

		<label for="pseudo">Pseudo:</label> <input type="text" id="insPseudo" class="labelCo" onchange="insFunc(1); return false;" /><br /><br />
		<label for="pseudo">Mot de passe:</label> <input type="password" id="insPass" class="labelCo" /><br /><br />
		<label for="pseudo">Confirmation:</label> <input type="password" id="pass2" class="labelCo" onblur="insFunc(2); return false;" /><br /><br />
		<label for="pseudo">Email:</label> <input type="email" id="email" class="labelCo" /><br /><br />
		<span style="float: right;"><input type="button" value="Annuler" class="inputCo" onclick="switchCo(); return false;" />&nbsp;&nbsp;<input type="button" value="Inscription" class="inputCo" onclick="insFunc(3); return false;"/></span>
		<span style="float: left; color: red;" id="iErreur"></span>
	</form>
	</span>
	<span id="bInsCours" style="display: none;">
	<center>Inscription en cours</center>
	</span>
	</div>
	<script>
		$("#connexion").fadeIn("slow");
	</script>
';

?>