function menuOuvrir(n) {
	
	var sousMenu = document.getElementById(n);

	sousMenu.style.display="table";
}

function menuFermer(n) {
	
	var sousMenu = document.getElementById(n);

	sousMenu.style.display="none";
}

function coMenu() {

	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function(){

		if(xhr.readyState == 4 && xhr.status == 200)
		{
			reponse = xhr.responseText;
			document.getElementById('barreHaut').innerHTML = reponse;
		}
	}

	xhr.open("POST","fonctions/menu.php",true);
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xhr.send("coMenu=1");
}