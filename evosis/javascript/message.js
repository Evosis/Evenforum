function gerer(msg) {

	if($("#"+msg).css("marginLeft")=='230px')
	{
		$("#"+msg).animate({ 
	        paddingLeft: "20px",
	        paddingRight: "20px",
	        marginLeft: "0px",
	    	width: "190px"
	    }, 1000 );
	}
	else
	{
		$("#"+msg).animate({ 
	        paddingLeft: "0px",
	        paddingRight: "0px",
	        marginLeft: "230px",
	    	width: "0px"
	    }, 1000 );
	}
}