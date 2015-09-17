<?php
include('base.php');
include('tete.php');

if(isset($_SESSION['pseudo']))
{
	avert('Vous êtes déjà connecté !');
	include('pied.php');
	exit;
}

if(isset($_POST['pseudo']))
{
	if(!empty($_POST['pseudo']) AND !empty($_POST['password']))
	{
		$req = $connexion->prepare('SELECT COUNT(*) FROM membres WHERE pseudo = "' . $_POST['pseudo'] . '"');
		$req->execute();
		$count = $req->fetchColumn();

		if($count != 0)
		{
			$req_checkPsswd = $connexion->prepare('SELECT motdepasse FROM membres WHERE pseudo = "' . $_POST['pseudo'] . '"');
			$req_checkPsswd->execute();
			$donnees_checkPsswd = $req_checkPsswd->fetch(PDO::FETCH_OBJ);

			$mdp_crypt = $donnees_checkPsswd->motdepasse;

			if(password_verify($_POST['password'], $mdp_crypt))
			{
				$req_selectinfosmembre = $connexion->prepare('SELECT * FROM membres WHERE pseudo = "' . $_POST['pseudo'] . '"');
				$req_selectinfosmembre->execute();
				$donnees_infosmembre = $req_selectinfosmembre->fetch(PDO::FETCH_OBJ);

				switch($donnees_infosmembre->acces)
				{
					case 10:
					$session_acces = 10; // membre
					break;

					case 20:
					$session_acces = 20; // premium
					break;

					/*case 50:
					$session_acces = 50; // modé
					break;

					case 80:
					$session_acces = 80; // sup modé
					break;*/

					case 85:
					$session_acces = 85; // mj
					break;

					/*case 90:
					$session_acces = 90; // codeur
					break;

					case 100:
					$session_acces = 100; // admin
					break;*/

					default:
					$session_acces = 10;
				}

				if($donnees_infosmembre->acces != 1)
				{
					if($donnees_infosmembre->acces != 2)
					{
						if($donnees_infosmembre->valide == 1)
						{
							// Sinon le membre peut se connecter, on crée les sessions!
							$_SESSION['id'] = $donnees_infosmembre->id;
							$_SESSION['pseudo'] = $donnees_infosmembre->pseudo;
							$_SESSION['acces'] = $session_acces;
							//$_SESSION['niveau'] = $donnees_infosmembre->niveau;
							$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
							$_SESSION['clef'] = $donnees_infosmembre->clef;
							//setcookie('GUID', $_SESSION['clef'], (time() + 365*24*3600));
							//$connexion->exec('UPDATE connectes SET clefUnique = "' . $_SESSION['clef'] . '" WHERE ip = "' . $_SERVER['REMOTE_ADDR'] . '"');

							$lastTime = $donnees_infosmembre->timestampBonus;

							if(time() >= $lastTime + 86400)
							{
								$xpBonus = rand(200, 800);
								$ecBonus = rand(200, 800);
								$connexion->query('UPDATE membres SET experience = (experience + ' . $xpBonus . ') WHERE id = ' . $_SESSION['id']);
								$connexion->query('UPDATE membres SET ec = (ec + ' . $ecBonus . ') WHERE id = ' . $_SESSION['id']);
								notification($_SESSION['id'], 1, "Vous avez reçu un bonus de fidélité !\n EXP : [b]+ " . $xpBonus . "[/b]\nEC : [b] + " . $ecBonus . "[/b]", $connexion);
								$connexion->exec('UPDATE membres SET timestampBonus = "' . time() . '" WHERE id = ' . $_SESSION['id']);
							}

							$connexion->exec('UPDATE membres SET lastConnexion = "' . time() . '" WHERE id = ' . $_SESSION['id']);


							header('Location: index.php');
						}
						else
						avert('Pseudo non validé. Veuillez patienter.');

					}
					else
					avert('Votre pseudo est exclu temporairement du site.');
				}
				else
				avert('Votre pseudo est exclu définitivement du site.');
			}
			else
			avert('Pseudo incorrect, ou mot de passe invalide.');
		}
		else
		avert('Pseudo incorrect, ou mot de passe invalide.');
	}
}

?>

<h3>Connexion</h3>
<div class="contenu">
	<b>Note: Connectez-vous avec votre pseudo à nouveau au lieu de votre e-mail.</b><br /><br />
	<form method="post">
		<label>Nom de compte :</label>	<input type="text" name="pseudo"><br />
		<label>Mot de passe :</label>	<input type="password" name="password"><br />
		<br/>
		<input type="submit">
	</form>
</div>

<?php
include('pied.php');
?>