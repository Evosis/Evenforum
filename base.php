<?php
session_start();

include('logs_sql.php');
include('engine/numeric_values.php');
include('engine/exp.php');
include('engine/item_engine.php');
include('engine/skills_engine.php');

/*
$timer = "77.134.14.138";
$gtapro = "135.19.54.42";

if($_SESSION['id'] == 1 AND $_SERVER['REMOTE_ADDR'] != $timer)
{
	include('tete.php');
	avert('IP non autorisée pour ce compte, déconnexion...');
	session_destroy();
	include('pied.php');
	exit;
}

if($_SESSION['id'] == 2 AND $_SERVER['REMOTE_ADDR'] != $gtapro)
{
	include('tete.php');
	avert('IP non autorisée pour ce compte, déconnexion...');
	session_destroy();
	include('pied.php');
	exit;
}
*/

function avert($texte)
{
	echo '
	<div class="avert">ERREUR : ' . htmlspecialchars($texte) . '</div>
	';
}

function info($texte)
{
	echo '
	<div class="info">INFORMATIONS : ' . htmlspecialchars($texte) . '</div>
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

function siMembre() {
	
	if(!isset($_SESSION['pseudo']))
	{
		avert('Vous devez être connecté pour accéder à cette page.');
		include('pied.php');
		exit;
	}
}

function siAdmin() {

	if($_SESSION['acces'] < 90)
	{
		avert('Vous devez être un administrateur pour accéder à cette page.');
		include('pied.php');
		exit;
	}
}

function siNCAdmin($connexion) {

	$q_membres = $connexion->prepare('SELECT * FROM membres WHERE id = ' . $_SESSION['id'] . '');
	$q_membres->execute();
	$membre = $q_membres->fetch(PDO::FETCH_OBJ);

	if($membre->acces < 90)
	{
		avert('Accès refusé !');
		include('pied.php');
		exit;
	}
}

function notification($idPseudo, $icon, $texte, $connexion)
{
	$connexion->query("INSERT INTO notifications VALUES('', '" . $idPseudo . "', '" . $icon . "', '" . $texte . "', '0', '0', '" . time() . "')");
}


function bbCode($t)
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

	// décalage
	$t = preg_replace('#\[label\](.+?)\[/label\]#is', '<label>$1</label>', $t);

	// soulignement
	$t = preg_replace('#\[u\](.+?)\[/u\]#is', '<u>$1</u>', $t);

	// citer
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);
	$t = preg_replace('#\[citer\](.+?)\[/citer\]#is', '<blockquote>$1</blockquote>', $t);

	// Infos
	$t = preg_replace('#\[inf\](.+?)\[/inf\]#is', '<a href="#" title="$1"><sup>?</sup></a>', $t);

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

				if($nb < 61)
				{
					$LIEN .= $array[0];
				}
				else
				{
					$LIEN .= mb_substr($array[0], 0, 20) . \'[...]\' . mb_substr($array[0], ($nb - 20), 20) ;
				}

				$LIEN .= \'</a>\' ;


				return $LIEN;
			') ;

	// on applique la REGEX du lien
		$t = preg_replace_callback('#http://[^ \n\r\'"]+#i', $callbackLien, $t); // lien
		$t = preg_replace_callback('#https://[^ \n\r\'"]+#i', $callbackLien, $t); // lien

	// Smileys
		$smileys = array(':loltimer:' => 'loltimer', ':popopo:' => 'popopo', ':hapoelia:' => 'hapoelia', ':julien:' => 'julien', ':jeremy:' => 'jeremy', ':patrick:' => 'patrick', ':salecon:' => 'salecon', ':fuck:' => 'fuck', ':haps:' => 'hapseb', ':hanouna:' => 'hanouna', ':hapoelparty:' => 'hapoelparty', ':ahok:' => 'ahok', ':hapwesh:' => 'hapwesh', ':colerenoel:' => 'colerenoel', ':+1:' => 'plus1', ':awesome:' => 'awesome', ':troll:' => 'troll', ':toel:' => 'toel', ':okcool:' => 'okcool', ':bridou:' => 'bridou', ':pedoface:' => 'pedophile', ':beauf:' => 'beauf', ':timer:' => 'timer', ':gta:' => 'gta', ':gerardok:' => 'gerardok', ':michael:' => 'michael', ':autiste:' => 'autiste', ':biere:' => 'biere', ':ahuri:' => 'ahuri', ':jackyok:' => 'jackyok', ':martin:' => 'martin', ':mercille:' => 'mercille', ':quebec:' => 'quebec', ':tucherchelamerde:' => 'tucherchelamerde', ':fier2:' => 'fier2', ':hapoel:' => 'hapoel', ':troll:' => 'troll', ':bave3:' => 'bave3', ':baveok:' => 'baveok', ':cute:' => 'cute', ':technook:' => 'technook', ':mechant:' => 'mechant', ':pf:' => 'pf', ':haphum:' => 'haphum', ':bavecoeur:' => 'bavecoeur', ':coeurhum:' => 'coeurhum', ':mario:' => 'mario', ':bavenoel:' => 'bavenoel',  ':noelb:' => 'noelb', ':bave2:' => 'bave2', ':cool2:' => 'cool2', ':noelok2:' => 'noelok2', ':haprouge:' => 'haprouge', ':humxd:' => 'humxd', ':hap):' => 'hap)', ':snif3:' => 'snif3', ':supergni:' => 'supergni', ':quoi:' => 'quoi', ':empereur:' => 'empereur', ':cake:' => 'cake', ':noelok:' => 'noelok', ':agenda:' => 'agenda', ':hapfake:' => 'hapfake', ':firefox:' => 'firefox', ':pal:' => 'pal', ':vaincra:' => 'vaincra', ':hapsnif:' => 'hapsnif', ':salut2:' => 'salut2', ':hapange:' => 'hapange', ':hapnoel:' => 'hapnoel', ':haplol:' => 'haplol', ':fake:' => 'fake', ':owned:' => 'owned', ':censored:' => 'censored', ':shauni:' => 'shauni', ':pedo:' => 'pedo', ':peurnoel:' => 'peurnoel', ':oupas:' => 'oupas', ':nonnonnoel:' => 'nonnonnoel', ':bide:' => 'bide', ':humnoel:' => 'humnoel', ':clownnoel:' => 'clownnoel', ':grotte:' => 'grotte', ':jerry:' => 'jerry', ':founoel:' => 'founoel', ':)' => '=)', ':o))' => '=o))', ':hap:' => 'hap', ':content:' => 'content', ':cool:' => 'cool', ':rire2:' => 'rire2', ':sournois:' => 'sournois', ':gni:' => 'gni', ':merci:' => 'merci', ':rechercher:' => 'rechercher', ':gne:' => 'gne', ':snif2:' => 'snif2', ':ouch:' => 'ouch', ':ouch2:' => 'ouch2', ':nonnon:' => 'nonnon', ':non2:' => 'non2', ':non:' => 'non', ':nah:' => 'nah', ':hum:' => 'hum', ':bravo:' => 'bravo', ':svp:' => 'svp', ':hello:' => 'hello', ':lol:' => 'lol', ':gba:' => 'gba', ':mac:' => 'mac', ':pacg:' => 'pacg', ':pacd:' => 'pacd', ':fier:' => 'fier', ':malade:' => 'malade', ':ange:' => 'ange', ':desole:' => 'desole', ':sors:' => 'sors', ':up:' => 'up', ':dpdr:' => 'dpdr', ':cd:' => 'cd', ':globe:' => 'globe', ':question:' => 'question', ':mort:' => 'mort', ':sleep:' => 'sleep', ':honte:' => 'honte', ':monoeil:' => 'monoeil', ':diable:' => 'diable', ':spoiler:' => 'spoiler', ':bye:' => 'bye', ':hs:' => 'hs', ':banzai:' => 'banzai', ':bave:' => 'bave', ':xd:' => 'xd', ':(' => '=(', ':-D' => '=-D', ':d)' => '=d)', ':g)' => '=g)', ':p)' => '=p)', ':salut:' => 'salut', ':fete:' => 'fete', ':noel:' => 'noel', ':rire:' => 'rire', ':-p' => '=-p', ':fou:' => 'fou', ':coeur:' => 'coeur', ':rouge:' => 'rouge', ':oui:' => 'oui', ':dehors:' => 'dehors', ':peur:' => 'peur', ':ok:' => 'ok', ':sarcastic:' => 'sarcastic', ':doute:' => 'doute', ':snif:' => 'snif', ':fouet:' => 'fouet', ':sortie:' => 'sortie', ':jbsd:' => 'jbsd', ':-)))' => '=-)))', ':-((' => '=-((');

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


function entier_romain($entier)
{
    $entier = intval($entier);
    if($entier<1 || $entier>9999)return "";
    
    $rom[3][4];
    $rom[3] = array("M", "", "", "");
    $rom[2] = array("C", "CD", "D", "CM");
    $rom[1] = array("X", "XL", "L", "XC");
    $rom[0] = array("I", "IV", "V", "IX");

    $i = 1;
    $n = 0;
    $romain = "";
    
    for($n=0; $n<4; $n++)
    {
    $chiffre = intval(($entier % ($i*10))/$i);
    if($n<3)
    {
        if($chiffre<4)
        {
        while($chiffre>0)
        {
            $romain = $rom[$n][0].$romain;
            $chiffre--;
        }
        }
        elseif($chiffre==4)
        $romain = $rom[$n][1].$romain;
        elseif($chiffre<9)
        {
        while($chiffre>5)
        {
            $romain = $rom[$n][0].$romain;
            $chiffre--;
        }
        $romain = $rom[$n][2].$romain;
        }
        else
        $romain = $rom[$n][3].$romain;
    }
    else
    {
        while($chiffre>0)
        {
        $romain = $rom[$n][0].$romain;
        $chiffre--;
        }
    }
    $i = $i*10;
    }
    return $romain;
}

$reponse = $connexion->query('SELECT * FROM configuration');

while($donnees = $reponse->fetch(PDO::FETCH_OBJ))
{
	$configuration[$donnees->nom] = $donnees->valeur;
}

$count = $connexion->query('SELECT COUNT(*) FROM connectes WHERE ip="' . $_SERVER['REMOTE_ADDR'] . '"')->fetchColumn();
$countConnectes = $connexion->query('SELECT COUNT(*) FROM connectes')->fetchColumn();

if($countConnectes < 2)
{
	$s = '';
}
else
{
	$s = 's';
}

if($count == 0) // Si l'ip n'est pas déjà dans la table
{
	if(!isset($_SESSION['id'])) // Et qu'on est pas connecté, on la rajoute
	{
		$envoi = $connexion->prepare("INSERT INTO connectes VALUES(:idPseudo, :acces, :ip, :timestamp, :path, :clefUnique)");
		$envoi->execute(array(
		'idPseudo' => 0,
		'acces' => 0,
		'ip' => $_SERVER['REMOTE_ADDR'],
		'timestamp' => time(),
		'path' => $_SERVER['PHP_SELF'],
		'clefUnique' => ''
		));
	}
	else // Si on est connecté on la rajoute quand même. :hap:
	{
		$envoi = $connexion->prepare("INSERT INTO connectes VALUES(:idPseudo, :acces, :ip, :timestamp, :path, :clefUnique)");
		$envoi->execute(array(
		'idPseudo' => $_SESSION['id'],
		'acces' => $_SESSION['acces'],
		'ip' => $_SERVER['REMOTE_ADDR'],
		'timestamp' => time(),
		'path' => $_SERVER['PHP_SELF'],
		'clefUnique' => ''
		));
	}
}
else // Sinon on l'update
{
	if(!isset($_SESSION['id'])) // Et qu'on est pas connecté, on l'update
	{
		$connexion->exec('UPDATE connectes SET idPseudo = 0, acces = 0, ip = "' . $_SERVER['REMOTE_ADDR'] . '", timestamp = ' . time() . ', path = "' . $_SERVER['REQUEST_URI']. '" WHERE ip = "' . $_SERVER['REMOTE_ADDR'] . '"');
	}
	else // Si on est connecté on l'update quand même. :hap:
	{
		$connexion->exec('UPDATE connectes SET idPseudo = ' . $_SESSION['id'] . ', acces = ' . $_SESSION['acces'] . ', ip = "' . $_SERVER['REMOTE_ADDR'] . '", timestamp = ' . time() . ', path = "' . $_SERVER['REQUEST_URI'] . '" WHERE ip = "' . $_SERVER['REMOTE_ADDR'] . '"');
	}
}
$kickout = time() - $configuration['kickout'];
$connexion->exec('DELETE FROM connectes WHERE timestamp <= ' . $kickout . '');

if(isset($_SESSION['pseudo']))
{

	$countPerso = $connexion->query('SELECT COUNT(*) FROM personnages WHERE idPseudo = "' . $_SESSION['id'] . '" AND killed = 0')->fetchColumn();

	if($countPerso > 0)
	{
		$denied = 0;
	}
	else
	{
		$denied = 1;
	}

	if($denied == 0)
	{

		function giveEXP($montant, $membre, $connexion)
		{
			if(isset($_SESSION['pseudo']))
			{
				$donnees = $connexion->prepare('UPDATE membres SET experience = (experience + ' . $montant . ') WHERE pseudo = "' . $membre . '"');
				$donnees->execute();
			}

		}

		function giveEC($montant, $membre, $connexion)
		{
			if(isset($_SESSION['pseudo']))
			{
				$donnees = $connexion->prepare('UPDATE membres SET ec = (ec + ' . $montant . ') WHERE pseudo = "' . $membre . '"');
				$donnees->execute();
			}

		}

		function givePB($montant, $membre, $connexion)
		{
			if(isset($_SESSION['pseudo']))
			{
				$donnees = $connexion->prepare('UPDATE membres SET pb = (pb + ' . $montant . ') WHERE pseudo = "' . $membre . '"');
				$donnees->execute();
			}

		}

		function giveRP($montant, $membre, $connexion)
		{
			if(isset($_SESSION['pseudo']))
			{
					$donnees = $connexion->prepare('UPDATE membres SET rp = (rp + ' . (int) $montant . ') WHERE pseudo = "' . $membre . '"');
					$donnees->execute();
			}

		}
	}
	else
	{
		function giveEXP($montant, $membre, $connexion)
		{
			if(isset($_SESSION['pseudo']))
			{
				$donnees = $connexion->prepare('UPDATE membres SET experience = (experience + 0) WHERE pseudo = "' . $membre . '"');
				$donnees->execute();
			}

		}

		function giveEC($montant, $membre, $connexion)
		{
			if(isset($_SESSION['pseudo']))
			{
				$donnees = $connexion->prepare('UPDATE membres SET ec = (ec + 0) WHERE pseudo = "' . $membre . '"');
				$donnees->execute();
			}

		}

		function givePB($montant, $membre, $connexion)
		{
			if(isset($_SESSION['pseudo']))
			{
				$donnees = $connexion->prepare('UPDATE membres SET pb = (pb + 0) WHERE pseudo = "' . $membre . '"');
				$donnees->execute();
			}

		}

		function giveRP($montant, $membre, $connexion)
		{
			if(isset($_SESSION['pseudo']))
			{
					$donnees = $connexion->prepare('UPDATE membres SET rp = (rp + 0) WHERE pseudo = "' . $membre . '"');
					$donnees->execute();
			}

		}
	}
}

//Premium

if($donnees_membres->acces == 20)
{
	$_SESSION['acces'] = 20;
}


include('pagination.php');
include('engine/drop_engine.php');
include('engine/ach_engine.php');
?>