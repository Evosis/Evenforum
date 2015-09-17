<?php

function paginationMpFil($connexion, $configuration) 
{
	if(!isset($_GET['page']) OR intval($_GET['page']) == 0)
	{
		$page = 1;
	}
	else
	{
		$page = $_GET['page'];
	}

	$reponse = $connexion->query('SELECT * FROM mpFil');
	$nbFil = 0;

	while($donnees = $reponse->fetch(PDO::FETCH_OBJ))
	{
		$destinataire = explode(",", $donnees->participant);

		if(in_array($_SESSION['pseudo'], $destinataire) OR $_SESSION['pseudo'] == $donnees->auteur)
		{
			$count = $connexion->prepare('SELECT COUNT(*) FROM mpFilSupp WHERE idFil=' . $donnees->id . ' AND idPseudo=' . $_SESSION['id']);
			$count->execute();
			$valeur = $count->fetchColumn();

			if($valeur == 0)
			{
				$nbFil++;
			}
		}
	}

	$nombreDePages=ceil($nbFil/$configuration['spp']);

	if($nombreDePages == 0)
	{
		$nombreDePages = 1;
	}

	if($page >= $nombreDePages)
	{
		$page = $nombreDePages;
	}

	$i = 1;
	$nombreDePages++;
	$selectPage = "";

	for($i = 1; $i < $nombreDePages; $i++)
	{
		if($page == $i)
		{
			$selectPage .= $i;
		}
		else
		{
			$selectPage .= '<a href="mp.php?action=lire&page=' . $i . '">' . $i . '</a>';
		}

		if($nombreDePages - $i > 1)
		{
			$selectPage .= ' | ';
		}
	}

	if($page == 1)
	{
		$precedent = 'Précédent';
	}
	else
	{
		$precedent = '<a href="mp.php?action=lire&page=' . ($page - 1) . '">Précédent</a>';
	}

	if($page == ($nombreDePages - 1))
	{
		$suivant = 'Suivant';
	}
	elseif($nombreDePages == 1)
	{
		$suivant = 'Suivant';
	}
	else
	{
		$suivant = '<a href="mp.php?action=lire&page=' . ($page + 1) . '">Suivant</a>';
	}

	$retour['min'] = ($configuration['spp'] * $page) - $configuration['spp'];
	$retour['max'] = ($configuration['spp'] * $page) - 1;
	$retour['selectPage'] = $selectPage;
	$retour['precedent'] = $precedent;
	$retour['suivant'] = $suivant;

	return $retour;
}

function paginationMpMessage($connexion, $configuration) 
{
	if(!isset($_GET['page']) OR intval($_GET['page']) == 0)
	{
		$page = 1;
	}
	else
	{
		$page = $_GET['page'];
	}

	$nbMessage = $connexion->query('SELECT COUNT(*) FROM mpMessage WHERE idFil=' . $_GET['id'] . ' AND type=0')->fetchColumn();

	$nombreDePages=ceil($nbMessage/$configuration['mpp']);

	if($nombreDePages == 0)
	{
		$nombreDePages = 1;
	}

	if($page >= $nombreDePages)
	{
		$page = $nombreDePages;
	}

	$i = 1;
	$nombreDePages++;
	$selectPage = "";

	for($i = 1; $i < $nombreDePages; $i++)
	{
		if($page == $i)
		{
			$selectPage .= $i;
		}
		else
		{
			$selectPage .= '<a href="message.php?id=' . $_GET['id'] . '&page=' . $i . '">' . $i . '</a>';
		}

		if($nombreDePages - $i > 1)
		{
			$selectPage .= ' | ';
		}
	}

	if($page == 1)
	{
		$precedent = 'Précédent';
	}
	else
	{
		$precedent = '<a href="message.php?id=' . $_GET['id'] . '&page=' . ($page - 1) . '">Précédent</a>';
	}

	if($page == ($nombreDePages - 1))
	{
		$suivant = 'Suivant';
	}
	elseif($nombreDePages == 1)
	{
		$suivant = 'Suivant';
	}
	else
	{
		$suivant = '<a href="message.php?id=' . $_GET['id'] . '&page=' . ($page + 1) . '">Suivant</a>';
	}

	$retour['min'] = ($configuration['mpp'] * $page) - $configuration['mpp'];
	$retour['max'] = $configuration['mpp'];
	$retour['selectPage'] = $selectPage;
	$retour['precedent'] = $precedent;
	$retour['suivant'] = $suivant;

	return $retour;
}

function paginationForum($connexion, $configuration) 
{
	if(!isset($_GET['page']) OR intval($_GET['page']) == 0)
	{
		$page = 1;
	}
	else
	{
		$page = $_GET['page'];
	}

	$count = $connexion->prepare('SELECT COUNT(*) FROM sujets WHERE idForum=' . $_GET['id'] . ' AND etat != "0"');
	$count->execute();
	$nombreDeSujet = $count->fetchColumn();

	$nombreDePages=ceil($nombreDeSujet/$configuration['spp']);

	if($nombreDePages == 0)
	{
		$nombreDePages = 1;
	}

	if($page >= $nombreDePages)
	{
		$page = $nombreDePages;
	}

	$i = 1;
	$nombreDePages++;
	$selectPage = "";

	/*for($i = 1; $i < $nombreDePages; $i++)
	{
		if($page == $i)
		{
			$selectPage .= $i;
		}
		else
		{
			$selectPage .= '<a href="mp.php?action=lire&page=' . $i . '">' . $i . '</a>';
		}

		if($nombreDePages - $i > 1)
		{
			$selectPage .= ' | ';
		}
	}*/

	if($page == 1)
	{
		$selectPage = 'Début';
	}
	else
	{
		$selectPage = '<a href="forum.php?id=' . $_GET['id'] . '">Début</a>';
	}

	if($page == 1)
	{
		$precedent = 'Précédent';
	}
	else
	{
		$precedent = '<a href="forum.php?id=' . $_GET['id'] . '&page=' . ($page - 1) . '">Précédent</a>';
	}

	if($page == ($nombreDePages - 1))
	{
		$suivant = 'Suivant';
	}
	elseif($nombreDePages == 1)
	{
		$suivant = 'Suivant';
	}
	else
	{
		$suivant = '<a href="forum.php?id=' . $_GET['id'] . '&page=' . ($page + 1) . '">Suivant</a>';
	}

	$retour['min'] = ($configuration['spp'] * $page) - $configuration['spp'];
	$retour['max'] = $configuration['spp'];
	$retour['selectPage'] = $selectPage;
	$retour['precedent'] = $precedent;
	$retour['suivant'] = $suivant;

	return $retour;
}

function paginationSujet($connexion, $configuration) 
{
	if(!isset($_GET['page']) OR intval($_GET['page']) == 0)
	{
		$page = 1;
	}
	else
	{
		$page = $_GET['page'];
	}

	$nbMessage = $connexion->query('SELECT COUNT(*) FROM messages WHERE idSujet=' . $_GET['id'] . ' AND etat=0')->fetchColumn();

	$nombreDePages=ceil($nbMessage/$configuration['mpp']);

	if($nombreDePages == 0)
	{
		$nombreDePages = 1;
	}

	if($page >= $nombreDePages)
	{
		$page = $nombreDePages;
	}

	$i = 1;
	$nombreDePages++;
	$selectPage = "";

	for($i = 1; $i < $nombreDePages; $i++)
	{
		if($page == $i)
		{
			$selectPage .= $i;
		}
		else
		{
			$selectPage .= '<a href="sujet.php?id=' . $_GET['id'] . '&page=' . $i . '">' . $i . '</a>';
		}

		if($nombreDePages - $i > 1)
		{
			$selectPage .= ' | ';
		}
	}

	if($page == 1)
	{
		$precedent = 'Précédent';
	}
	else
	{
		$precedent = '<a href="sujet.php?id=' . $_GET['id'] . '&page=' . ($page - 1) . '">Précédent</a>';
	}

	if($page == ($nombreDePages - 1))
	{
		$suivant = 'Suivant';
	}
	elseif($nombreDePages == 1)
	{
		$suivant = 'Suivant';
	}
	else
	{
		$suivant = '<a href="sujet.php?id=' . $_GET['id'] . '&page=' . ($page + 1) . '">Suivant</a>';
	}

	$retour['min'] = ($configuration['mpp'] * $page) - $configuration['mpp'];
	$retour['max'] = $configuration['mpp'];
	$retour['selectPage'] = $selectPage;
	$retour['precedent'] = $precedent;
	$retour['suivant'] = $suivant;

	return $retour;
}
?>