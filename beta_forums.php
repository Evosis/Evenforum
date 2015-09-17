<?php
include('base.php');
include('tete.php');
?>

<h3>Forum : Blabla général</h3>
<div class="contenu">
	Discutez de tout et de rien !	<span style="float: right;"><font color="blue">Modérateurs</font> : Aucun</span><br /><br />
	<a href="#">Règles du forum (dernière mise à jour le 24 mars 2015 à 18:47:10)</a><br />
	<div class="separate"></div>
	Rechercher dans le forum : <input type="text" name="search"> <input type="submit" value="Rechercher"> <span style="float: right;"><a href="#" onclick="javascript:location.reload();"><img src="images/forum/reloadClair.png"/></a></span>

</div>

<table>
	<tr>
		<th style="width: 20px;"></th>
		<th style="width: 550px;">Titre de sujet</th>
		<th style="width: 150px;">Auteur</th>
		<th style="width: 50px;">Rep</th>
		<th style="width: 200px;">Dernier msg</th>
	</tr>
<?php

	$req_sujet = $connexion->prepare('SELECT * FROM sujets WHERE idForum = 1 AND etat != "0" ORDER BY ROUND( etat ) DESC, timestamp DESC LIMIT 0, 20');
	$req_sujet->execute();

	while($don_sujet = $req_sujet->fetch(PDO::FETCH_OBJ))
	{
		$nbMessage = $connexion->query('SELECT COUNT(*) FROM messages WHERE idSujet=' . $don_sujet->id)->fetchColumn();
		$nbMessage--;

		if($don_sujet->etat == "1.0")
		{
			$image = "1.0";
		}
		elseif($don_sujet->etat == "2.0")
		{
			$image = "2.0";
		}
		elseif($don_sujet->etat == "2.1")
		{
			$image = "2.1";
		}
		elseif($nbMessage >= 0 AND $nbMessage < 20)
		{
			$image = "1.1";
			$connexion->exec('UPDATE sujets SET etat="1.1" WHERE id=' . $don_sujet->id);
		}
		elseif($nbMessage >= 20 AND $nbMessage < 50)
		{
			$image = "1.2";
			$connexion->exec('UPDATE sujets SET etat="1.2" WHERE id=' . $don_sujet->id);
		}
		elseif($nbMessage >= 50 AND $nbMessage < 100)
		{
			$image = "1.3";
			$connexion->exec('UPDATE sujets SET etat="1.3" WHERE id=' . $don_sujet->id);
		}
		elseif($nbMessage >= 100)
		{
			$image = "1.4";
			$connexion->exec('UPDATE sujets SET etat="1.4" WHERE id=' . $don_sujet->id);
		}

		echo '
		<tr id="topics">
			<td style="width: 20px;"><img src="images/forum/' . $image . '.png"  style="vertical-align: middle;"/></td>
			<td style="width: 550px; text-align: left;"><a href="sujet.php?id=' . $don_sujet->id . '">' . stripslashes(htmlspecialchars($don_sujet->titre)) . '</a></td>
			<td style="width: 150px;">' . htmlspecialchars($don_sujet->auteur) . '</td>
			<td style="width: 50px;">' . number_format($nbMessage) . '</td>
			<td style="width: 200px;">' . date('d/m/Y\ à H\hi', $don_sujet->timestamp) . '</td>
		</tr>

	';

	}

?>

</table>

<?php
include('pied.php');
?>