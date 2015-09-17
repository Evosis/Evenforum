<?php
include('../base.php');

if(isset($_POST['pseudo']))
{
	if(isset($_SESSION['id']))
	{
		echo '1';
		exit;
	}

	$pseudo = secure($_POST['pseudo']);
	$passe = secure($_POST['pass']);
	$passe2 = secure($_POST['pass2']);
	$email = secure($_POST['email']);

	if(!empty($_POST['pseudo']) AND !empty($_POST['pass']) AND !empty($_POST['email']))
	{
		if($_POST['pass'] == $_POST['pass2'])
		{
			if(preg_match("#^[a-zA-Z0-9\[\]_-]{3,15}$#", $_POST['pseudo'])) // Si le pseudo respecte les conditions
			{
				if(preg_match('#^[a-zA-Z0-9]{6,24}$#', $_POST['pass'])) // Si le passe respecte les conditions
				{
					if(preg_match('#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,4}$#', $_POST['email'])) // Si l'adresse email est une adresse valide
					{
						$reponse = mysql_query('SELECT COUNT(*) FROM membres WHERE pseudo="' . $pseudo .'"');
						$result = mysql_result($reponse, 0);

						if($result == 0)
						{

							$clef = sha1(microtime(NULL)*100000);

							mysql_query("INSERT INTO membres VALUES('', '" . $pseudo . "', '" . hacher($passe) . "', '" . $email . "', '10', '1', '1', '0', '0', '" . $clef . "',  'images/no_avatar.png', '', '', '', '', '', '', '', '0', '" . time() . "', '" . $_SERVER['REMOTE_ADDR'] . "', '0', '0')");
							echo '

							<label>Nom de compte:</label> ' . $pseudo . '<br /><br />
							<label>Mot de passe:</label> ' . $passe . '<br /><br />
							<label>Email:</label> ' . $email . '<br /><br />
							<span style="float: right;"><input type="button" value="Connexion" class="inputCo" onclick="switchCo(); return false;" /></span>

							';
							// Veuillez vérifier votre boîte mail afin de valider votre pseudo. Pensez à vérifier vos spams si le mail est pas allé là-bas.

							// Envoi mail
							/*
							$message = '
							<h1 style="margin:10px 0pt 0pt"><a href="http://evenforum.olympe.in/" target="_blank"><strong>Demande de confirmation d\'un compte sur Evenforum !</strong></h1></a>
							<p> Bonjour, </p><p>Voici vos identifiants de connexion pour http://evenforum.olympe.in/ :<br>
							Votre nom de compte : ' . $pseudo . '<br />
							Votre mot de passe : ' . $passe . '</p><br />
							Cependant, pour utiliser votre compte, validez votre email en cliquant ici :<br /><br />
							<center><a href="http://evenforum.olympe.in/inscription.php?clef=' . $clef . '">Valider</a></center><br /><br />
							<p>Merci de votre confiance, et à bientôt sur <strong><a href="http://evenforum.olympe.in/" target="_blank">EvenForum</a> !</strong></p>
							';
							$sujet = 'Confirmez votre compte de Evenforum';
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
							$headers .= 'From: Evenforum';

							mail($email, $sujet, $message, $headers);*/
							exit;
						}
						else
						// Le nom de compte est déjà utilisé :(
							echo '2';
							exit;
					}
					else
					// L'adresse email entrée n'est pas valide !
						echo '3';
						exit;
				}
				else
				// Le mot de passe est trop court ou trop long !
					echo '4';
					exit;
			}
			else
			// Le nom de compte ne respecte pas les conditions !
				echo '5';
				exit;
		}
		else
		// Les deux mots de passe ne correspondent pas !
			echo '6';
			exit;
	}
	else
	// Un champ obligatoire a pas été rempli !
		echo '7';
		exit;
}
if(isset($_POST['vePseudo']))
{
	$reqp = mysql_query('SELECT COUNT(*) AS nbMembres FROM membres WHERE pseudo = "' . secure($_POST['vePseudo']) . '"');
	$donp = mysql_fetch_assoc($reqp);

	if($donp['nbMembres'] == 1)
	{
		echo '1';
		exit;
	}
	else
	{
		echo '2';
		exit;
	}
}
?>