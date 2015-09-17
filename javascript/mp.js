function mpMenu(action, page) {

	$("#lire").fadeOut("slow");
	$("#ecrire").fadeOut("slow");
	$("#supprimerSelect").fadeOut("slow",function(){
		$("#envoyerLien").fadeOut("slow",function(){

			$("#"+action).fadeIn("slow");
			window.history.pushState('page'+action, 'Title', '/mp.php?action='+action+'&page='+page);

			if(action == "lire")
			{
				$("#supprimerSelect").fadeIn("slow");
			}
			else if(action == "ecrire")
			{
				$("#envoyerLien").fadeIn("slow");
			}
		});
	});
}

function mpSupprimer(id) {

	if(document.getElementById("checkbox_"+id).checked == true)
	{
		$("#"+id).switchClass( "pasSelect", "select", 500, "easeInOutQuad");
		$("#"+id+"a").switchClass( "pasSelect", "select", 500, "easeInOutQuad");
		$("#"+id+"b").switchClass( "pasSelect", "select", 500, "easeInOutQuad");
		$("#"+id+"c").switchClass( "pasSelect", "select", 500, "easeInOutQuad");
		$("#"+id+"d").switchClass( "pasSelect", "select", 500, "easeInOutQuad");
		$("#"+id+"e").switchClass( "pasSelect", "select", 500, "easeInOutQuad");
	}
	else
	{
		$("#"+id).switchClass( "select", "pasSelect", 500, "easeInOutQuad");
		$("#"+id+"a").switchClass( "select", "pasSelect", 500, "easeInOutQuad");
		$("#"+id+"b").switchClass( "select", "pasSelect", 500, "easeInOutQuad");
		$("#"+id+"c").switchClass( "select", "pasSelect", 500, "easeInOutQuad");
		$("#"+id+"d").switchClass( "select", "pasSelect", 500, "easeInOutQuad");
		$("#"+id+"e").switchClass( "select", "pasSelect", 500, "easeInOutQuad");
	}
}

function mpSupprimerAll(ele) {
     var checkboxes = document.getElementsByTagName('input');
    if (ele.checked) 
    {
        for (var i = 0; i < checkboxes.length; i++) 
        {
            if (checkboxes[i].type == 'checkbox') 
            {
                checkboxes[i].checked = true;
            }
        }

         $('td[name=supprimerTd]').switchClass( "pasSelect", "select", 500, "easeInOutQuad");
    } 
    else 
    {
        for (var i = 0; i < checkboxes.length; i++) 
        {
            if (checkboxes[i].type == 'checkbox') 
            {
                checkboxes[i].checked = false;
            }
        }

        $('td[name=supprimerTd]').switchClass( "select", "pasSelect", 500, "easeInOutQuad");
    }
 }