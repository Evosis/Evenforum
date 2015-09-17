<?php
session_start();

/*if(!isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
{
	echo '<style>
	body {
		background-color: black;
		color: white;
	}
	</style>
	<title>Connexion refus&eacute;</title>
	<br /><br /><br /><br /><br />
	<center><img src="images/design/alerte.png" /><br /><br /><br />
	Proxy d&eacute;tect&eacute;, connexion refus&eacute;.
	</center>';
	exit;
}
if(!isset($_SERVER['HTTP_ACCEPT_ENCODING']))
{
	echo '<style>
	body {
		background-color: black;
		color: white;
	}
	</style>
	<title>Connexion refus&eacute;</title>
	<br /><br /><br /><br /><br />
	<center><img src="images/design/alerte.png" /><br /><br /><br />
	Proxy d&eacute;tect&eacute;, connexion refus&eacute;.
	</center>';
	exit;
}
$tor = stripos($_SERVER['HTTP_USER_AGENT'], "24");
if ($tor !== false) {
   echo '<style>
	body {
		background-color: black;
		color: white;
	}
	</style>
	<title>Connexion refus&eacute;</title>
	<br /><br /><br /><br /><br />
	<center><img src="images/design/alerte.png" /><br /><br /><br />
	Proxy d&eacute;tect&eacute;, connexion refus&eacute;.
	</center>';
	exit;
}*/

//if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){echo'Pas de proxy';}else{echo'Proxy detected';} 
			//$pos1 = stripos($mystring1, $findme);

include('sql.php');

/*if($_SERVER['REMOTE_ADDR'] != "109.221.91.233" AND $_SERVER['REMOTE_ADDR']!= "24.202.184.137")
{
	echo "<script type=\"text/javascript\">\n"
		. "<!--\n"
		. "\n"
		. "function redirect() {\n"
		. "window.location='alerte.php'\n"
		. "}\n"
		. "setTimeout('redirect()','0000');\n"
		. "\n"
		. "// -->\n"
		. "</script>\n";
		exit;
}*/

	function secure($chaine) // sécuriser
	{
		return mysql_real_escape_string($chaine);
	}

	    function hacher($passe)
    {
         // Nos grains de sel
         define("PREFIXE", "ehyguys");
         define("SUFFIXE", "whats0up");

         // Faites tournez le Hachage ^^
         $passe = md5( sha1(PREFIXE) . $passe . sha1(SUFFIXE) );

         return $passe;
    }


	function bloc($texte) // Bloc
	{
		echo '<div class="contenu">' . $texte . '</div>';
	}

	

	function bloc2($h3, $texte)
	{
		echo '<div class="contenu">
		<h3>' . $h3 . '</h3>
		<div class="separate"></div>
		' . $texte . '
		</div>
		';
	}

	function redirection($url) // Redirection
	{
		echo "<script type=\"text/javascript\">\n"
		. "<!--\n"
		. "\n"
		. "function redirect() {\n"
		. "window.location='" . html_entity_decode($url) . "'\n"
		. "}\n"
		. "setTimeout('redirect()','0000');\n"
		. "\n"
		. "// -->\n"
		. "</script>\n";
	}

	// Arch // J'ai arrêté de coder la connexionAuto quand j'ai vu qu'il suffisait d'une simple
	// injection SQL, on récupère le mdp et on place tout ça dans le cookies, du coup le hacker
	// osef de savoir si le mdp est crypté ou pas...

	// TimeR // Suffi de modifier le mdp mis dedans par la clé du membre, simple et efficace
	// + pk tu chie sur les injections, tu m'as fait 10000 systemes ANTI INJECTION ,p utain !: :noel:

	/*if(!isset($_SESSION['pseudo']))
	{
		if($_COOKIE['connexionAuto'] != 0)
		{
			$pieces = explode("|", $_COOKIE['connexionAuto']);

			$id = (int) $pieces[0];
			$mdp = secure($pieces[1]);

			$repco = mysql_query('SELECT COUNT(*) AS nbGoogle FROM membres WHERE id = ' . $id . ' AND pass = "' . $mdp . '"');
			$donco = mysql_fetch_assoc($repco);

			$_SESSION['id'] = intval($id);
			$_SESSION['pseudo'] = $pseudo;
			$_SESSION['pseudo_mp'] = $donnees['pseudo'];
			$_SESSION['acces'] = 10;
			$_SESSION['clef'] = $donnees['clef'];
			$_SESSION['p_acces'] = intval($donnees['acces']);
			$_SESSION['attente'] = "Variable supprimée";
			$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
			mysql_query('UPDATE membres SET connecterA=' . time() . ' WHERE id=' . $donnees['id']);
		}
	}*/

	if(!isset($_SESSION['id']))
	{
		if($_COOKIE['imlazy'] != 0)
		{
			if($_COOKIE['GUID'] != NULL)
			{
				$separe = explode(", ", $_COOKIE['GUID']);

				$pseudo = secure(htmlspecialchars(stripslashes($separe[0])));
				$key = secure(htmlspecialchars(stripslashes($separe[1])));

				$secu = mysql_query('SELECT COUNT(*) AS nbMembres FROM membres WHERE pseudo = "' . $pseudo . '" AND clef = "' . $key . '"');
				$secure = mysql_fetch_assoc($secu);

				if($secure['nbMembres'] != 0)
				{
					$checkallmembre = mysql_query('SELECT * FROM membres WHERE pseudo = "' . $pseudo . '"');
					$queryallmembre = mysql_fetch_assoc($checkallmembre);

					$_SESSION['id'] = intval($queryallmembre['id']);
					$_SESSION['pseudo'] = $pseudo;
					$_SESSION['acces'] = 10;
					$_SESSION['clef'] = $donnees['clef'];
					$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

				}
				else
				{
					if(isset($_SESSION['id']))
					{
						avert('Vous avez modifié votre cookie ! Déconnexion en cours...');
						session_destroy();
						exit;
					}
				}

			}
		}
	}


	if(isset($_SESSION['pseudo']))
	{
		$repib = mysql_query('SELECT acces FROM membres WHERE id='. $_SESSION['id']);
		$donib = mysql_fetch_assoc($repib);

		if($donib['acces'] == 1)
		{
			session_destroy();
			setcookie('connexionAuto', 0, (time() + 365*24*3600));
			header('Location: index.php');
		}
	}
	if(isset($_SESSION['pseudo']) AND $_SESSION['id'] != 8)
	{

		if($_SESSION['ip'] != $_SERVER['REMOTE_ADDR'])
		{
			session_destroy();
			setcookie('connexionAuto', 0, (time() + 365*24*3600));
			header('Location: index.php');
		}
	}

	$adrFichier = $_SERVER['REQUEST_URI']; // On récupère l'adresse exacte du site

	function bbCode($t) // remplace les balises BBCode par des balises HTML
	{
		// Cacher du texte
		$t = preg_replace('#\[cacher\](.+?)\[/cacher\]#is', '<div style="margin:20px; margin-top:5px"><div class="spoilertexte"><input class="button2 btnlite" type="button" value="Lire" style="text-align:center;width:100px;margin:0px;padding:0px;" onclick="if (this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display != \'\') { this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display = \'\'; this.innerText = \'\'; this.value = \'Cacher\'; } else { this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display = \'none\'; this.innerText = \'\'; this.value = \'Montrer\'; }" /></div><div class="spoiler"><div style="display: none;">$1</div></div></div>', $t);

		// Faire bouton
		$t = preg_replace('#\[bouton\](.+?)\[/bouton\]#is', '<input type="button" value="$1" />', $t);

		// Faire une infobulle
		$t = preg_replace('#\[info\](.+?),(.+?)\[/info\]#is', '<acronym title="$2" style="font-weight: bold;">$1</acronym>', $t);

		// hr
		$t = preg_replace('#\[hr\]#is', '<hr />', $t);

		// gras
		$t = preg_replace('#\[b\](.+?)\[/b\]#is', '<b>$1</b>', $t);

		// italique
		$t = preg_replace('#\[i\](.+?)\[/i\]#is', '<i>$1</i>', $t);


		// soulignement
		$t = preg_replace('#\[u\](.+?)\[/u\]#is', '<u>$1</u>', $t);

		// citer
		$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<div class="citer">$1</div>', $t);

		// centré
		$t = preg_replace('#\[center\](.+?)\[/center\]#is', '<div style="text-align:center;">$1</div>', $t);

		// Alignemment justifié
		$t = preg_replace('#\[justifier\](.+?)\[/justifier\]#is', '<div align="justify">$1</div>', $t);

		// puissance
		$t = preg_replace('#\[sup\](.+?)\[/sup\]#is', '<sup>$1</sup>', $t);

		// indice
		$t = preg_replace('#\[sub\](.+?)\[/sub\]#is', '<sub>$1</sub>', $t);

		// barré
		$t = preg_replace('#\[s\](.+?)\[/s\]#is', '<s>$1</s>', $t);

		// Spotted
		$t = preg_replace('#\[spotted\]#is', $_SESSION['pseudo'], $t);

		// déplacer
		$t = preg_replace('#\[bas\](.+?)\[/bas\]#is', '<div style="height: 20px;"><marquee direction="down">$1</marquee></div>', $t);
		$t = preg_replace('#\[haut\](.+?)\[/haut\]#is', '<div style="height: 20px;"><marquee direction="up">$1</marquee></div>', $t);
		$t = preg_replace('#\[droite\](.+?)\[/droite\]#is', '<marquee direction="right">$1</marquee>', $t);
		$t = preg_replace('#\[gauche\](.+?)\[/gauche\]#is', '<marquee direction="left">$1</marquee>', $t);

		// clignoter
		$t = preg_replace('#\[clignote\](.+?)\[/clignote\]#is', '<span style="text-decoration: blink;">$1</span>', $t);

		// taille
		$t = preg_replace('`\[taille=(10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25)\](.+)\[/taille\]`isU', '<span style="font-size:$1px">$2</span>', $t);

        // Couleur
		$t=str_replace("[/color]", "</span>", $t);
		$regCouleur="\[color= ?(([[:alpha:]]+)|(#[[:digit:][:alpha:]]{6})) ?\]";
		$t=@ereg_replace($regCouleur, "<span style=\"color: \\1\">", $t);


		// Lien et adresse e-mail
		$callbackLien = create_function('$array', '

				$LIEN = $array[0] ;
				$LIEN2 = $array[0] ;

				$nb = mb_strlen($LIEN);

				if(preg_match(\'#^http#i\', $LIEN)) // Lien
				{
					$LIEN = \'<a href="\' . $array[0] . \'" target="_blank">\' ;
				}
				else // Email
				{
					$LIEN = \'<a href="mailto:\' . $array[0] . \'">\' ;
				}

				if(preg_match(\'#^http://evenforum.olympe.in#i\', $LIEN2)) // Lien interne
				{
					$LIEN .= mb_substr($array[0], 27, 20) . \'\' . mb_substr($array[0], $nb, 20) ;
				}
				elseif($nb < 61)
				{
					$LIEN .= $array[0];
				}
				else
				{
					$LIEN .= mb_substr($array[0], 0, 20) . \'[...]\' . mb_substr($array[0], ($nb - 20), 20) ;
				}

				$LIEN .= \'</a>\' ;

				if(preg_match(\'#^http://www.youtube#i\', $LIEN2)) // Lien interne
				{	
					$pieces = explode("?v=", $array[0]);
					$LIEN = \'
					<iframe width="560" height="315" src="https://www.youtube.com/embed/\' . $pieces[1] . \'" frameborder="0" allowfullscreen></iframe>
					\' ;
				}

				return $LIEN;
			') ;

		// Pour afficher une image ou un lien direct sans balise
		// on vire le HTTP d'une image pour éviter qu'il soit confondu avec un lien et on l'affiche s'il y a les balises [img] et [/img]
		$t = preg_replace('#\[img\]http://([a-z0-9._/&\?=-]+\.(jpg|png|gif))\[\/img\]#i', '
		<a href="%LINK%$1"><img src="%LINK%$1" id="imageposte" onload="resize(this)"/></a> ', $t); // image

		// on applique la REGEX du lien
		$t = preg_replace_callback('#http://[^ \n\r\'"]+#i', $callbackLien, $t); // lien

		// on rétablit les images si les balises sont respectées
		$t = str_replace("%LINK%",'http://', $t) ;

		// Smileys
		$smileys = array(':julien:' => 'julien', ':jeremy:' => 'jeremy', ':patrick:' => 'patrick', ':salecon:' => 'salecon', ':fuck:' => 'fuck', ':haps:' => 'hapseb', ':30:' => '30', ':29:' => '29', ':28:' => '28', ':27:' => '27', ':26:' => '26', ':25:' => '25', ':24:' => '24', ':23:' => '23', ':22:' => '22', ':21:' => '21', ':20:' => '20', ':19:' => '19', ':18:' => '18', ':17:' => '17', ':16:' => '16', ':15:' => '15', ':14:' => '14', ':13:' => '13', ':12:' => '12', ':11:' => '11', ':10:' => '10', ':9:' => '9', ':8:' => '8', ':7:' => '7', ':6:' => '6', ':5:' => '5', ':4:' => '4', ':3:' => '3', ':2:' => '2', ':1:' => '1', ':hanouna:' => 'hanouna', ':hapoelparty:' => 'hapoelparty', ':ahok:' => 'ahok', ':hapwesh:' => 'hapwesh', ':colerenoel:' => 'colerenoel', ':+1:' => 'plus1', ':awesome:' => 'awesome', ':troll:' => 'troll', ':toel:' => 'toel', ':okcool:' => 'okcool', ':bridou:' => 'bridou', ':pedoface:' => 'pedophile', ':beauf:' => 'beauf', ':timer:' => 'timer', ':gta:' => 'gta', ':gerardok:' => 'gerardok', ':michael:' => 'michael', ':autiste:' => 'autiste', ':biere:' => 'biere', ':ahuri:' => 'ahuri', ':jackyok:' => 'jackyok', ':martin:' => 'martin', ':mercille:' => 'mercille', ':quebec:' => 'quebec', ':tucherchelamerde:' => 'tucherchelamerde', ':fier2:' => 'fier2', ':hapoel:' => 'hapoel', ':troll:' => 'troll', ':bave3:' => 'bave3', ':baveok:' => 'baveok', ':cute:' => 'cute', ':technook:' => 'technook', ':mechant:' => 'mechant', ':pf:' => 'pf', ':haphum:' => 'haphum', ':bavecoeur:' => 'bavecoeur', ':coeurhum:' => 'coeurhum', ':mario:' => 'mario', ':bavenoel:' => 'bavenoel',  ':noelb:' => 'noelb', ':bave2:' => 'bave2', ':cool2:' => 'cool2', ':noelok2:' => 'noelok2', ':haprouge:' => 'haprouge', ':humxd:' => 'humxd', ':hap):' => 'hap)', ':snif3:' => 'snif3', ':supergni:' => 'supergni', ':quoi:' => 'quoi', ':empereur:' => 'empereur', ':cake:' => 'cake', ':noelok:' => 'noelok', ':agenda:' => 'agenda', ':hapfake:' => 'hapfake', ':firefox:' => 'firefox', ':pal:' => 'pal', ':vaincra:' => 'vaincra', ':hapsnif:' => 'hapsnif', ':salut2:' => 'salut2', ':hapange:' => 'hapange', ':hapnoel:' => 'hapnoel', ':haplol:' => 'haplol', ':fake:' => 'fake', ':owned:' => 'owned', ':censored:' => 'censored', ':shauni:' => 'shauni', ':pedo:' => 'pedo', ':peurnoel:' => 'peurnoel', ':oupas:' => 'oupas', ':nonnonnoel:' => 'nonnonnoel', ':bide:' => 'bide', ':humnoel:' => 'humnoel', ':clownnoel:' => 'clownnoel', ':grotte:' => 'grotte', ':jerry:' => 'jerry', ':founoel:' => 'founoel', ':)' => '=)', ':o))' => '=o))', ':hap:' => 'hap', ':content:' => 'content', ':cool:' => 'cool', ':rire2:' => 'rire2', ':sournois:' => 'sournois', ':gni:' => 'gni', ':merci:' => 'merci', ':rechercher:' => 'rechercher', ':gne:' => 'gne', ':snif2:' => 'snif2', ':ouch:' => 'ouch', ':ouch2:' => 'ouch2', ':nonnon:' => 'nonnon', ':non2:' => 'non2', ':non:' => 'non', ':nah:' => 'nah', ':hum:' => 'hum', ':bravo:' => 'bravo', ':svp:' => 'svp', ':hello:' => 'hello', ':lol:' => 'lol', ':gba:' => 'gba', ':mac:' => 'mac', ':pacg:' => 'pacg', ':pacd:' => 'pacd', ':fier:' => 'fier', ':malade:' => 'malade', ':ange:' => 'ange', ':desole:' => 'desole', ':sors:' => 'sors', ':up:' => 'up', ':dpdr:' => 'dpdr', ':cd:' => 'cd', ':globe:' => 'globe', ':question:' => 'question', ':mort:' => 'mort', ':sleep:' => 'sleep', ':honte:' => 'honte', ':monoeil:' => 'monoeil', ':diable:' => 'diable', ':spoiler:' => 'spoiler', ':bye:' => 'bye', ':hs:' => 'hs', ':banzai:' => 'banzai', ':bave:' => 'bave', ':xd:' => 'xd', ':(' => '=(', ':-D' => '=-D', ':d)' => '=d)', ':g)' => '=g)', ':p)' => '=p)', ':salut:' => 'salut', ':fete:' => 'fete', ':noel:' => 'noel', ':rire:' => 'rire', ':-p' => '=-p', ':fou:' => 'fou', ':coeur:' => 'coeur', ':rouge:' => 'rouge', ':oui:' => 'oui', ':dehors:' => 'dehors', ':peur:' => 'peur', ':ok:' => 'ok', ':sarcastic:' => 'sarcastic', ':doute:' => 'doute', ':snif:' => 'snif', ':fouet:' => 'fouet', ':sortie:' => 'sortie', ':jbsd:' => 'jbsd', ':-)))' => '=-)))', ':-((' => '=-((');

		foreach($smileys as $code => $chemin)
		{
			$t = str_replace($code, '<img src="smileys/' . $chemin . '.gif" alt="' . $code . '" class="smiley" />', $t);
		}

		$t = preg_replace('#:-\(#', '<img src="smileys/=-(.gif" alt=":-(" class="smiley" />', $t) ;
		$t = preg_replace('#:-\)#', '<img src="smileys/=-).gif" alt=":-)" class="smiley" />', $t) ;
		$t = preg_replace('#(:S|:scept:|:vague:)#', '<img src="smileys/=s.gif" alt=":-)" class="smiley" />', $t) ;
		$t = str_replace('<img src="smileys/=-).gif" alt=":-)" class="smiley" />))" class="smiley" />', '<img src="smileys/=-))).gif" alt=":-)))" class="smiley" />', $t) ; // :-)))
		$t = str_replace('<img src="smileys/=-(.gif" alt=":-(" class="smiley" />(" class="smiley" />', '<img src="smileys/=-((.gif" alt=":-((" class="smiley" />', $t) ; // :-((

		return $t;
	}

	// Avertissement lors de tentative d'injection SQL

	if(stristr($_SERVER['REQUEST_URI'], '%27') OR stristr($_SERVER['REQUEST_URI'], '%22'))
	{
		mysql_query("INSERT INTO injection VALUES('', '" . $_SESSION['id'] . "', '" . $_SESSION['pseudo'] . "', '" . $_SERVER['REQUEST_URI'] . "', '" . $_SERVER['REMOTE_ADDR'] . "', '" . time() . "')");
	}

// Debut - Liste des connectés
	if(isset($_SESSION['id']))
	{
		$idPseudo = $_SESSION['id'];
		$Sacces = $_SESSION['acces'];
	}
	else
	{
		$idPseudo = 0;
		$Sacces = 0;
	}


	// On regarde si l'ip n'est pas déjà présente dans la table
	$retour = mysql_query('SELECT COUNT(*) AS nbre_entrees FROM connectes WHERE ip=\'' . $_SERVER['REMOTE_ADDR'] . '\'');
	$donnees = mysql_fetch_assoc($retour);

	if($donnees['nbre_entrees'] == 0) // L'ip ne se trouve pas dans la table, on va l'ajouter
	{
		mysql_query("INSERT INTO connectes VALUES('" . $_SERVER['REMOTE_ADDR'] . "', '" . time() . "', '" . $_SESSION['id'] . "', '" . $_SESSION['acces'] . "', '" . $_SERVER['REQUEST_URI'] . "')");
	}
	else // L'ip se trouve déjà dans la table, on met juste à jour le timestamp
	{
		mysql_query('UPDATE connectes SET timestamp="' . time() . '", acces="' . $_SESSION['acces'] . '", idPseudo="' . $_SESSION['id'] . '", path="' . $_SERVER['REQUEST_URI'] . '" WHERE ip="' . $_SERVER['REMOTE_ADDR'] . '"');
	}

	// Suppression des membres inactifs depuis plus de 5min
	$timestamp_5min = time() - (60 * 5);
	mysql_query('DELETE FROM connectes WHERE timestamp < ' . $timestamp_5min);
// Fin - Liste des Connectés

	function page($LIEN, $page, $nbPagesPossibles)
	{
		if($nbPagesPossibles > 1 OR !$nbPagesPossibles) // S'il y a plus d'une page
		{
			$affichage = '' ;

			$preums = $page ;

			while($preums % 30 != 0)
			{
				$preums--;
			}

			$affichage .= '' ;

			// On commence par calculer la première page qu'on affiche
			$pageDebut = $page - 5 ;

			if($pageDebut < 1) // Si on tombe dans les négatifs, alors on se remet sur le droit chemin
			{
				$pageDebut = 1 ;
			}

			if($nbPagesPossibles - $page < 5 AND ($nbPagesPossibles - 9 > 1)) // Si on arrive vers la fin, on fait bien attention à tout de même afficher 10 pages
			{
				$pageDebut = $nbPagesPossibles - 9 ;
			}

			// { Début - Affichage des pages
				if($pageDebut != 1) // Si on affiche pas la première page dans la boucle, on l'ajoute quand même
				{
					$affichage .= '<a href="' . $LIEN . '&page=1">1</a>' ;

					if($pageDebut != 2) // Si on est sur la deuxième page, on affiche pas le "..."
					{
						$pageRetro = $page - 10 ; // On calcule la page que renverront les "..."

						if($pageRetro < 2) // Il ne faut pas que la page rétro soit 1, sinon c'est inutile, donc on fixe une limite minimum de 2
						{
							$pageRetro = 2 ;
						}

						$affichage .= ' <a href="' . $LIEN . '&page=' . $pageRetro . '">...</a> ' ;
					}
					else
					{
						$affichage .= ' | ' ;
					}
				}

				$i = $pageDebut ;
				$n = 0 ;
				while($n < 10 AND $i <= $nbPagesPossibles)
				{
					if($page == $i)
					{
						$affichage .= '<a href="' . $LIEN . '&page=' . $i . '" class="pageActuelle">' . $i . '</a>' ;
					}
					else
					{
						$affichage .= '<a href="' . $LIEN . '&page=' . $i . '">' . $i . '</a>' ;
					}

					if(($n + 1 < 10) AND ($i != $nbPagesPossibles))
					{
						$affichage .= ' | ' ;
					}

					$i++;
					$n++;
				}

				$i--;

				if($i != $nbPagesPossibles) // Si on est pas arrivé sur la dernière page, on l'affiche tout de même
				{
					if($i + 1 != $nbPagesPossibles) // Si on est sur l'avant dernière page, on affiche pas les "..."
					{
						$pageRetro = $page + 10 ;

						if($pageRetro >= $nbPagesPossibles)
						{
							$pageRetro = $nbPagesPossibles - 1 ;
						}

						$affichage .= ' <a href="' . $LIEN . '&page=' . $pageRetro . '=">...</a>' ;
					}
					else
					{
						$affichage .= ' |' ;
					}

					$affichage .= ' <a href="' . $LIEN . '&page=' . $nbPagesPossibles . '">' . $nbPagesPossibles . '</a>' ;
				}
			// } Fin - Affichage des pages

			$affichage .= '' ;

			$affichage .= '' ;
		}

		return $affichage;
	}

	function avert($texte) // Avertissement
	{
		echo '
		<br />
		<div class="avert">
		<span style="float: left;">
		<img src="images/ico/avert/8.png" height="20" width="20" />
		</span>
		  ' . bbCode($texte) . '
		</div>
		';
	}

	function ifSession()
	{
		if(!isset($_SESSION['pseudo']))
		{
			avert('Connexion requise !');
			include('pied.php');
			exit;
		}
	}

	function ifModo()
	{
		if($_SESSION['acces'] < 49)
		{
			avert('Vous n\'avez pas accès à cette page !');
			include('pied.php');
			exit;
		}
	}

	function ifCodeur()
	{
		if($_SESSION['acces'] != 90)
		{
			avert('Vous n\'avez pas accès à cette page !');
			include('pied.php');
			exit;
		}
	}

	function ifAdmin()
	{
		if($_SESSION['acces'] < 89)
		{
			avert('Vous n\'avez pas accès à cette page !');
			include('pied.php');
			exit;
		}
	}

	function info($texte) // Avertissement
	{
		echo '
		<br />
		<div class="info">
		<span style="float: left;">
		<img src="images/ico/avert/7.png" height="20" width="20" />
		</span>
		  ' . bbCode($texte) . '
		</div>
		';
	}
	function separate()
	{
		$repsep = mysql_query('SELECT design FROM membres WHERE id=' . $_SESSION['id']);
		$donrep = mysql_fetch_assoc($repsep);

		if($donrep['design'] == 4)
		{
			$sep = '';
		}
		else
		{
			$sep = '<div class="separate"></div>';
		}

		return $sep;
	}

	/*$repsep2 = mysql_query('SELECT design FROM membres WHERE id=' . $_SESSION['id']);
	$donrep2 = mysql_fetch_assoc($repsep2);

	if($donrep2['design'] == 4)
	{
		$de4 = true;
	}
	else
	{
		$de4 = false;
	}*/

// No avatar
$avatarz = mysql_query('SELECT * FROM membres WHERE pseudo = "' . $_SESSION['pseudo'] . '"');
$avatar = mysql_fetch_assoc($avatarz);

if($avatar['acces'] == 20)
{
	$_SESSION['acces'] = 20;
}


if($avatar['avatar'] == "")
{
	mysql_query('UPDATE membres SET avatar = "images/no_avatar.png" WHERE pseudo = "' . $_SESSION['pseudo'] . '"');
}


// gogolebot

$reponse = mysql_query('SELECT COUNT(*) AS nbGoogle FROM connectes WHERE idPseudo = 3');
$donnees = mysql_fetch_assoc($reponse);

if($donnees['nbGoogle'] == 1)
{

	mysql_query('UPDATE `connectes` SET `timestamp`="' . time() . '" WHERE idPseudo = 3');

}
else
{

	mysql_query("INSERT INTO `connectes`(`ip`, `timestamp`, `idPseudo`, `acces`, `path`) VALUES ('0.0.0.0','" . time() . "','3','11','/index.php')");

}

?>