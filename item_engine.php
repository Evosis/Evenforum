<?php
include('base.php');
include('tete.php');

siNCAdmin($connexion);

if(isset($_POST['nom_item']))
{
	if($_POST['nom_item'] != "")
	{
		if(preg_match("#^[a-zA-Z0-9ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ \[\]\'_-]{3,30}$#", $_POST['nom_item']))
		{
			$rcountItem = $connexion->prepare('SELECT COUNT(*) FROM items WHERE nom_item = "' . $_POST['nom_item'] . '"');
			$rcountItem->execute();
			$countItem = $rcountItem->fetchColumn();

			if($countItem == 0)
			{
				if($_POST['rarete'] > 0 AND $_POST['rarete'] < 10)
				{
					if($_POST['type'] > 0 AND $_POST['type'] < 35)
					{
						$prix = (int) $_POST['price'];
						if($prix >= 0)
						{
							if($_POST['compa'] > 0 AND $_POST['compa'] < 3)
							{
								if($_POST['revente'] >= 0 AND $_POST['revente'] < 2)
								{
									if($_POST['dp_objet'] != "")
									{
										if($_POST['niveau_requis'] > 0 AND $_POST['stat_vita'] >= 0 AND $_POST['stat_intel'] >= 0 AND $_POST['stat_force'] >= 0 AND $_POST['stat_agi'] >= 0 AND $_POST['stat_chance'] >= 0 AND $_POST['stat_puissance'] >= 0 AND $_POST['stat_soins'] >= 0 AND $_POST['stat_esquive'] >= 0 AND $_POST['stat_cc'] >= 0 AND $_POST['stat_defense'] >= 0 AND $_POST['stat_multicc'] >= 0)
										{
											if($_POST['creator'] != "")
											{
												if(preg_match("#^[a-zA-Z0-9ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ \[\]_-]{3,30}$#", $_POST['creator']))
												{
														if($_POST['damageMax'] == null)
														{
															$_POST['damageMax'] = 0;
														}
														if($_POST['damageMin'] == null)
														{
															$_POST['damageMin'] = 0;
														}

														$envoi = $connexion->prepare("INSERT INTO items VALUES('', :nomItem, :rarete, :type, :prixBase, :damageMin, :damageMax, :niveauRequis, :plusVita, :plusIntel, :plusForce, :plusPuissance, :plusAgi, :plusChance, :plusSoins, :plusDefense, :plusCC, :plusMultiCC, :compaQuest, :revente, :dp, :createur, :emetteur, :timestamp)");
														$envoi->execute(array(
														'nomItem' => $_POST['nom_item'],
														'rarete' => $_POST['rarete'],
														'type' => $_POST['type'],
														'prixBase' => $_POST['price'],
														'damageMin' => $_POST['damageMin'],
														'damageMax' => $_POST['damageMax'],
														'niveauRequis' => $_POST['niveau_requis'],
														'plusVita' => $_POST['stat_vita'],
														'plusIntel' => $_POST['stat_intel'],
														'plusForce' => $_POST['stat_force'],
														'plusPuissance' => $_POST['stat_puissance'],
														'plusAgi' => $_POST['stat_agi'],
														'plusChance' => $_POST['stat_chance'],
														'plusSoins' => $_POST['stat_soins'],
														'plusDefense' => $_POST['stat_defense'],
														'plusCC' => $_POST['stat_cc'],
														'plusMultiCC' => $_POST['stat_multicc'],
														'compaQuest' => $_POST['compa'],
														'revente' => $_POST['revente'],
														'dp' => $_POST['dp_objet'],
														'createur' => $_POST['creator'],
														'emetteur' => $_SESSION['pseudo'],
														'timestamp' => time()
														));
														info('Objet ajouté !');

												}
												else
												avert('Nom de créateur incorrect.');
											}
											else
											{
												$envoi = $connexion->prepare("INSERT INTO items VALUES('', :nomItem, :rarete, :type, :prixBase, :damageMin, :damageMax, :compaQuest, :revente, :dp, :createur, :emetteur, :timestamp)");
												$envoi->execute(array(
												'nomItem' => $_POST['nom_item'],
												'rarete' => $_POST['rarete'],
												'type' => $_POST['type'],
												'prixBase' => $_POST['price'],
												'damageMin' => $_POST['damageMin'],
												'damageMax' => $_POST['damageMax'],
												'compaQuest' => $_POST['compa'],
												'revente' => $_POST['revente'],
												'dp' => $_POST['dp_objet'],
												'createur' => 'Inconnu',
												'emetteur' => $_SESSION['pseudo'],
												'timestamp' => time()
												));
												info('Objet ajouté !');


											}

										}
										else
										avert('Stats incorrectes');
									}
									else
									avert('La description est vide.');
								}
								else
								avert('Revente incorrecte.');
							}
							else
							avert('Compatibilité incorrecte');
						}
						else
						avert('Prix incorrect');
					}
					else
					avert('Type incorrect.');
				}
				else
				avert('Rareté incorrecte.');
			}
			else
			avert('Ce nom d\'objet existe déjà !');
		}
		else
		avert('Nom d\'objet incorrect.');
	}
	else
	avert('Nom d\'objet vide.');
}

echo '
<h3>Ajouter un objet dans la base de données (BETA)</h3>
<div class="contenu">
<form method="post">
Merci d\'ajouter que des objets un minimum cohérent !
<div class="separate"></div>

<b>Informations principales</b><br />
<label>Nom de l\'objet</label>	<input type="text" name="nom_item" placeholder="30 caractères max" /><br />
<label>Créateur de l\'objet :</label>	<input type="text" name="creator" placeholder="Non obligatoire, 30 caractères max"><br />
<label>Rareté</label>	<select name="rarete" width="150px">
							<option value="1" selected>Trop commun (Nv 1 - 15)</option>
							<option value="2">Commun (Nv 15 - 35)</option>
							<option value="3">Peu commun (Nv 35 - 45)</option>
							<option value="4">Assez rare (Nv 45 - 60)</option>
							<option value="5">Rare (Nv 60 - 75)</option>
							<option value="6">Très rare (Nv 75 - 85)</option>
							<option value="7">Légendaire (Nv 85 - 99)</option>
							<option value="8">Unique (Nv 100)</option>
							<option value="9">Introuvable (indroppable)</option>
						</select><br />

<label>Type d\'objet</label>	<select name="type" style="width: 200px;">
									<optgroup label="Sans intéraction">
									<option value="1" selected>Ressources</option>

									<optgroup label="Armes">
									<option value="20">Épées</option>
									<option value="21">Dagues</option>
									<option value="22">Haches</option>
									<option value="23">Haches d\'arme</option>
									<option value="24">Espadons</option>
									<option value="25">Arcs</option>
									<option value="26">Bâtons</option>
									<option value="27">Baguettes</option>

									<optgroup label="Armures et accessoires">
									<option value="28">Casque / chapeau</option>
									<option value="29">Plastron / Vêtement</option>
									<option value="30">Gants</option>
									<option value="31">Anneaux</option>
									<option value="32">Amulettes</option>
									<option value="33">Jambières / Pantalon</option>
									<option value="34">Chaussures/ Bottes</option>

									<optgroup label="Intéraction">
									<option value="3">Consommables</option>

									<optgroup label="Autres / Spéciaux">
									<option value="4">Inclassable</option>
									<option value="6">Quest Item</option>
									<option value="5">Premium Item</option>
								</select><br />

<label>Prix de base</label>		<input type="text" name="price" placeholder="Indiquer la valeur minimale de l\'objet" value="0"><br /><br />

<div class="separate"></div>



<b>Stats editor</b><br />

Dégâts (uniquement pour une arme) :	<input type="text" name="damageMin" style="width: 50px;"> à <input type="text" name="damageMax" style="width: 50px;"><br /><br />
<label>Niveau minimum pour équiper :</label>	<input type="text" style="width: 50px;" name="niveau_requis"><br />
<label>+ Vitalité :</label> <input type="text" name="stat_vita" style="width: 50px;"><br />
<label>+ Force :</label> <input type="text" name="stat_force" style="width: 50px;"><br />
<label>+ Intelligence :</label> <input type="text" name="stat_intel" style="width: 50px;"><br />
<label>+ Agilité :</label> <input type="text" name="stat_agi" style="width: 50px;"><br />
<label>+ Chance :</label> <input type="text" name="stat_chance" style="width: 50px;"><br />
<label>+ Puissance :</label> <input type="text" name="stat_puissance" style="width: 50px;"><br />
<label>+ Soins :</label> <input type="text" name="stat_soins" style="width: 50px;"><br />
<label>+ Esquive :</label> <input type="text" name="stat_esquive" style="width: 50px;"><br />
<label>+ Coups critique :</label> <input type="text" name="stat_cc" style="width: 50px;"><br />
<label>+ Défense :</label> <input type="text" name="stat_defense" style="width: 50px;"><br />
<label>+ Multiplicateur CC :</label> <input type="text" name="stat_multicc" style="width: 50px;"><br />



<div class="separate"></div>
<b>Extras</b><br />
Activer la compatibilité avec les quêtes<br />
<input type="radio" name="compa" value="1"> Rendre compatible<br />
<input type="radio" name="compa" value="2" checked> Rendre incompatible<br />
<br />

Activer la revente de l\'objet<br />
<input type="radio" name="revente" value="1" checked> Permettre la revente et l\'échange<br />
<input type="radio" name="revente" value="0"> Ne pas permettre et figer l\'objet dans l\'inventaire du joueur <b>(ATTENTION A NE PAS INCLURE DES OBJETS DISPENSABLES)</b><br />
<br />

Description de l\'objet :<br />
<textarea name="dp_objet"></textarea>

<div class="separate"></div>
<center><input type="submit"></center>
</form>
</div>

';

$r_donnees_item = $connexion->prepare('SELECT * FROM items ORDER BY id DESC LIMIT 0,10');
$r_donnees_item->execute();

echo '

<br />

<h3>10 derniers objets</h3>
<table>
	<tr>
		<th>ID</th>
		<th>Nom objet</th>
		<th>Prix</th>
		<th>DMin</th>
		<th>DMax</th>
		<th>Revente?</th>
		<th>Rareté</th>
		<th>Type</th>
		<th>Créateur</th>
		<th>Émetteur</th>
	</tr>

';

while($donnees_item = $r_donnees_item->fetch(PDO::FETCH_OBJ))
{

	switch($donnees_item->revente)
	{
		case 1:
		$revente = "Oui";
		break;

		case 0:
		$revente = "Non";
		break;
	}

	echo '
	<tr>
		<td>' . $donnees_item->id . '</td>
		<td>' . $donnees_item->nom_item . '</td>
		<td>' . $donnees_item->prixBase . '</td>
		<td>' . $donnees_item->damageMin . '</td>
		<td>' . $donnees_item->damageMax . '</td>
		<td>' . $revente . '</td>
		<td>' . $donnees_item->rarete . '</td>
		<td>' . $donnees_item->type . '</td>
		<td>' . $donnees_item->creator . '</td>
		<td>' . $donnees_item->emetteur_item . '</td>
	</tr>
	';
}

echo '</table>';

include('pied.php');
?>
