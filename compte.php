<?php
include('base.php');
include('tete.php');

siMembre();

echo '
<h3>Mon compte</h3>
<div class="contenu">
	<center><a href="#" onclick="compteMenu(\'option1\'); return false;" title="Modifier mes informations d\'identifications"><img src="images/compte/1.png" class="luminosite" /></a> &nbsp;&nbsp;&nbsp; 
	<a href="#" onclick="compteMenu(\'option2\'); return false;" title="Modifier mes informations personnelles"><img src="images/compte/3.png" class="luminosite" /></a> &nbsp;&nbsp;&nbsp; 
	<a href="#" onclick="compteMenu(\'option3\'); return false;" title="Modifier mes images"><img src="images/compte/4.png" class="luminosite" /></a> &nbsp;&nbsp;&nbsp; 
	<a href="#" onclick="compteMenu(\'option4\'); return false;" title="Modifier des options supplémentaires"><img src="images/compte/2.png" class="luminosite" /></a> &nbsp;&nbsp;&nbsp; 
	<img src="images/compte/0.png" class="luminosite" /> <!-- TimeR --></center>
</div>
';

if(isset($_POST['email']))
{
	if(preg_match('#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,4}$#', $_POST['email'])) // @ valide?
	{
		if(stristr($_POST['email'], '@gmail.com') OR stristr($_POST['email'], '@hotmail.com') OR stristr($_POST['email'], '@hotmail.fr') OR stristr($_POST['email'], '@outlook.com') OR stristr($_POST['email'], '@yahoo.com') OR stristr($_POST['email'], '@msn.com') OR stristr($_POST['email'], '@outlook.fr') OR stristr($_POST['email'], '@live.com') OR stristr($_POST['email'], '@live.fr') OR stristr($_POST['email'], '@sfr.fr') OR stristr($_POST['email'], '@free.fr') OR stristr($_POST['email'], '@orange.fr') OR stristr($_POST['email'], '@laposte.net')) // 2
		{
			if(!empty($_POST['oldPassword']) AND !empty($_POST['newPassword']))
			{
				if(preg_match('#^[a-zA-Z0-9_-]{6,24}$#', $_POST['newPassword'])) // Mdp correct ?
				{
					$req_checkPsswd = $connexion->query('SELECT motdepasse FROM membres WHERE id = ' . $_SESSION['id']);
					$donnees_checkPsswd = $req_checkPsswd->fetch(PDO::FETCH_OBJ);

					$mdp_crypt = $donnees_checkPsswd->motdepasse;

					if(password_verify($_POST['oldPassword'], $mdp_crypt))
					{
						$pass_hash = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);

						$update_psswd = $connexion->prepare('UPDATE membres SET motdepasse="' . $pass_hash . '", email="' . $_POST['email'] . '" WHERE id=' . $_SESSION['id']);
						$update_psswd->execute();
						info('Vos informations d\'identifications ont bien été modifiés !');
					}
					else
					{
						avert('Le mot de passe n\'est pas correct.');
					}
				}
				else
				{
					avert('Mot de passe trop court ou trop long.');
				}
			}
			else
			{
				$update_email = $connexion->prepare('UPDATE membres SET email="' . $_POST['email'] . '" WHERE id=' . $_SESSION['id']);
				$update_email->execute();
				info('Vos informations d\'identifications ont bien été modifiés !');
			}
		}
		else
		{
			avert('Email non autorisé. Veuillez vérifier');
		}
	}
	else
	{
		avert('Email non valide.');
	}
}

$reponse = $connexion->query('SELECT * FROM membres WHERE id=' . $_SESSION['id']);
$donnees = $reponse->fetch(PDO::FETCH_OBJ);

echo '
<span id="option1" style="display: none;">
	<h3>Modifier mes informations d\'identifications</h3>
	<div class="contenu">
		<form method="post">
			<label>Nom de compte :</label>			' . $_SESSION['pseudo'] . '<br /><br />
			<label>Mot de passe actuel :</label>	<input type="password" name="oldPassword"><br />
			<label>Nouveau mot de passe :</label>	<input type="password" name="newPassword" placeholder="6 à 24 caractères maximum."><br />
			<label>Adresse e-mail :</label>			<input type="text" name="email" value="' . htmlspecialchars($donnees->email) . '" placeholder="Un mail de confirmation sera envoyé."> <a href="#" title="Autorisés : @ hotmail.fr/com, outlook.fr/com, gmail.com, yahoo.fr, msn.com, live.fr/com, sfr.fr, free.fr, orange.fr et laposte.net.">?</a><br /><br />
			<label>Clef unique :</label>			' . $_SESSION['clef'] . '

			<div class="separate"></div>

			<center><input type="submit" /></center>
		</form>
	</div>
</span>
';
if(isset($_POST['genre']))
{
	$genre = $_POST['genre'];

			if($genre == 1 OR $genre == 2)
			{
				$update_infos = $connexion->prepare('UPDATE membres SET sexe=' . $_POST['genre'] . ', idPsn="' . $_POST['psn'] . '", idXBL="' . $_POST['xblive'] . '", idSteam="' . $_POST['steam'] . '", idSkype="' . $_POST['skype'] . '" WHERE id=' . $_SESSION['id']);
				$update_infos->execute();
				info('Vos informations personnelles ont bien été modifiés !');
			}
			else
			{
				avert('Alors comme ça on peut pas s\'inscrire comme tout le monde ? Si vous arrêtiez de changer le code source pour une fois ?');
			}

}

$reponse = $connexion->query('SELECT * FROM membres WHERE id=' . $_SESSION['id']);
$donnees = $reponse->fetch(PDO::FETCH_OBJ);

echo '
<span id="option2" style="display: none;">
	<h3>Modifier mes informations personnelles</h3>
	<div class="contenu">
		<form method="post">
			<label>ID PlayStation Network :</label> <input type="text" name="psn" value="' . htmlspecialchars($donnees->idPsn) . '"><br />
			<label>GT Xbox Live :</label> 			<input type="text" name="xblive" value="' . htmlspecialchars($donnees->idXBL) . '"><br />
			<label>ID Steam :</label> 				<input type="text" name="steam" value="' . htmlspecialchars($donnees->idSteam) . '"><br />
			<label>ID Skype :</label> 				<input type="text" name="skype" value="' . htmlspecialchars($donnees->idSkype) . '"><br />
			<label>Je suis ...</label>				<input type="radio" name="genre" value="1" id="genre"'; if($donnees->sexe == 1){ echo 'checked'; }echo '> <font color="#4643e3">Un gars</font><br />
			<label>Ou alors ...</label>				<input type="radio" name="genre" value="2" id="genre"'; if($donnees->sexe == 2){ echo 'checked'; }echo '> <font color="#ff276d">Une fille</font><br />
			<div class="separate"></div>

			<center><input type="submit" /></center>
		</form>
	</div>
</span>
';

if(!isset($_GET['bck']))
{
	if($_FILES['avatar'] != null)
	{
		if (isset($_FILES['avatar']))
		{  	
		    if ($_FILES['avatar']['size'] <= 5912000) // Testons si le fichier n'est pas trop gros
		    {
		 
			        // Testons si l'extension est autorisée
			        $infosfichier = pathinfo($_FILES['avatar']['name']);
			        $extension_upload = strtolower($infosfichier['extension']);
			        $extensions_autorisees = array('jpg', 'jpeg', 'png');

			    if (in_array($extension_upload, $extensions_autorisees))
			    {

			    	$path_final = 'upload/avatars/' . $_SESSION['pseudo'] . '_' . $_SESSION['id'] . '.jpg'; // Si oui, mettre le vrai path
			    	// On peut valider le fichier et le stocker définitivement
					@unlink('upload/avatars/' . $_SESSION['pseudo'] . '_' . $_SESSION['id'] . '.jpg');
			        move_uploaded_file($_FILES['avatar']['tmp_name'], $path_final);

			        	if($extension_upload == 'jpg' || $extension_upload == 'jpeg')
					   @$image = imagecreatefromjpeg($path_final);
						else if($extension_upload == 'png')
					   @$image = imagecreatefrompng($path_final);
						else if($extension_upload == 'gif')
					   @$image = imagecreatefromgif($path_final);
						else
						{
					 	  $image = false;
					 	  avert('Type de fichier non supporté.');
					 	  include('pied.php');
					 	  exit;
						}

		    			if($image != false ) 
		   				{
							$update_avatar = $connexion->prepare('UPDATE membres SET avatar="' . $path_final . '" WHERE id=' . $_SESSION['id']);
							$update_avatar->execute();
							info('Avatar modifié !');
						}
						else
						{
							@unlink('upload/avatars/' . $_SESSION['pseudo'] . '_' . $_SESSION['id'] . '.jpg');
							$update_avatar = $connexion->prepare('UPDATE membres SET avatar="common/images/no_avatar.png" WHERE id=' . $_SESSION['id']);
							$update_avatar->execute();
							avert('Erreur. Ce n\'est pas une image valide.');
						}
				}
				else
				{
					avert('Extension incorrecte. Extension autorisées: jpg, jpeg et png.');
				}
		    }
			else
			{
				avert('Fichier trop gros. Transfert annulé.');
			}
		}
		else
		{
			avert('L\'avatar n\'a pas été choisi. Transfert annulé.');
		}
	}
}

$reponse = $connexion->query('SELECT * FROM membres WHERE id=' . $_SESSION['id'] . '');
$donnees = $reponse->fetch(PDO::FETCH_OBJ);


echo '
<span id="option3" style="display: none;">
	<h3>Modifier mes images</h3>
	<div class="contenu">
		<form method="post" enctype="multipart/form-data">
		<h2>Avatar</h2>
			<span style="float: left;"><img src="' . $donnees->avatar . '"  height="150px" width="150px" /></span><br /><br />

			<span style="padding-left: 30px;">Avatar actuel</span><br /><br />

			<span style="padding-left: 30px;"><input type="file" name="avatar" /></span><br /><br /><br /><br /><br />
			<div class="separate"></div>
			<center><input type="submit" /></center>
		</form>
	</div>
</span>
';

if(isset($_POST['signature']) AND isset($_POST['boite']))
{
	if($_POST['boite'] == 0 OR $_POST['boite'] == 1)
	{
		if($_POST['bloc_compte'] == 1 OR $_POST['bloc_compte'] == 2 OR $_POST['bloc_compte'] == 3)
		{
			if($_POST['stats'] == 0 OR $_POST['stats'] == 1)
			{
				$update_option = $connexion->prepare('UPDATE options SET signature="' . addslashes($_POST['signature']) . '", boite=' . (int) $_POST['boite'] . ', typeBlocCompte=' . (int) $_POST['bloc_compte'] . ', statsReal=' . (int) $_POST['stats'] . ' WHERE id=' . $_SESSION['id']);
				$update_option->execute();
				info('Vos options supplémentaires ont bien été modifiés !');
			}
		}	
	}
}



$reponse = $connexion->query('SELECT * FROM membres WHERE id=' . $_SESSION['id'] . '');
$donnees = $reponse->fetch(PDO::FETCH_OBJ);

$reponse2 = $connexion->query('SELECT * FROM options WHERE idPseudo=' . $_SESSION['id']);
$donnees2 = $reponse2->fetch(PDO::FETCH_OBJ);

if(isset($_POST['presentation']))
{
	if($_POST['presentation'] != "")
	{
		$r_mod_prez = $connexion->prepare('UPDATE membres SET description = "' . addslashes($_POST['presentation']) . '" WHERE id = ' . $_SESSION['id'] . '');
		$r_mod_prez->execute();
		info('Présentation changée !');
	}
	else
	avert('La présentation ne peut être vide.');
}

echo '
<span id="option4" style="display: none;">
	<h3>Modifier des options supplémentaires</h3>
	<div class="contenu">

	<form method="post">
			<center>Présentation</center>
			<textarea name="presentation">' . stripslashes(htmlspecialchars($donnees->description)) . '</textarea>
			<div class="separate"></div>

			<center><input type="submit" /></center>
	</form>
		<form method="post">
			<center>Signature :</center>		<textarea name="signature">' . stripslashes(htmlspecialchars($donnees2->signature)) . '</textarea>

			<div class="separate"></div>

			<center><input type="submit" /></center>

			<div class="separate"></div>
		</form>


	</div>
</span>
';

/*

if($allowedMusic == false)
{
	$inBloc = '<b><font color="red">Compétence Ma musique > la vôtre requise.</font></b>';
}
else
{

	if(isset($_POST['titre_musique']))
	{
		if($_POST['titre_musique'] != "")
		{
			if($_POST['url_musique'] != "")
			{
				$prepare = $connexion->prepare('UPDATE options SET titreMusique = "' . $_POST['titre_musique'] . '", urlMusique = "' . $_POST['url_musique'] . '" WHERE idPseudo = ' . $_SESSION['id']);
				$prepare->execute();
				info('Musique activée !');
				
			}
		}
	}

	$r_donnees_options = $connexion->query('SELECT * FROM options WHERE idPseudo = ' . $_SESSION['id']);
	$donnees_options = $r_donnees_options->fetch(PDO::FETCH_OBJ);

	$inBloc = '
	<form method="post">
	Vous devez indiquer le lien youtube comme ceci: http://www.youtube.com/watch?v=<font color="red">xxxxxxxxx</font> (insérer que la partie rouge.)<br /><br />

		<label>Titre de votre musique :</label>	<input type="text" name="titre_musique" value="' . htmlspecialchars($donnees_options->titreMusique) . '" /><br />
		<label>URL minimisée de YouTube :</label>	<input type="text" name="url_musique" value="' . htmlspecialchars($donnees_options->urlMusique) . '" /><br /><br />

		<input type="submit" />
	</form>


	';

}

echo '
<span id="option5" style="display: none;">
	<h3>Modifier mes musiques</h3>
	<div class="contenu">
		' . $inBloc . '
	</div>
</span>
';



echo '
<span id="option6" style="display: none;">
	<h3>Choix du design du site</h3>
	<div class="contenu">
		<p>Vous pouvez choisir votre design sur cette page.</p><br/>

		<img src="common/images/image_design/orange.png" style="float: left; border: 1px solid orange;" />
		<p style="right: -20px; top: -10px; position: relative;"><span style="font-size: 14pt;">Design original, de couleur orange (dominante)</span><br />
		Crée par TimeR et Evosis<br />
		Statut : <font color="#39c752">A jour</font><br /><br />
		<a href="#" onclick="setActiveStyleSheet(\'css_base_orange\'); return false;"><button>Définir en tant que design par défaut</button></a></p>
		<div class="separate"></div>

		<img src="common/images/image_design/bleu.png" style="float: left; border: 1px solid blue;" />
		<p style="right: -20px; top: -10px; position: relative;"><span style="font-size: 14pt;">Variante du design original, de couleur bleu (dominante)</span><br />
		Crée par TimeR<br />
		Statut : <font color="#39c752">A jour</font><br /><br />
		<a href="#" onclick="setActiveStyleSheet(\'css_base_bleu\'); return false;"><button>Définir en tant que design par défaut</button></a></p>
		<div class="separate"></div>

		<img src="common/images/image_design/noir.png" style="float: left; border: 1px solid white;" />
		<p style="right: -20px; top: -10px; position: relative;"><span style="font-size: 14pt;">Variante du design original, de couleur noir (dominante)</span><br />
		Crée par TimeR<br />
		Statut : <font color="#39c752">A jour</font><br /><br />
		<a href="#" onclick="setActiveStyleSheet(\'css_base_noir\'); return false;"><button>Définir en tant que design par défaut</button></a></p>
		<div class="separate"></div>

		<img src="common/images/image_design/red.png" style="float: left; border: 1px solid red;" />
		<p style="right: -20px; top: -10px; position: relative;"><span style="font-size: 14pt;">Variante du design original, de couleur rouge sang (dominante)</span><br />
		Crée par TimeR<br />
		Statut : <font color="#e85858">NON DISPONIBLE !</font><br /><br />
		<br />
		<div class="separate"></div><br />

		<img src="common/images/image_design/even.png" style="float: left; border: 1px solid blue;" />
		<p style="right: -20px; top: -10px; position: relative;"><span style="font-size: 14pt;">Retour aux couleurs de l\'ancien Even ! :D</span><br />
		Crée par TimeR<br />
		Statut : <font color="#39c752">A jour</font><br /><br />
		<a href="#" onclick="setActiveStyleSheet(\'css_base_even\'); return false;"><button>Définir en tant que design par défaut</button></a></p>
	</div>
</span>
';


if($allowedHeader == true)
{
	$inBloc = 'true';
}
else
{
	$inBloc = '<b><font color="red">Compétence Vu et revu requise.</font></b>';
}

echo '
<div class="contenu" id="option7" style="display: none;">
' . $inBloc . '
</div>
';

*/

if($_GET['page'])
{
	$option = $_GET['page'];
	echo '<script>compteMenu(\'' . $option . '\')</script>';
}

include('pied.php');
?>