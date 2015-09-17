<?php
include('base.php');
include('tete.php');

siNCAdmin($connexion);

if(isset($_POST['nom_ennemi']))
{
	if($_POST['nom_ennemi'] != '')
	{
		if($_POST['niv_ennemi'] > 0 OR $_POST['niv_ennemi'] < 101)
		{
			if($_POST['rbn_ennemi'] >= 0 OR $_POST['rbn_ennemi'] < 21)
			{
				if($_POST['vie_ennemi'] > 0)
				{
					if($_POST['for_ennemi'] >= 0)
					{
						if($_POST['int_ennemi'] >= 0)
						{
							if($_POST['pui_ennemi'] >= 0)
							{
								if($_POST['agi_ennemi'] >= 0)
								{
									if($_POST['cha_ennemi'] >= 0)
									{
										if($_POST['exp_min'] >= 0)
										{
											if($_POST['exp_max'] >= 0)
											{
												if($_POST['ec_min'] >= 0)
												{
													if($_POST['ec_max'] >= 0)
													{
														if($_POST['drops'] >= 0)
														{
															if($_POST['arme'] > 0)
															{
																$envoi = $connexion->prepare("INSERT INTO ennemis VALUES('', :nomEnnemi, :bioEnnemi, :nivEnnemi, :rbnEnnemi, :vie, :force, :intel, :agi, :pui, :chance, :expMin, :expMax, :ecMin, :ecMax, :drop, :idArme)");
																$envoi->execute(array(
																'nomEnnemi' => addslashes($_POST['nom_ennemi']),
																'bioEnnemi' => addslashes($_POST['bio']),
																'nivEnnemi' => $_POST['niv_ennemi'],
																'rbnEnnemi' => $_POST['rbn_ennemi'],
																'vie' => $_POST['vie_ennemi'],
																'force' => $_POST['for_ennemi'],
																'intel' => $_POST['int_ennemi'],
																'agi' => $_POST['agi_ennemi'],
																'pui' => $_POST['pui_ennemi'],
																'chance' => $_POST['cha_ennemi'],
																'expMin' => $_POST['exp_min'],
																'expMax' => $_POST['exp_max'],
																'ecMin' => $_POST['ec_min'],
																'ecMax' => $_POST['ec_max'],
																'drop' => $_POST['drops'],
																'idArme' => $_POST['arme']
																));

																info('Ennemi ajouté !');
															}
															else
															avert('1');
														}
														else
														avert('2');
													}
													else
													avert('3');
												}
												else
												avert('4');
											}
											else
											avert('5');
										}
										else
										avert('6');
									}
									else
									avert('7');
								}
								else
								avert('8');
							}
							else
							avert('9');
						}
						else
						avert('10');
					}
					else
					avert('11');
				}
				else
				avert('12');
			}
			else
			avert('13');
		}
		else
		avert('14');
	}
	else
	avert('15');
}

?>

<h3>Ajouter un ennemi dans la BDD (BETA)</h3>
<div class="contenu">
<form method="post">
<h2>Informations primaires</h2>
<div class="separate"></div>
	<label>Nom de l'ennemi :</label>		<input type="text" name="nom_ennemi"> ! - <b>50 chars max</b> - !<br />
	<label>Niveau de l'ennemi :</label>	<input type="text" name="niv_ennemi" style="width: 80px;" value="1"> ! - <b>1 à 100</b> - !<br />
	<label>Niveau Reborn de l'ennemi :</label>	<input type="text" name="rbn_ennemi" style="width: 80px;" value="0"> ! - <b>0 à 20</b> - !<br /><br />
	Biographie :<br /><br />
	<textarea name="bio" placeholder="Facultatif"></textarea>
<div class="separate"></div>
<h2>Statistiques</h2>
<div class="separate"></div>

<label>Arme :</label>		<select name="arme">

	<?php

	$req_armes = $connexion->query('SELECT * FROM items WHERE type = 20 OR type = 21 OR type = 22 OR type = 23 OR type = 24 OR type = 25 OR type = 26 OR type = 27 ORDER BY id DESC');
	$req_armes->execute();

	while($donnees_armes = $req_armes->fetch(PDO::FETCH_OBJ))
	{
		echo '<option value=' . $donnees_armes->id . '>' . $donnees_armes->nom_item . '</option>';
	}


	?>
</select><br />
<label>Vitalité (points de vie) :</label>	<input type="text" name="vie_ennemi" style="width: 100px;" value="100"><br />
<label>Force :</label>	<input type="text" name="for_ennemi" style="width: 100px;" value="0"><br />
<label>Intelligence :</label>	<input type="text" name="int_ennemi" style="width: 100px;" value="0"><br />
<label>Puissance :</label>	<input type="text" name="pui_ennemi" style="width: 100px;" value="0"><br />
<label>Agilité :</label>	<input type="text" name="agi_ennemi" style="width: 100px;" value="0"><br />
<label>Chance :</label>	<input type="text" name="cha_ennemi" style="width: 100px;" value="0">
<div class="separate"></div>
<h2>Gains</h2>
<div class="separate"></div>

<label>Expérience donné :</label>	<input type="text" name="exp_min" style="width: 50px;" value="0"> à <input type="text" name="exp_max" style="width: 50px;" value="0"><br />
<label>Argent donné :</label>	<input type="text" name="ec_min" style="width: 50px;" value="0"> à <input type="text" name="ec_max" style="width: 50px;" value="0"><br />
<label>Drop (idObjet) :</label>	<input type="text" name="drops" style="width: 115px;" value="0"> ! - <b>0 = sans drops</b> - !<br />
<br />

<center><input type="submit"></center>
</form>
</div>

<?php
include('pied.php');
?>
