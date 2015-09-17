<?php
include('base.php');
include('tete.php');

$count = $connexion->query('SELECT COUNT(*) FROM hidden WHERE idPseudo = ' . $_SESSION['id'])->fetchColumn();

if($count > 0)
{
	include('pied.php');
	exit;
}

$password = "iheartrainbows44";

if(isset($_POST['password']))
{
	$lowerPass = strtolower($_POST['password']);
	if($lowerPass == $password)
	{
		$connexion->query("INSERT INTO hidden VALUES('', '" . $_SESSION['id'] . "', '1')");
		$connexion->query("INSERT INTO notifications VALUES('', '" . $_SESSION['id'] . "', '1', 'Connexion réussie. L\'opération REZURRECTION est lancée !', '0', '0', '" . time() . "')");
		redirection('index.php');
	}
	else
	redirection('error.php?erreur=506');
}

?>

<h3>UNKNOWN_BLOC_HEADER</h3>
<div class="contenu">
<form method="post">
<label>USER_PASSWORD</label>	<input type="text" name="password"><br /><br />
<input type="submit">
</form>
</div>

<?php
include('pied.php');
?>