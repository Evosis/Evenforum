<?php
include('base.php');
include('tete.php');


	if(isset($_SESSION['pseudo']))
	{
		avert('Vous avez déjà un compte sur nos serveurs.');
		include('pied.php');
		exit;
	}
/*
	$jour =  $_POST['jour'];
	$mois =  $_POST['mois'];
	$annee = $_POST['annee'];
	$genre = $_POST['genre'];



	switch($mois)
	{
		case 1:
		if($jour <= 31 AND $jour > 0)
		{
			$date_correcte = true;
		}
		else
		{
			$date_correcte = false;
		}
		break;

		case 2:
		if($jour <= 28 AND $jour > 0 )
		{
			$date_correcte = true;
		}
		else
		{
			$date_correcte = false;
		}
		break;

		case 3:
		if($jour <= 31 AND $jour > 0 )
		{
			$date_correcte = true;
		}
		else
		{
			$date_correcte = false;
		}
		break;

		case 4:
		if($jour <= 30 AND $jour > 0 )
		{
			$date_correcte = true;
		}
		else
		{
			$date_correcte = false;
		}
		break;

		case 5:
		if($jour <= 31 AND $jour > 0 )
		{
			$date_correcte = true;
		}
		else
		{
			$date_correcte = false;
		}
		break;

		case 6:
		if($jour <= 30 AND $jour > 0 )
		{
			$date_correcte = true;
		}
		else
		{
			$date_correcte = false;
		}
		break;

		case 7:
		if($jour <= 31 AND $jour > 0 )
		{
			$date_correcte = true;
		}
		else
		{
			$date_correcte = false;
		}
		break;

		case 8:
		if($jour <= 31 AND $jour > 0 )
		{
			$date_correcte = true;
		}
		else
		{
			$date_correcte = false;
		}
		break;

		case 9:
		if($jour <= 30 AND $jour > 0 )
		{
			$date_correcte = true;
		}
		else
		{
			$date_correcte = false;
		}
		break;

		case 10:
		if($jour <= 31 AND $jour > 0 )
		{
			$date_correcte = true;
		}
		else
		{
			$date_correcte = false;
		}
		break;

		case 11:
		if($jour <= 30 AND $jour > 0 )
		{
			$date_correcte = true;
		}
		else
		{
			$date_correcte = false;
		}
		break;

		case 12:
		if($jour <= 31 AND $jour > 0 )
		{
			$date_correcte = true;
		}
		else
		{
			$date_correcte = false;
		}
		break;

	}

	if($annee >= 1950 AND $annee <= 2010)
	{
		$annee_correcte = true;
	}
	else
	{
		$annee_correcte = false;
	}


	if(isset($_POST['pseudo']))
	{
		if(preg_match("#^[a-zA-Z0-9\[\]_-]{3,20}$#", $_POST['pseudo'])) // Pseudo correct ?
		{
			$count = $connexion->query('SELECT * FROM membres WHERE pseudo = "' . $_POST['pseudo'] . '"')->fetchColumn();
			if($count == 0)
			{
				if(preg_match('#^[a-zA-Z0-9]{6,24}$#', $_POST['password'])) // Mdp correct ?
				{
					if(preg_match('#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,4}$#', $_POST['email'])) // @ valide?
					{
						if(stristr($_POST['email'], '@gmail.com') OR stristr($_POST['email'], '@hotmail.com') OR stristr($_POST['email'], '@hotmail.fr') OR stristr($_POST['email'], '@outlook.com') OR stristr($_POST['email'], '@yahoo.fr') OR stristr($_POST['email'], '@msn.com') OR stristr($_POST['email'], '@outlook.fr') OR stristr($_POST['email'], '@live.com') OR stristr($_POST['email'], '@live.fr') OR stristr($_POST['email'], '@sfr.fr') OR stristr($_POST['email'], '@free.fr') OR stristr($_POST['email'], '@orange.fr') OR stristr($_POST['email'], '@laposte.net') OR stristr($_POST['email'], '@mailoo.org')) // 2
						{
							$count_mail = $connexion->query('SELECT * FROM membres WHERE email = "' . $_POST['email'] . '"')->fetchColumn();
							if($count_mail == 0)
							{
								if($date_correcte == true)
								{
									if($annee_correcte == true)
									{
										$pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
										$clef = md5(uniqid(rand(), true));

										if($genre != 1 AND $genre != 2)
										{
											avert('Alors comme ça on peut pas s\'inscrire comme tout le monde ? Si vous arrêtiez de changer le code source pour une fois ?');
											include('pied.php');
											exit;
										}


										$envoi = $connexion->prepare("INSERT INTO membres VALUES('', :pseudo, :pass, :clef, :email, :valide, :acces, :avatar, :description, :jour, :mois, :annee, :genre, :psn, :xbl, :steam, :skype, :niveau, :exp, :specialisation, :sp, :pc, :pb, :rp, :lastCo, :ip, :timestamp)");
										$envoi->execute(array(
										'pseudo' => $_POST['pseudo'],
										'pass' => $pass_hash,
										'clef' => $clef,
										'email' => $_POST['email'],
										'valide' => 0,
										'acces' => 10,
										'avatar' => 'common/images/no_avatar.png',
										'description' => 'Aucune description.',
										'jour' => $jour,
										'mois' => $mois,
										'annee' => $annee,
										'genre' => $genre,
										'psn' => $_POST['psn'],
										'xbl' => $_POST['xblive'],
										'steam' => $_POST['steam'],
										'skype' => $_POST['skype'],
										'niveau' => 1,
										'exp' => 0,
										'specialisation' => 0,
										'sp' => 0,
										'pc' => 1,
										'pb' => 0,
										'rp' => 0,
										'lastCo' => 0,
										'ip' => $_SERVER['REMOTE_ADDR'],
										'timestamp' => time()
										)) or die(print_r($connexion->errorInfo(), true));

										$idPseudo = $connexion->lastInsertId('membres');

										$envoi2 = $connexion->prepare("INSERT INTO options VALUES('', :idPseudo, :background_page, :signature, :boite, :urlMusique, :titreMusique, :typeBlocCompte, :statsReal, :resetsComp)");
										$envoi2->execute(array(
										'idPseudo' =>  $idPseudo,
										'background_page' => '',
										'signature' =>	'',
										'boite' => '0',
										'urlMusique' => '',
										'titreMusique' => '',
										'typeBlocCompte' => '1',
										'statsReal' => '0',
										'resetsComp' => '3'
										)) or die(print_r($connexion->errorInfo(), true));

										info('Inscription réussie ! Un mail vous a été envoyé pour confirmer votre compte.');
										include('pied.php');
										exit;
									}
									else
									avert('Année de naissance incorrecte.');
								}
								else
								avert('Date de naissance incorrecte.');
							}
							else
							avert('E-mail déjà utilisée. Veuillez vous connecter.');
						}
						else
						avert('Email non autorisé. Veuillez vérifier');
					}
					else
					avert('Email non valide.');
				}
				else
				avert('Mot de passe trop court ou trop long.');
			}
			else
			avert('Pseudo déjà utilisé ! Veuillez en choisir un autre.');
		}
		else
		avert('Nom de compte incorrect.');
	}

?>

<h3>Inscription sur EvenForum</h3>
<div class="contenu">
<form method="post">


<p>Merci d'avoir choisi de vous inscrire. Veuillez remplir les informations requises.
Si quelque chose ne fonctionne pas, veuillez reporter votre bug aux codeurs via la rubrique de contact. Merci.</p>

<h2>Informations obligatoire</h2>

<div class="inscription"> <!-- Ce div sert a régler le width de la case -->
<label>Pseudonyme / Nom de compte :</label>		<input type="text" name="pseudo" placeholder="3 à 20 caractères uniquement."><br />
<label>Mot de passe désiré :</label>			<input type="password" name="password" placeholder="6 à 24 caractères maximum."><br />
<label>Adresse e-mail :</label>					<input type="text" name="email" placeholder="Un mail de confirmation sera envoyé."> <a href="#" title="Autorisés : @ hotmail.fr/com, outlook.fr/com, gmail.com, yahoo.fr, msn.com, live.fr/com, sfr.fr, free.fr, orange.fr et laposte.net.">
?</a><br /><br />
</div>

<label>Date de naissance :</label>
<select name="jour" width="150px">
	<option value="1">1</option>
		<?php
			for($i = 2; $i <= 31; $i++)
			{
				echo '<option value="' . $i . '">' . $i . '</option>';
			}
		?>
</select>
<select name="mois" width="150px">
	<option value="1">Janvier</option>
	<option value="2">Février</option>
	<option value="3">Mars</option>
	<option value="4">Avril</option>
	<option value="5">Mai</option>
	<option value="6">Juin</option>
	<option value="7">Juillet</option>
	<option value="8">Août</option>
	<option value="9">Septembre</option>
	<option value="10">Octobre</option>
	<option value="11">Novembre</option>
	<option value="12">Décembre</option>
</select>
<select name="annee" width="150px">
	<option value="1950">1950</option>
		<?php
			for($i = 1951; $i <= 2010; $i++)
			{
				echo '<option value="' . $i . '">' . $i . '</option>';
			}
		?>
</select>
<div class="separate"></div>
<h2>Informations de profil</h2>
<label>Je suis ...</label>	<input type="radio" name="genre" value="1" id="genre" checked> <font color="#4643e3">Un gars</font><br />
<label>Ou alors ...</label>			<input type="radio" name="genre" value="2" id="genre"> <font color="#ff276d">Une fille</font>
<div class="separate"></div>

<div class="inscription">
<label>ID PlayStation Network :</label> <input type="text" name="psn"><br />
<label>GT Xbox Live :</label> <input type="text" name="xblive"><br />
<label>ID Steam :</label> <input type="text" name="steam"><br />
<label>ID Skype :</label> <input type="text" name="skype"><br />
</div>
<br />
<center><input type="submit" value="Inscription"></center>
</form>
</div>

*/


if(isset($_POST['pseudo']))
{
	if(preg_match("#^[a-zA-Z0-9\[\]_-]{3,20}$#", $_POST['pseudo'])) // Pseudo correct ?
	{
			$r_count = $connexion->prepare('SELECT * FROM membres WHERE pseudo = "' . $_POST['pseudo'] . '"');
			$r_count->execute();
			$count = $r_count->fetchColumn();

		if($count == 0)
		{
			if(preg_match('#^[a-zA-Z0-9]{6,24}$#', $_POST['password'])) // Mdp correct ?
			{
				if(preg_match('#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,4}$#', $_POST['email'])) // @ valide?
				{
					if(stristr($_POST['email'], '@gmail.com') OR stristr($_POST['email'], '@hotmail.com') OR stristr($_POST['email'], '@hotmail.fr') OR stristr($_POST['email'], '@outlook.com') OR stristr($_POST['email'], '@yahoo.fr') OR stristr($_POST['email'], '@msn.com') OR stristr($_POST['email'], '@outlook.fr') OR stristr($_POST['email'], '@live.com') OR stristr($_POST['email'], '@live.fr') OR stristr($_POST['email'], '@sfr.fr') OR stristr($_POST['email'], '@free.fr') OR stristr($_POST['email'], '@orange.fr') OR stristr($_POST['email'], '@laposte.net') OR stristr($_POST['email'], '@mailoo.org')) // 2
					{
						$count_mail = $connexion->query('SELECT * FROM membres WHERE email = "' . $_POST['email'] . '"')->fetchColumn();
						if($count_mail == 0)
						{
							$pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
							$clef = md5(uniqid(rand(), true));

							$envoi = $connexion->prepare("INSERT INTO membres VALUES('', :pseudo, :pass, :clef, :email, :valide, :acces, :avatar, :description, :jour, :mois, :annee, :genre, :psn, :xbl, :steam, :skype, :niveau, :lastLevel, :exp, :prestige, :ptsPrestige, :lastPrestige, :specialisation, :ec, :pc, :pb, :rp, :lastCo, :timestampBonus, :ip, :timestamp)");
							$envoi->execute(array(
							'pseudo' => $_POST['pseudo'],
							'pass' => $pass_hash,
							'clef' => $clef,
							'email' => $_POST['email'],
							'valide' => 1,
							'acces' => 10,
							'avatar' => 'images/no_avatar.png',
							'description' => '',
							'jour' => 1,
							'mois' => 1,
							'annee' => 1975,
							'genre' => 1,
							'psn' => '',
							'xbl' => '',
							'steam' => '',
							'skype' => '',
							'niveau' => 1,
							'lastLevel' => 1,
							'exp' => 0,
							'prestige' => 0,
							'ptsPrestige' => 0,
							'lastPrestige' => 0,
							'specialisation' => 0,
							'ec' => 0,
							'pc' => 0,
							'pb' => 0,
							'rp' => 0,
							'lastCo' => 0,
							'timestampBonus' => time(),
							'ip' => $_SERVER['REMOTE_ADDR'],
							'timestamp' => time()
							));

							$envoi2 = $connexion->prepare("INSERT INTO requetes VALUES('', :pseudo, :email, :why, :timestamp)");
							$envoi2->execute(array(
							'pseudo' => $_POST['pseudo'],
							'email' => $_POST['email'],
							'why' => $_POST['why'],
							'timestamp' => time()
							));

							info('Demande envoyée. Repassez plus tard pour savoir si vous êtes accepté ou non.');
							include('pied.php');
							exit;

						}
						else
						avert('Email déjà existante');
					}
					else
					avert('Votre hôte (email) n\'est pas dans notre whitelist.');
				}
				else
				avert('Email non valide');
			}
			else
			avert('Mot de passe invalide (6 a 24 caractères)');
		}
		else
		avert('Pseudo déjà utlisé..');
	}
	else
	avert('Pseudo invalide (3 à 20 caractères)');
}


echo '
<h3>Demander un compte</h3>
<div class="contenu">
<form method="post">
<p><b>Script adapté pour nous :3 pas besoin de raisons</p>

<label>Nom de compte souhaité :</label>		<input type="text" name="pseudo"><br />
<label>Mot de passe :</label>	<input type="password" name="password"><br />
<label>E-mail :</label>		<input type="text" name="email"><br /><br />
Pourquoi vous voulez rejoindre : <b><font color="red">Si vous ne donnez aucune raison de votre venue, il en va de même pour nous, que nous avons aucune raison de vous donner l\'accès au site.</font></b><br />
<textarea name="why"></textarea>
<div class="separate"></div>

<input type="submit">
</form>
</div>
';

include('pied.php');
?>