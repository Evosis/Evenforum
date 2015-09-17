function lancer(id) {
	
	$("#"+id).fadeIn("slow");
	$("#overlay").fadeIn("slow");
	var marginLeft = ((1400 / 2) - (document.getElementById(id).offsetWidth / 2));
	var marginTop = 0 - document.getElementById(id).offsetHeight / 2;
	document.getElementById(id).style.marginTop = marginTop + 'px'
	document.getElementById(id).style.marginLeft = marginLeft + 'px';
}

function fermer(id) {
	
	$("#"+id).fadeOut("slow");
	$("#overlay").fadeOut("slow");
}