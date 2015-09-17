function compteMenu(option) {

	$("#option1").fadeOut("slow",function(){
		$("#option2").fadeOut("slow",function(){
			$("#option3").fadeOut("slow",function(){
				$("#option4").fadeOut("slow",function(){
					/*$("#option5").fadeOut("slow",function(){
						$("#option6").fadeOut("slow",function(){
							$("#option7").fadeOut("slow",function(){*/
								$("#"+option).fadeIn("slow");
								window.history.pushState('page'+option, 'Title', '/compte.php?page='+option);
							/*});
						});
					});*/
				});
			});
		});
	});
}