<?php
include('../base.php');

if($_POST['yep'])
{
	include('../menuGauche.php');
	include('../menuDroit.php');
	exit;
}

if(isset($_SESSION['pseudo']))
	{
	echo '1';
	exit;
	}


	// Debut - Traitement formulaire de connexion
	if(!empty($_POST['pseudo']) AND !empty($_POST['passe']))
	{
		// Debut - Vérification nb de tentative pour l'antibrute force.
			$existence_ft = ''; // On initialise $existence_ft

			// Si le fichier existe, on le lit
			if(file_exists('antibrute/' . $_POST['pseudo'] . '.tmp'))
			{
				// On ouvre le fichier
				$fichier_tentatives = fopen('antibrute/' . $_POST['pseudo'] . '.tmp', 'r+');

				// On récupère son contenu dans la variable $infos_tentatives
				$contenu_tentatives = fgets($fichier_tentatives);

				// On découpe le contenu du fichier pour récupérer les informations
				$infos_tentatives = explode(';', $contenu_tentatives);

				// Si la date du fichier est celle d'aujourd'hui, on récupère le nombre de tentatives
				if($infos_tentatives[0] == date('d/m/Y'))
				{
					$tentatives = $infos_tentatives[1];
				}

				// Si la date du fichier est dépassée, on met le nombre de tentatives à 0 et $existence_ft à 2
				else
				{
					$existence_ft = 2;
					$tentatives = 0; // On met la variable $tentatives à 0
				}
			}
			// Si le fichier n'existe pas encore, on met la variable $existence_ft à 1 et on met les $tentatives à 0
			else
			{
				$existence_ft = 1;
				$tentatives = 0;
			}
		// Fin - Vérification nb de tentatives pour l'anti brute force

		// Debut - Savoir si on peut se connecter
			if($tentatives < 30)
			{
				// Sécurité des variables
				$pseudo = secure($_POST['pseudo']);
				$passe = secure($_POST['passe']);

				// Pour vérifier si le pseudo existe
				$reponse = mysql_query('SELECT COUNT(*) AS nbEntrees FROM membres WHERE pseudo="' . $pseudo . '"');
				$donnees = mysql_fetch_array($reponse);
				$nbEntrees = $donnees['nbEntrees'];

				if($nbEntrees > 0)
				{
					// Le pseudo existe on récupère son id, pseudo, passe et accès
					$reponse = mysql_query('SELECT id, pseudo, pass, clef, valide, acces FROM membres WHERE pseudo="' . $pseudo . '"');
					$donnees = mysql_fetch_assoc($reponse);

					if($donnees['valide'] == 1)
					{
						if($donnees['acces'] != 1)
						{
							if($donnees['acces'] != 2)
							{
								if(sha1($passe) == $donnees['pass'] OR hacher($passe) == $donnees['pass'])
								{

										// Le membre est connecté, on crée les variables SESSION
										$_SESSION['id'] = intval($donnees['id']);
										$_SESSION['pseudo'] = $pseudo;
										$_SESSION['pseudo_mp'] = $donnees['pseudo'];
										$_SESSION['acces'] = 10;
										$_SESSION['clef'] = $donnees['clef'];
										$_SESSION['p_acces'] = intval($donnees['acces']);
										$_SESSION['attente'] = "Variable supprimée";
										$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
										setcookie('pseudo', $donnees['pseudo'], (time() + 365*24*3600));
										mysql_query('UPDATE membres SET lastCo= ' . time() . ' WHERE id=' . $donnees['id']);
										// Enfin, s'il a demandé à retenir son pseudo
										if(isset($_POST['retenir']))
										{
											setcookie('GUID', $pseudo . ', ' . $donnees['clef'], (time() + 365*24*3600));
										}

										echo '
										<th class="menuGauche">
											<span class="menuNom" onmouseover="menuOuvrir(\'sousMenu\');" onmouseout="menuFermer(\'sousMenu\');">&nbsp;&nbsp;Applications&nbsp;</span><span class="menuNom">&nbsp;Places&nbsp;</span><span class="menuNom">&nbsp;Système&nbsp;</span>
										</th>
										<th class="menuCentre">
											' . date('H\:i', time()) . '
										</th>
										<th class="menuDroit">
											<span class="menuNom" onmouseover="menuOuvrir(\'sousMenu2\');" onmouseout="menuFermer(\'sousMenu2\');">&nbsp;' . $_SESSION['pseudo'] . '&nbsp;&nbsp;</span>
										</th>';
										exit;


								}
								else
								{
									// Si le fichier n'existe pas encore, on le créé
									if($existence_ft == 1)
									{
										$creation_fichier = fopen('../antibrute/'.$donnees['pseudo'].'.tmp', 'a+'); // On créé le fichier puis on l'ouvre
										fputs($creation_fichier, date('d/m/Y').';1'); // On écrit à l'intérieur la date du jour et on met le nombre de tentatives à 1
										fclose($creation_fichier); // On referme
									}
									// Si la date n'est plus a jour
									elseif($existence_ft == 2)
									{
										fseek($fichier_tentatives, 0); // On remet le curseur au début du fichier
										fputs($fichier_tentatives, date('d/m/Y').';1 '); // On met à jour le contenu du fichier (date du jour;1 tentatives)
									}
									else
									{
										// Si la variable $tentatives est sur le point de passer à 30, on en informe l'administrateur du site
										if($tentatives == 29)
										{
											$email_administrateur = '';

											$sujet_notification = '[Site] Un compte membre à atteint son quota';

											$message_notification = 'Un des comptes a atteint le quota de mauvais mots de passe journalier :';
											$message_notification .= $donnees['pseudo'].' - '.$_SERVER['REMOTE_ADDR'].' - '.gethostbyaddr($_SERVER['REMOTE_ADDR']);

											mail($email_administrateur, $sujet_notification, $message_notification);
										}

										fseek($fichier_tentatives, 11); // On place le curseur juste devant le nombre de tentatives
										fputs($fichier_tentatives, $tentatives + 1); // On ajoute 1 au nombre de tentatives
									}
									// Vous n'avez pas entré le bon pseudo et/ou mot de passe, veuillez réessayer.
									echo '2';
									exit;
								}
							}
							else
							{
								// Votre pseudo a été banni temporairement.
								echo '3';
								exit;
							}
						}
						else
						{
							// Votre pseudo a été banni définitivement.
							echo '4';
							exit;
						}
					}
					else
					{
						// Ce pseudo n'a pas encore été validé !
						echo '5';
						exit;
					}
				}
				else
				{
					// Vous n'avez pas entré le bon pseudo et/ou mot de passe, veuillez réessayer.
					echo '2';
					exit;
				}
			}
			else
			{
				// Trop de tentatives d'authentification aujourd'hui.
				echo '6';
				exit;
			}
		// Fin - Savoir si on peut se connecter

		// Si on a ouvert un fichier, on le referme (eh oui, il ne faut pas l'oublier)
		if($existence_ft != 1)
		{
		fclose($fichier_tentatives);
		}
	}

// Fin - Traitement formulaire de connexion
?>