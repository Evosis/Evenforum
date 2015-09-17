function appLaunch(id) {

		document.body.style.cursor = "progress";
		var xhr = new XMLHttpRequest();

		xhr.onreadystatechange = function(){

			if(xhr.readyState == 4 && xhr.status == 200)
			{
				aReponse = xhr.responseText;
				document.getElementById(id).innerHTML = aReponse;
				document.body.style.cursor = "auto";
				$("#"+id).fadeIn("slow");
			}
		}

		xhr.open("POST","fonctions/app.php",true);
		xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xhr.send("app="+id);
}
function appAgrandir(id) {

	var hauteur = document.body.clientHeight - 47;
	var hauteur2 = document.body.clientHeight - 57;
	var largeur = document.body.clientWidth - 25;

	$("#"+id).animate({ 
        marginLeft: "0px",
        marginTop: "0px",
        width: largeur, 
        height: hauteur
    }, 1500 );
    $("#"+id+"Contenu").animate({ 
        marginLeft: "0px",
        marginTop: "0px",
        height: hauteur2
    }, 1500 );
}
function appReduire(id) {

	$("#"+id).fadeOut("slow");
}
function appFermer(id) {

	$("#"+id).fadeOut("slow",function(){
	   document.getElementById(id).innerHTML = "";
	   document.getElementById(id).style.marginLeft = "0px";
	   document.getElementById(id).style.marginTop = "0px";
	   document.getElementById(id).style.width = "500px";
	   document.getElementById(id).style.height = "250px";
	});
}

var bougeX;
var bougeY;
var x;
var y;

function bouger(evenement,id)
{
	document.onmousemove = function(e) {bouger(e, id);}
	bougeX = evenement.pageX;
	bougeY = evenement.pageY;
	x = evenement.clientX - document.getElementById(id).style.marginLeft.replace("px", "");
	y = evenement.clientY - document.getElementById(id).style.marginTop.replace("px", "");
	document.getElementById(id).style.marginLeft = bougeX-250 +"px";
	document.getElementById(id).style.marginTop = bougeY-30 + "px";
}

function stop_bouge(evenement,id)
{
	document.onmousemove = null;
	bougeX = evenement.pageX;
	bougeY = evenement.pageY;
	document.getElementById(id).style.marginLeft = bougeX-x +"px";
	document.getElementById(id).style.marginTop = bougeY-y + "px";
}
