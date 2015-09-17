underscoreFocus = false;

function appTerminalUnderscoreFocus() {

	underscoreFocus = true;
	appTerminalUnderscore();
	appTerminalInput();
	$("#appTerminalInput").focus();
}

function appTerminalUnderscoreBlur() {

	underscoreFocus = false;
	document.getElementById("appTerminalUnderscore").innerHTML = "";
}

function appTerminalUnderscore() {

	if(underscoreFocus == true)
	{
		if(document.getElementById("appTerminalUnderscore").innerHTML == "")
		{
			document.getElementById("appTerminalUnderscore").innerHTML = "_";
			setTimeout("appTerminalUnderscore()", 750);
		}
		else
		{
			document.getElementById("appTerminalUnderscore").innerHTML = "";
			setTimeout("appTerminalUnderscore()", 750);
		}
	}
}

function appTerminalInput() {

	document.getElementById("appTerminalSaisie").innerHTML = document.getElementById("appTerminalInput").value;
	setTimeout("appTerminalInput()", 10);
}

function appTerminalEnter(pseudo) {

	switch(document.getElementById("appTerminalInput").value)
	{
		case "exit":
			appFermer("appTerminal");
		break;
		case "hello":
			document.getElementById("appTerminalReponse").innerHTML = document.getElementById("appTerminalReponse").innerHTML + pseudo + "@evenforum:~$ " + document.getElementById("appTerminalInput").value + "<br />" + "hello" + "<br />";
		break;
		case "uname":
			document.getElementById("appTerminalReponse").innerHTML = document.getElementById("appTerminalReponse").innerHTML + pseudo + "@evenforum:~$ " + document.getElementById("appTerminalInput").value + "<br />" + "EvenforumOS 0.1.3" + "<br />";
		break;
	}

	document.getElementById("appTerminalInput").value = "";
}