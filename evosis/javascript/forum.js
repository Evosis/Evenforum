function sujetSupprimer(id) {

	if(document.getElementById("checkbox_"+id).checked == true)
	{
		$("#"+id).switchClass( "pasSelect", "select", 500, "easeInOutQuad");
		$("#"+id+"a").switchClass( "pasSelect", "select", 500, "easeInOutQuad");
		$("#"+id+"b").switchClass( "pasSelect", "select", 500, "easeInOutQuad");
		$("#"+id+"c").switchClass( "pasSelect", "select", 500, "easeInOutQuad");
		$("#"+id+"d").switchClass( "pasSelect", "select", 500, "easeInOutQuad");
		$("#"+id+"e").switchClass( "pasSelect", "select", 500, "easeInOutQuad");

		$("#forumModeration").animate({ 
	        height: "105px"
	    }, 500 );
	}
	else
	{
		$("#"+id).switchClass( "select", "pasSelect", 500, "easeInOutQuad");
		$("#"+id+"a").switchClass( "select", "pasSelect", 500, "easeInOutQuad");
		$("#"+id+"b").switchClass( "select", "pasSelect", 500, "easeInOutQuad");
		$("#"+id+"c").switchClass( "select", "pasSelect", 500, "easeInOutQuad");
		$("#"+id+"d").switchClass( "select", "pasSelect", 500, "easeInOutQuad");
		$("#"+id+"e").switchClass( "select", "pasSelect", 500, "easeInOutQuad");

		$("#forumModeration").animate({ 
	        height: "0px"
	    }, 500 );
	}
}

function sujetSupprimerAll(ele) {
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

         $("#forumModeration").animate({ 
	        height: "105px"
	    }, 500 );
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

        $("#forumModeration").animate({ 
	        height: "0px"
	    }, 500 );
    }
 }

 function replaceTextareaSelection(el, txt, txt2) {
    if(el.selectionStart == undefined) {
        document.selection.createRange().text = "LOL";
    } else { 
        el.value = el.value.substring(0, el.selectionStart) + txt + el.value.substring(el.selectionStart, el.selectionEnd) + txt2 + el.value.substring(el.selectionEnd, el.value.length);
    }
}