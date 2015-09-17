<?php
include('base.php');
include('tete.php');

siMembre();
siNCAdmin($connexion);

if(isset($_POST['pseudo']))
{
	$count1 = $connexion->prepare('SELECT COUNT(*) FROM membres WHERE pseudo = "' . $_POST['pseudo'] . '"');
	$count1->execute();
	$count_pseudo = $count1->fetchColumn();

	if($count_pseudo > 0)
	{
		$pseudo = htmlspecialchars($_POST['pseudo']);
		redirection('banhammer.php?target=' . $pseudo);
	}
	else
	avert('Pseudo inconnu');
}

if(isset($_GET['target']))
{
	$count1 = $connexion->prepare('SELECT COUNT(*) FROM membres WHERE pseudo = "' . $_GET['target'] . '"');
	$count1->execute();
	$count_pseudo = $count1->fetchColumn();

	

	if($count_pseudo > 0)
	{

		$pseudo = htmlspecialchars($_GET['target']);

		$r_donnees_membres = $connexion->prepare('SELECT * FROM membres WHERE pseudo = "' . $pseudo . '"');
		$r_donnees_membres->execute();
		$donnees_membres = $r_donnees_membres->fetch(PDO::FETCH_OBJ);

		$r_donnees_perso = $connexion->prepare('SELECT * FROM personnages WHERE idPseudo = ' . $donnees_membres->id . '');
		$r_donnees_perso->execute();
		$donnees_perso = $r_donnees_perso->fetch(PDO::FETCH_OBJ);

		$countMsg = $connexion->query('SELECT COUNT(*) FROM messages WHERE idAuteur = ' . $donnees_membres->id . '')->fetchColumn();
		$countMp = $connexion->query('SELECT COUNT(*) FROM mpMessage WHERE idPseudo = ' . $donnees_membres->id . '')->fetchColumn();
		$countTopic = $connexion->query('SELECT COUNT(*) FROM sujets WHERE idAuteur = ' . $donnees_membres->id . '')->fetchColumn();

		if($donnees_membres->experience < $niveau[$donnees_membres->niveau]['exp'])
		{
			$cheaterEXP = '<b><font color="red">CHEATER</font></b>';
		}
		else
		{
			$cheaterEXP = '<b><font color="green">Legit</font></b>';
		}

		if($donnees_perso->ptsCaracteristiques > 495)
		{
			$cheaterPtsCarac = '<b><font color="red">CHEATER</font></b>';
		}
		else
		{
			$cheaterPtsCarac = '<b><font color="green">Legit</font></b>';
		}

		echo '
		<h3>' . $pseudo . '</h3>
		<div class="contenu">
		<span style="float: left; margin-right: 15px;"><img src="' . $donnees_membres->avatar . '" width="170" height="170" style="border: 1px solid #cacaca;" /></span>
		<label><b>STATUT EAC :: EXP</b></label>		' . $cheaterEXP . '<br />
		<label><b>STATUT EAC :: PTS_C</b></label>		' . $cheaterPtsCarac . '<br /><br />
		<label>Inscrit le :</label>		' . date('d/m/Y\ à H\hi', $donnees_membres->timestamp) . '<br />
		<label>Personnage crée le :</label>		' . date('d/m/Y\ à H\hi', $donnees_perso->timestamp) . '<br />
		<label>IP :</label>		' . $donnees_membres->ip . '<br />
		
		<label>Messages postés :</label>	<b>' . $countMsg . '</b> messages<br />
		<label>Sujets postés :</label>	<b>' . $countTopic . '</b> sujets<br />
		<label>Mp envoyés :</label>	<b>' . $countMp . '</b> Mp

		</div>
		<br />
		<h3>' . $donnees_perso->nomPerso . '</h3>
		<div class="contenu">
		<img src="images/caracteristiques/vie.png" height="20" width="20" /> <span style="line-height: 20px;"><b>' . $donnees_perso->vitalite . '</b></span><br />
		<img src="images/caracteristiques/force.png" height="20" width="20" /> <span style="line-height: 20px;"><b>' . $donnees_perso->c_force . '</b></span><br />
		<img src="images/caracteristiques/intelligence.png" height="20" width="20" /> <span style="line-height: 20px;"><b>' . $donnees_perso->intelligence . '</b></span><br />
		<img src="images/caracteristiques/agilite.png" height="20" width="20" /> <span style="line-height: 20px;"><b>' . $donnees_perso->agilite . '</b></span><br />
		<img src="images/caracteristiques/chance.png" height="20" width="20" /> <span style="line-height: 20px;"><b>' . $donnees_perso->chance . '</b></span><br />
		<img src="images/caracteristiques/plus.png" height="20" width="20" /> <span style="line-height: 20px;"><b>' . $donnees_perso->ptsCaracteristiques . '</b></span> points à dépenser
		</div>
		<br /><br />
		<h3>HAMMER</h3>
		<div class="contenu">
		<a href="banhammer.php?target=' . $pseudo . '&action=ban"><img src="images/banhammer/ban.png" width="100" height="100" /></a>   
		<a href="banhammer.php?target=' . $pseudo . '&action=banip"><img src="images/banhammer/banIp.png" width="100" height="100" /></a>   
		<a href="banhammer.php?target=' . $pseudo . '&action=kill"><img src="images/banhammer/kill.png" width="100" height="100" /></a>   
		<a href="banhammer.php?target=' . $pseudo . '&action=derank"><img src="images/banhammer/derank.png" width="100" height="100" /></a>   
		<a href="banhammer.php?target=' . $pseudo . '&action=reset_ec_inv"><img src="images/banhammer/reset_ec_inv.png" width="100" height="100" /></a>
		</div>

		';
	}
}

if(!isset($_GET['target']))
{
	echo '

	<br />
	<img style="margin-bottom: 10px;" src="images/divers/BANHAMMER.png" />

	<h3></h3>
	<div class="contenu">
	<form method="post">
	<label>Veuillez locker un pseudo :</label>	<input type="text" name="pseudo"><br />
	<input type="submit">
	</form>
	</div> 

	';
}

include('pied.php');
?>