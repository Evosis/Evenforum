<?php

/*

Types :

	- 1 - 		Objet de quête / important / impossible a revendre
	- 2 -		Ressources telle que les matières première ect, revendable
	- 3 -		Armes
	- 4 -		Consommables (type potion/pilules)
	- 5 -		Bonus d'EXP / EC / Promotions
	- 6 -		Premium Item (utilisable uniquement par les premiums)

*/

/*

Rareté :

	- 1 -		Commun
	- 2 -		Peu commun
	- 3 -		Assez rare
	- 4 -		Rare
	- 5 -		Très rare
	- 6 -		Légendaire
	- 7 -		Introuvable
	- 8 -		Unique
	- 9 -		Indroppable

*/



/// PILULES / SYSTEM ITEM

$item[0]['nom'] = "Objet cassé";
$item[0]['valeur'] = "0";
$item[0]['type'] = "1";
$item[0]['drop'] = 9;
$item[0]['description'] = "Cet objet est cassé.";

$item[1]['nom'] = "Pilule de promotion";
$item[1]['valeur'] = "500000";
$item[1]['type'] = "5";
$item[1]['drop'] = 9;
$item[1]['description'] = "En avalant cette pilule orangée, vous serez directement promu au rang Premium ! Utiisable qu'une seule et unique fois par compte.";

$item[2]['nom'] = "Pilule d'oubli";
$item[2]['valeur'] = "120000";
$item[2]['type'] = "4";
$item[2]['drop'] = 7;
$item[2]['description'] = "Voici la pilule bleue ! Elle permet de réinitialiser les caractéristiques. Les points dépensés sont donc rendus. (excepté le boost par pilules.)";

$item[3]['nom'] = "Pilule d'intelligence";
$item[3]['valeur'] = "250000";
$item[3]['type'] = "4";
$item[3]['drop'] = 7;
$item[3]['description'] = "Étrangement, cette pilule vous fait voir des étoiles. Ajoute + 100 d'intelligence à vos statistiques.";

$item[4]['nom'] = "Pilule de vitalité";
$item[4]['valeur'] = "250000";
$item[4]['type'] = "4";
$item[4]['drop'] = 7;
$item[4]['description'] = "Accélérez votre vie sans accélérer la mort ! Ajoute + 100 de vitalité à vos statistiques.";

$item[5]['nom'] = "Pilule de force";
$item[5]['valeur'] = "250000";
$item[5]['type'] = "4";
$item[5]['drop'] = 7;
$item[5]['description'] = "Si seulement c'était aussi simple en vrai... Ajoute + 100 de force à vos statistiques.";

$item[6]['nom'] = "Pilule d'agilité";
$item[6]['valeur'] = "250000";
$item[6]['type'] = "4";
$item[6]['drop'] = 7;
$item[6]['description'] = "Boostez vos mouvements, ceci est une drogue légale et certifiée par les plus grands médecins. Ajoute + 100 d'agilité à vos statistiques.";

$item[7]['nom'] = "Pilule de chance";
$item[7]['valeur'] = "250000";
$item[7]['type'] = "4";
$item[7]['drop'] = 7;
$item[7]['description'] = "Après avoir avalé ça, vous aurez envie de bouffer des trèfles à 4 feuilles... Ajoute + 100 de chance à vos statistiques.";


/// RESSOURCES

$item[8]['nom'] = "Bâton de bois";
$item[8]['valeur'] = "2";
$item[8]['type'] = "2";
$item[8]['drop'] = 1;
$item[8]['description'] = "Un simple bâton. Rien de bien important.";

$item[9]['nom'] = "Morceau de pierre";
$item[9]['valeur'] = "1";
$item[9]['type'] = "2";
$item[9]['drop'] = 1;
$item[9]['description'] = "Depuis quand les aventuriers stockent des cailloux ? Vous venez de changer l'histoire...";

$item[10]['nom'] = "Feuille de papier";
$item[10]['valeur'] = "4";
$item[10]['type'] = "2";
$item[10]['drop'] = 1;
$item[10]['description'] = "Une feuille en papier. Vous pouvez écrire dessus.";

$item[11]['nom'] = "Enveloppe";
$item[11]['valeur'] = "100";
$item[11]['type'] = "2";
$item[11]['drop'] = 3;
$item[11]['description'] = "Cette enveloppe combiné à une feuille de papier peut se transformer en lettre que vous pouvez envoyer à un membre.";

$item[12]['nom'] = "Verre";
$item[12]['valeur'] = "17";
$item[12]['type'] = "2";
$item[12]['drop'] = 2;
$item[12]['description'] = "Un morceau de verre. Multiples usages possibles.";

$item[13]['nom'] = "Plastique";
$item[13]['valeur'] = "22";
$item[13]['type'] = "2";
$item[13]['drop'] = 1;
$item[13]['description'] = "Ce plastique est un des meilleurs. Pas qu'il y en ai de multiples sortes mais bon...";

$item[14]['nom'] = "Étain";
$item[14]['valeur'] = "110";
$item[14]['type'] = "2";
$item[14]['drop'] = 2;
$item[14]['description'] = "Un minerai de basse qualité.";

$item[15]['nom'] = "Cuivre";
$item[15]['valeur'] = "224";
$item[15]['type'] = "2";
$item[15]['drop'] = 2;
$item[15]['description'] = "Un métal un peu plus précieux avec une jolie couleur orangée.";

$item[16]['nom'] = "Laiton";
$item[16]['valeur'] = "335";
$item[16]['type'] = "2";
$item[16]['drop'] = 2;
$item[16]['description'] = "Souvent confondu avec l'Or à cause de sa couleur, le laiton coûte juste 500x moins cher.";

$item[17]['nom'] = "Aluminium";
$item[17]['valeur'] = "400";
$item[17]['type'] = "2";
$item[17]['drop'] = 3;
$item[17]['description'] = "Multiple usages possible ! L'aluminium est partout.";

$item[18]['nom'] = "Fer";
$item[18]['valeur'] = "500";
$item[18]['type'] = "2";
$item[18]['drop'] = 3;
$item[18]['description'] = "Une bonne épée est forgé avec du bon fer. En espérant que le vôtre soit bon...";

$item[19]['nom'] = "Bronze";
$item[19]['valeur'] = "1100";
$item[19]['type'] = "2";
$item[19]['drop'] = 4;
$item[19]['description'] = "Le bronze assure une solidité sans précédent.";

$item[20]['nom'] = "Argent";
$item[20]['valeur'] = "2800";
$item[20]['type'] = "2";
$item[20]['drop'] = 4;
$item[20]['description'] = "Un métal plus précieux que le bronze.";

$item[21]['nom'] = "Or";
$item[21]['valeur'] = "5585";
$item[21]['type'] = "2";
$item[21]['drop'] = 5;
$item[21]['description'] = "L'or, qui donne la création possible de toute chose précieuse.";

$item[22]['nom'] = "Platine";
$item[22]['valeur'] = "7741";
$item[22]['type'] = "2";
$item[22]['drop'] = 5;
$item[22]['description'] = "Considéré comme supérieur à l'or, voici le platine.";

$item[23]['nom'] = "Rubis";
$item[23]['valeur'] = "12995";
$item[23]['type'] = "2";
$item[23]['drop'] = 5;
$item[23]['description'] = "Un minerai très apprécié des bijoutiers. Sa couleur rouge est étincelante !";

$item[24]['nom'] = "Saphir";
$item[24]['valeur'] = "33988";
$item[24]['type'] = "2";
$item[24]['drop'] = 6;
$item[24]['description'] = "Le saphir n'est pas souvent utilisé pour les armes. Je me demande ce qu'une épée de saphir ferait.";

$item[25]['nom'] = "Émeraude";
$item[25]['valeur'] = "88990";
$item[25]['type'] = "2";
$item[25]['drop'] = 6;
$item[25]['description'] = "Avec sa couleur verdâtre, il s'agit là d'un magnifique minerai.";

$item[26]['nom'] = "Diamant";
$item[26]['valeur'] = "335841";
$item[26]['type'] = "2";
$item[26]['drop'] = 7;
$item[26]['description'] = "Inclinez-vous devant le plus résistant des minerais, le diamant.";

?>