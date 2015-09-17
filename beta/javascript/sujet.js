function confirmer(h3, texte, lien) {

	document.getElementById('confirmH3').innerHTML = h3;
	document.getElementById('confirmTexte').innerHTML = texte;
	document.getElementById('confirmLien').href = lien;

	lancer('confirm');
}

function confirmer2(h3, texte, onclick) {

	document.getElementById('confirm2H3').innerHTML = h3;
	document.getElementById('confirm2Texte').innerHTML = texte;
	document.getElementById('confirm2Onclick').innerHTML = '<a href="#" onclick="document.getElementById(\''+onclick+'\').submit(); return false;" id="confirm2Onclick"><button>Oui</button></a>';

	lancer('confirm2');
}

function deplacerSujet() {
	if(document.getElementById('deplacer').style.height == '0px')
	{
		$("#deplacer").animate({ 
	        height: "45px"
	    }, 500 );
	}
	else
	{
		$("#deplacer").animate({ 
	        height: "0px"
	    }, 500 );
	}
}