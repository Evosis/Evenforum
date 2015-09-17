function connexion() {

	var fCo = document.getElementById("connexion");

	var larg = document.body.clientWidth;
	var haut = document.body.clientHeight;

	if(fCo.style.display != "none")
	{
		fCo.style.marginLeft = (larg/2 - fCo.offsetWidth/2);
		fCo.style.marginTop = ((haut/2 - fCo.offsetHeight/2) - 30);
	}
}

function deconnexion() {

	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function(){

		if(xhr.readyState == 4 && xhr.status == 200)
		{

		}
	}

	xhr.open("POST","fonctions/deconnexion.php",true);
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xhr.send("deconnexion=1");
}

function inscription() {

	var fIns = document.getElementById("inscription");

	var larg = document.body.clientWidth;
	var haut = document.body.clientHeight;

	if(fIns.style.display != "none")
	{
		fIns.style.marginLeft = (larg/2 - fIns.offsetWidth/2);
		fIns.style.marginTop = ((haut/2 - fIns.offsetHeight/2) - 30);
	}
}

function coFunc(){

	var xhr = new XMLHttpRequest();
	var pseudo = document.getElementById('pseudo').value;
	var passe = document.getElementById('pass').value;
	var bCo = document.getElementById('bCo');
	var bCoCours = document.getElementById('bCoCours');

	if(pseudo == '')
	{
		document.getElementById('pseudo').style.border="1px solid #FF9396";
		var pOk = 0;
	}
	else
	{
		document.getElementById('pseudo').style.border="1px solid #727CC2";
		var pOk = 1;
	}
	if(passe == '')
	{
		document.getElementById('pass').style.border="1px solid #FF9396";
		var p2Ok = 0;
	}
	else
	{
		document.getElementById('pass').style.border="1px solid #727CC2";
		var p2Ok = 1;
	}

	if(pOk == 1 && p2Ok == 1)
	{
		xhr.onreadystatechange = function(){

			bCo.style.display="none";
			bCoCours.style.display="inline";

			if(xhr.readyState == 4 && xhr.status == 200)
			{
				cReponse = xhr.responseText;
				if(cReponse.length > 1)
				{
					document.getElementById('barreHaut').innerHTML = cReponse;
					$("#connexion").fadeOut("slow");

					var xhr2 = new XMLHttpRequest();
						xhr2.onreadystatechange = function(){

							cReponse = xhr2.responseText;
							document.getElementById('sousMenuTable').innerHTML = cReponse;

						}
						xhr2.open("POST","fonctions/connexion.php",true);
						xhr2.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
						xhr2.send("yep=1");
				}
				else if(cReponse == '1')
				{
					bCo.style.display="inline";
					bCoCours.style.display="none";
					alert('Vous êtes déjà connecté !');
				}
				else if(cReponse == '2')
				{
					bCo.style.display="inline";
					bCoCours.style.display="none";
					document.getElementById('cErreur').innerHTML = 'Mauvais pseudo et/ou mot de passe.';
				}
				else if(cReponse == '3')
				{
					bCo.style.display="inline";
					bCoCours.style.display="none";
					document.getElementById('cErreur').innerHTML = 'Votre pseudo a été banni temporairement.';
				}
				else if(cReponse == '4')
				{
					bCo.style.display="inline";
					bCoCours.style.display="none";
					document.getElementById('cErreur').innerHTML = 'Votre pseudo a été banni définitivement.';
				}
				else if(cReponse == '5')
				{
					bCo.style.display="inline";
					bCoCours.style.display="none";
					document.getElementById('cErreur').innerHTML = 'Ce pseudo n\'a pas encore été validé !';
				}
				else if(cReponse == '6')
				{
					bCo.style.display="inline";
					bCoCours.style.display="none";
					document.getElementById('cErreur').innerHTML = 'Trop de tentatives d\'authentification aujourd\'hui.';
				}
				else
				{
					bCo.style.display="inline";
					bCoCours.style.display="none";
					document.getElementById('cErreur').innerHTML = 'Une erreur interne est survenu !';
				}
				
			}
		}

		xhr.open("POST","fonctions/connexion.php",true);
		xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xhr.send("pseudo="+pseudo+"&passe="+passe);
	}
}

function insFunc(n){

	if(n == 1)
	{
		var xhr = new XMLHttpRequest();
		var vePseudo = document.getElementById('insPseudo').value;

		if(vePseudo.length < 3 || vePseudo.length > 15)
		{
			document.getElementById('iErreur').innerHTML = 'Ce pseudo ne respecte pas la taille demandé !';
			document.getElementById('insPseudo').style.border="1px solid #FF9396";
		}
		else
		{
			document.getElementById('iErreur').innerHTML = '';
			document.getElementById('insPseudo').style.border="1px solid #727CC2";

			xhr.onreadystatechange = function(){

				if(xhr.readyState == 4 && xhr.status == 200)
				{
					veReponse = xhr.responseText;

					if(veReponse == '1')
					{
						document.getElementById('iErreur').innerHTML = 'Le nom de compte est déjà utilisé :(';
						document.getElementById('insPseudo').style.border="1px solid #FF9396";
					}
					else if(veReponse == '2')
					{
						document.getElementById('insPseudo').style.border="1px solid #46FF4A";
					}
				}
			}

			xhr.open("POST","fonctions/inscription.php",true);
			xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			xhr.send("vePseudo="+vePseudo);
		}
	}
	else if(n == 2)
	{
		var pass = document.getElementById('insPass').value;
		var pass2 = document.getElementById('pass2').value;

		if(pass != pass2 && pass2 != '')
		{
			document.getElementById('iErreur').innerHTML = 'Les mots de passes ne sont pas identiques !';
			document.getElementById('pass2').style.border="1px solid #FF9396";
		}
		else if(pass != '' && pass2 != '')
		{
			document.getElementById('iErreur').innerHTML = '';
			document.getElementById('pass2').style.border="1px solid #46FF4A";
		}
		else if(pass != pass2 || pass == '' && pass2 == '')
		{
			document.getElementById('iErreur').innerHTML = '';
			document.getElementById('pass2').style.border="1px solid #727CC2";
			document.getElementById('pass2').style.border="1px solid #727CC2";
		}
	}
	else if(n == 3)
	{
		var xhr = new XMLHttpRequest();
		var pseudo = document.getElementById('insPseudo').value;
		var pass = document.getElementById('insPass').value;
		var pass2 = document.getElementById('pass2').value;
		var email = document.getElementById('email').value;
		var bIns = document.getElementById('bIns');
		var bInsCours = document.getElementById('bInsCours');

		/*if(pseudo.length < 3 || pseudo.length > 15)
		{
			document.getElementById('mPseudo').innerHTML = '<font color="red">Ce pseudo ne respecte pas la taille demandé !</font>';
		}
		else
		{*/
			xhr.onreadystatechange = function(){

				bIns.style.display="none";
				bInsCours.style.display="inline";

				if(xhr.readyState == 4 && xhr.status == 200)
				{	
					iReponse = xhr.responseText;
					bIns.style.display="inline";
					bInsCours.style.display="none";
					document.getElementById('insPseudo').style.border="1px solid #727CC2";
					document.getElementById('insPass').style.border="1px solid #727CC2";
					document.getElementById('pass2').style.border="1px solid #727CC2";
					document.getElementById('email').style.border="1px solid #727CC2";

					if(iReponse.length > 1)
					{
						document.getElementById('inscription').innerHTML = iReponse;
					}
					else if(iReponse == '1')
					{
						document.getElementById('iErreur').innerHTML = 'Vous êtes déjà connectés !';
					}
					else if(iReponse == '2')
					{
						document.getElementById('iErreur').innerHTML = 'Le nom de compte est déjà utilisé :(';
						document.getElementById('insPseudo').style.border="1px solid #FF9396";
					}
					else if(iReponse == '3')
					{
						document.getElementById('iErreur').innerHTML = 'L\'adresse email entrée n\'est pas valide !';
						document.getElementById('email').style.border="1px solid #FF9396";
					}
					else if(iReponse == '4')
					{
						document.getElementById('iErreur').innerHTML = 'Le mot de passe est trop court ou trop long !';
						document.getElementById('insPass').style.border="1px solid #FF9396";
					}
					else if(iReponse == '5')
					{
						document.getElementById('iErreur').innerHTML = 'Le nom de compte ne respecte pas les conditions !';
						document.getElementById('insPseudo').style.border="1px solid #FF9396";
					}
					else if(iReponse == '6')
					{
						document.getElementById('iErreur').innerHTML = 'Les deux mots de passe ne correspondent pas !';
						document.getElementById('insPass').style.border="1px solid #FF9396";
						document.getElementById('pass2').style.border="1px solid #FF9396";
					}
					else if(iReponse == '7')
					{
						document.getElementById('iErreur').innerHTML = 'Un champ obligatoire a pas été rempli !';
					}
				}
			}

			xhr.open("POST","fonctions/inscription.php",true);
			xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			xhr.send("pseudo="+pseudo+"&pass="+pass+"&pass2="+pass2+"&email="+email);
		//}
	}
}

function switchCo() {

	var fCo = document.getElementById("connexion");
	var fIns = document.getElementById("inscription");

	if(fCo.style.display != "none")
	{
		$("#connexion").fadeOut("slow",function(){
		   $("#inscription").fadeIn("slow");
		});
	}
	else
	{
		$("#inscription").fadeOut("slow",function(){
		   $("#connexion").fadeIn("slow");
		});
	}
}