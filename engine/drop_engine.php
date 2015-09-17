<?php

if(isset($_SESSION['id']))
{
	$checkPerso = $connexion->query('SELECT COUNT(*) FROM personnages WHERE idPseudo = ' . $_SESSION['id'])->fetchColumn();

	if($checkPerso > 0)
	{
		
		
		$r_donnees_inventaire = $connexion->prepare('SELECT * FROM inventaire WHERE idPseudo = ' . $_SESSION['id']);
		$r_donnees_inventaire->execute();
		$donnees_inventaire = $r_donnees_inventaire->fetch(PDO::FETCH_OBJ);

		$r_donnees_membres = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $_SESSION['id']);
		$r_donnees_membres->execute();
		$donnees_membres = $r_donnees_membres->fetch(PDO::FETCH_OBJ);

		$countNbObj = $connexion->query('SELECT COUNT(*) FROM inventaire WHERE idPseudo = ' . $_SESSION['id'])->fetchColumn();

		if($countNbObj <= $items_bag)
		{
			$colorCountDrop = '<font color="#59ff6f">';
			if($drop_engine == 0)
			{
				if($donnees_membres->niveau <= 15)
				{
					$reqObjRand = $connexion->prepare('SELECT * FROM items WHERE rarete = 1 ORDER BY RAND() LIMIT 0,1');
					$reqObjRand->execute();
					$ObjRand = $reqObjRand->fetch(PDO::FETCH_ASSOC);
					
					$countItem = $connexion->query('SELECT COUNT(*) FROM inventaire WHERE idItem = ' . $ObjRand['id'] . ' AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

					$r_donnees_perso = $connexion->prepare('SELECT * FROM personnages WHERE idPseudo = ' . $_SESSION['id']);
					$r_donnees_perso->execute();
					$donnees_perso = $r_donnees_perso->fetch(PDO::FETCH_OBJ);

					if($countItem == 0)
					{
						$insert = $connexion->prepare("INSERT INTO inventaire VALUES('', :idpseudo, :iditem, :quantite, :firstownerpseudo, :firstownerperso, :timestamp)");
						$insert->execute(array(
						'idpseudo' => $_SESSION['id'],
						'iditem' => $ObjRand['id'],
						'quantite' => 1,
						'firstownerpseudo' => $_SESSION['pseudo'],
						'firstownerperso' => $donnees_perso->nomPerso,
						'timestamp' => time()
						));

						notification($_SESSION['id'], '7', 'Un objet a été ajouté à votre inventaire !\n[b]+ 1 : ' . $ObjRand['nom_item'] . '[/b]', $connexion);
					}
					else
					{
						$connexion->query('UPDATE inventaire SET quantite = (quantite + 1) WHERE idItem = ' . $ObjRand['id'] . ' AND idPseudo = ' . $_SESSION['id']);
						notification($_SESSION['id'], '7', 'Un objet a été ajouté à votre inventaire !\n[b]+ 1 : ' . $ObjRand['nom_item'] . '[/b]', $connexion);
					}
						
				}
				elseif($donnees_membres->niveau > 15 AND $donnees_membres->niveau <= 35)
				{
					$reqObjRand = $connexion->prepare('SELECT * FROM items WHERE rarete <= 2 ORDER BY RAND() LIMIT 0,1');
					$reqObjRand->execute();
					$ObjRand = $reqObjRand->fetch(PDO::FETCH_ASSOC);
					
					$countItem = $connexion->query('SELECT COUNT(*) FROM inventaire WHERE idItem = ' . $ObjRand['id'] . ' AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

					$r_donnees_perso = $connexion->prepare('SELECT * FROM personnages WHERE idPseudo = ' . $_SESSION['id']);
					$r_donnees_perso->execute();
					$donnees_perso = $r_donnees_perso->fetch(PDO::FETCH_OBJ);

					if($countItem == 0)
					{
						$insert = $connexion->prepare("INSERT INTO inventaire VALUES('', :idpseudo, :iditem, :quantite, :firstownerpseudo, :firstownerperso, :timestamp)");
						$insert->execute(array(
						'idpseudo' => $_SESSION['id'],
						'iditem' => $ObjRand['id'],
						'quantite' => 1,
						'firstownerpseudo' => $_SESSION['pseudo'],
						'firstownerperso' => $donnees_perso->nomPerso,
						'timestamp' => time()
						));

						notification($_SESSION['id'], '7', 'Un objet a été ajouté à votre inventaire !\n[b]+ 1 : ' . $ObjRand['nom_item'] . '[/b]', $connexion);
					}
					else
					{
						$connexion->query('UPDATE inventaire SET quantite = (quantite + 1) WHERE idItem = ' . $ObjRand['id'] . ' AND idPseudo = ' . $_SESSION['id']);
						notification($_SESSION['id'], '7', 'Un objet a été ajouté à votre inventaire !\n[b]+ 1 : ' . $ObjRand['nom_item'] . '[/b]', $connexion);
					}
						
				}
				elseif($donnees_membres->niveau > 35 AND $donnees_membres->niveau <= 45)
				{
					$reqObjRand = $connexion->prepare('SELECT * FROM items WHERE rarete <= 3 ORDER BY RAND() LIMIT 0,1');
					$reqObjRand->execute();
					$ObjRand = $reqObjRand->fetch(PDO::FETCH_ASSOC);
					
					$countItem = $connexion->query('SELECT COUNT(*) FROM inventaire WHERE idItem = ' . $ObjRand['id'] . ' AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

					$r_donnees_perso = $connexion->prepare('SELECT * FROM personnages WHERE idPseudo = ' . $_SESSION['id']);
					$r_donnees_perso->execute();
					$donnees_perso = $r_donnees_perso->fetch(PDO::FETCH_OBJ);

					if($countItem == 0)
					{
						$insert = $connexion->prepare("INSERT INTO inventaire VALUES('', :idpseudo, :iditem, :quantite, :firstownerpseudo, :firstownerperso, :timestamp)");
						$insert->execute(array(
						'idpseudo' => $_SESSION['id'],
						'iditem' => $ObjRand['id'],
						'quantite' => 1,
						'firstownerpseudo' => $_SESSION['pseudo'],
						'firstownerperso' => $donnees_perso->nomPerso,
						'timestamp' => time()
						));

						notification($_SESSION['id'], '7', 'Un objet a été ajouté à votre inventaire !\n[b]+ 1 : ' . $ObjRand['nom_item'] . '[/b]', $connexion);
					}
					else
					{
						$connexion->query('UPDATE inventaire SET quantite = (quantite + 1) WHERE idItem = ' . $ObjRand['id'] . ' AND idPseudo = ' . $_SESSION['id']);
						notification($_SESSION['id'], '7', 'Un objet a été ajouté à votre inventaire !\n[b]+ 1 : ' . $ObjRand['nom_item'] . '[/b]', $connexion);
					}
						
				}
				elseif($donnees_membres->niveau > 45 AND $donnees_membres->niveau <= 60)
				{
					$reqObjRand = $connexion->prepare('SELECT * FROM items WHERE rarete <= 4 ORDER BY RAND() LIMIT 0,1');
					$reqObjRand->execute();
					$ObjRand = $reqObjRand->fetch(PDO::FETCH_ASSOC);
					
					$countItem = $connexion->query('SELECT COUNT(*) FROM inventaire WHERE idItem = ' . $ObjRand['id'] . ' AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

					$r_donnees_perso = $connexion->prepare('SELECT * FROM personnages WHERE idPseudo = ' . $_SESSION['id']);
					$r_donnees_perso->execute();
					$donnees_perso = $r_donnees_perso->fetch(PDO::FETCH_OBJ);

					if($countItem == 0)
					{
						$insert = $connexion->prepare("INSERT INTO inventaire VALUES('', :idpseudo, :iditem, :quantite, :firstownerpseudo, :firstownerperso, :timestamp)");
						$insert->execute(array(
						'idpseudo' => $_SESSION['id'],
						'iditem' => $ObjRand['id'],
						'quantite' => 1,
						'firstownerpseudo' => $_SESSION['pseudo'],
						'firstownerperso' => $donnees_perso->nomPerso,
						'timestamp' => time()
						));

						notification($_SESSION['id'], '7', 'Un objet a été ajouté à votre inventaire !\n[b]+ 1 : ' . $ObjRand['nom_item'] . '[/b]', $connexion);
					}
					else
					{
						$connexion->query('UPDATE inventaire SET quantite = (quantite + 1) WHERE idItem = ' . $ObjRand['id'] . ' AND idPseudo = ' . $_SESSION['id']);
						notification($_SESSION['id'], '7', 'Un objet a été ajouté à votre inventaire !\n[b]+ 1 : ' . $ObjRand['nom_item'] . '[/b]', $connexion);
					}
						
				}
				elseif($donnees_membres->niveau > 60 AND $donnees_membres->niveau <= 75)
				{
					$reqObjRand = $connexion->prepare('SELECT * FROM items WHERE rarete <= 5 ORDER BY RAND() LIMIT 0,1');
					$reqObjRand->execute();
					$ObjRand = $reqObjRand->fetch(PDO::FETCH_ASSOC);
					
					$countItem = $connexion->query('SELECT COUNT(*) FROM inventaire WHERE idItem = ' . $ObjRand['id'] . ' AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

					$r_donnees_perso = $connexion->prepare('SELECT * FROM personnages WHERE idPseudo = ' . $_SESSION['id']);
					$r_donnees_perso->execute();
					$donnees_perso = $r_donnees_perso->fetch(PDO::FETCH_OBJ);

					if($countItem == 0)
					{
						$insert = $connexion->prepare("INSERT INTO inventaire VALUES('', :idpseudo, :iditem, :quantite, :firstownerpseudo, :firstownerperso, :timestamp)");
						$insert->execute(array(
						'idpseudo' => $_SESSION['id'],
						'iditem' => $ObjRand['id'],
						'quantite' => 1,
						'firstownerpseudo' => $_SESSION['pseudo'],
						'firstownerperso' => $donnees_perso->nomPerso,
						'timestamp' => time()
						));

						notification($_SESSION['id'], '7', 'Un objet a été ajouté à votre inventaire !\n[b]+ 1 : ' . $ObjRand['nom_item'] . '[/b]', $connexion);
					}
					else
					{
						$connexion->query('UPDATE inventaire SET quantite = (quantite + 1) WHERE idItem = ' . $ObjRand['id'] . ' AND idPseudo = ' . $_SESSION['id']);
						notification($_SESSION['id'], '7', 'Un objet a été ajouté à votre inventaire !\n[b]+ 1 : ' . $ObjRand['nom_item'] . '[/b]', $connexion);
					}
						
				}
				elseif($donnees_membres->niveau > 75 AND $donnees_membres->niveau <= 85)
				{
					$reqObjRand = $connexion->prepare('SELECT * FROM items WHERE rarete <= 6 ORDER BY RAND() LIMIT 0,1');
					$reqObjRand->execute();
					$ObjRand = $reqObjRand->fetch(PDO::FETCH_ASSOC);
					
					$countItem = $connexion->query('SELECT COUNT(*) FROM inventaire WHERE idItem = ' . $ObjRand['id'] . ' AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

					$r_donnees_perso = $connexion->prepare('SELECT * FROM personnages WHERE idPseudo = ' . $_SESSION['id']);
					$r_donnees_perso->execute();
					$donnees_perso = $r_donnees_perso->fetch(PDO::FETCH_OBJ);

					if($countItem == 0)
					{
						$insert = $connexion->prepare("INSERT INTO inventaire VALUES('', :idpseudo, :iditem, :quantite, :firstownerpseudo, :firstownerperso, :timestamp)");
						$insert->execute(array(
						'idpseudo' => $_SESSION['id'],
						'iditem' => $ObjRand['id'],
						'quantite' => 1,
						'firstownerpseudo' => $_SESSION['pseudo'],
						'firstownerperso' => $donnees_perso->nomPerso,
						'timestamp' => time()
						));

						notification($_SESSION['id'], '7', 'Un objet a été ajouté à votre inventaire !\n[b]+ 1 : ' . $ObjRand['nom_item'] . '[/b]', $connexion);
					}
					else
					{
						$connexion->query('UPDATE inventaire SET quantite = (quantite + 1) WHERE idItem = ' . $ObjRand['id'] . ' AND idPseudo = ' . $_SESSION['id']);
						notification($_SESSION['id'], '7', 'Un objet a été ajouté à votre inventaire !\n[b]+ 1 : ' . $ObjRand['nom_item'] . '[/b]', $connexion);
					}
						
				}
				elseif($donnees_membres->niveau > 85 AND $donnees_membres->niveau <= 99)
				{
					$reqObjRand = $connexion->prepare('SELECT * FROM items WHERE rarete <= 7 ORDER BY RAND() LIMIT 0,1');
					$reqObjRand->execute();
					$ObjRand = $reqObjRand->fetch(PDO::FETCH_ASSOC);
					
					$countItem = $connexion->query('SELECT COUNT(*) FROM inventaire WHERE idItem = ' . $ObjRand['id'] . ' AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

					$r_donnees_perso = $connexion->prepare('SELECT * FROM personnages WHERE idPseudo = ' . $_SESSION['id']);
					$r_donnees_perso->execute();
					$donnees_perso = $r_donnees_perso->fetch(PDO::FETCH_OBJ);

					if($countItem == 0)
					{
						$insert = $connexion->prepare("INSERT INTO inventaire VALUES('', :idpseudo, :iditem, :quantite, :firstownerpseudo, :firstownerperso, :timestamp)");
						$insert->execute(array(
						'idpseudo' => $_SESSION['id'],
						'iditem' => $ObjRand['id'],
						'quantite' => 1,
						'firstownerpseudo' => $_SESSION['pseudo'],
						'firstownerperso' => $donnees_perso->nomPerso,
						'timestamp' => time()
						));

						notification($_SESSION['id'], '7', 'Un objet a été ajouté à votre inventaire !\n[b]+ 1 : ' . $ObjRand['nom_item'] . '[/b]', $connexion);
					}
					else
					{
						$connexion->query('UPDATE inventaire SET quantite = (quantite + 1) WHERE idItem = ' . $ObjRand['id'] . ' AND idPseudo = ' . $_SESSION['id']);
						notification($_SESSION['id'], '7', 'Un objet a été ajouté à votre inventaire !\n[b]+ 1 : ' . $ObjRand['nom_item'] . '[/b]', $connexion);
					}
						
				}
				elseif($donnees_membres->niveau == 100)
				{
					$reqObjRand = $connexion->prepare('SELECT * FROM items WHERE rarete <= 8 ORDER BY RAND() LIMIT 0,1');
					$reqObjRand->execute();
					$ObjRand = $reqObjRand->fetch(PDO::FETCH_ASSOC);
					
					$countItem = $connexion->query('SELECT COUNT(*) FROM inventaire WHERE idItem = ' . $ObjRand['id'] . ' AND idPseudo = ' . $_SESSION['id'])->fetchColumn();

					$r_donnees_perso = $connexion->prepare('SELECT * FROM personnages WHERE idPseudo = ' . $_SESSION['id']);
					$r_donnees_perso->execute();
					$donnees_perso = $r_donnees_perso->fetch(PDO::FETCH_OBJ);

					if($countItem == 0)
					{
						$insert = $connexion->prepare("INSERT INTO inventaire VALUES('', :idpseudo, :iditem, :quantite, :firstownerpseudo, :firstownerperso, :timestamp)");
						$insert->execute(array(
						'idpseudo' => $_SESSION['id'],
						'iditem' => $ObjRand['id'],
						'quantite' => 1,
						'firstownerpseudo' => $_SESSION['pseudo'],
						'firstownerperso' => $donnees_perso->nomPerso,
						'timestamp' => time()
						));

						notification($_SESSION['id'], '7', 'Un objet a été ajouté à votre inventaire !\n[b]+ 1 : ' . $ObjRand['nom_item'] . '[/b]', $connexion);
					}
					else
					{
						$connexion->query('UPDATE inventaire SET quantite = (quantite + 1) WHERE idItem = ' . $ObjRand['id'] . ' AND idPseudo = ' . $_SESSION['id']);
						notification($_SESSION['id'], '7', 'Un objet a été ajouté à votre inventaire !\n[b]+ 1 : ' . $ObjRand['nom_item'] . '[/b]', $connexion);
					}
						
				}
			}
		}
		else
		{
			$colorCountDrop = '<font color="#ff5959">';
		}
	}
	else
	{
		$colorCountDrop = '<font color="#ff5959">';
		$countNbObj = 0;
	}

}

?>