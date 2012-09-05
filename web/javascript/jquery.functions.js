$(document).ready(function() {	
	$("ul#nav a").each(function(){
		if( location.href.indexOf(this.href) != -1) {
			$(this).addClass("current");
		}
	});	
	/*$("ul#nav").accordion({navigation:true});*/
	
	$("a.popup").fancybox({
		transitionIn	:	'elastic',
		transitionOut	:	'elastic',
		speedIn			:	600, 
		speedOut		:	200,
		width			:	'70%',
		height			:	'70%',
		maxWidth		: 	600,
		maxHeight		: 	600,
		autoSize		: 	false
	});
	
	$("table#companies").tablesorter( {headers: { 
		3: { 
			sorter: false 
		}, 
		4: { 
			sorter: false 
		} 
	}, widgets: ['zebra']} );
	$("table#projects").tablesorter( {headers: { 
		4: { 
			sorter: false 
		}, 
		5: { 
			sorter: false 
		} 
	}, widgets: ['zebra']} );
	$("table#projectparts").tablesorter( {headers: { 
		2: { 
			sorter: false 
		}, 
		3: { 
			sorter: false 
		} 
	}, widgets: ['zebra']} );
	$("table#time").tablesorter( {headers: { 
		0: { 
			sorter: false 
		}, 
		1: { 
			sorter: false 
		}, 
		2: { 
			sorter: false 
		}, 
		3: { 
			sorter: false 
		}, 
		4: { 
			sorter: false 
		}, 
		5: { 
			sorter: false 
		}, 
		6: { 
			sorter: false 
		} 
	}, widgets: ['zebra']} );
	
	$("form").validate({
		rules: {
			password: {
				required: true,
				minlength: 5
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			password1: {
				required: false
			},
			password2: {
				required: false,
				equalTo: "#password1"
			}
		}
	});
	
	// Remove record
	$("a.del").click(function(e){
		e.preventDefault();
		var delTitle = $(this).attr("rel");	
		if (confirm("Weet u zeker dat u '" + delTitle + "' wilt verwijderen?")) {
            alert("'" + delTitle + "' is succesvol verwijderd.");
        }
	});
	
	// Cancel page
	$("a.cancel").click(function(e){
		e.preventDefault();
		if (confirm("Weet u zeker dat u deze pagina wilt verlaten?")) {
            window.location="home.php";
        }
	});
	
});