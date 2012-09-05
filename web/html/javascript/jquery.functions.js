$(document).ready(function() {	
	$("ul#nav a").each(function(){
		if( location.href.indexOf(this.href) != -1) {
			$(this).addClass("current");
		}
	});	
	$("ul#nav").accordion({navigation:true});
	
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
	
	// Sum of time
	$("table#time select").change(function(){
		var day1=0,
			day2=0.
			day3=0,
			day4=0,
			day5=0,
			day6=0
			
		$("select.day1").each(function(){
				day1+=parseFloat(this.value);
				$("input#total_1").val(day1);
		});
		$("select.day2").each(function(){
				day2+=parseFloat(this.value);
				$("input#total_2").val(day2);
		});
		$("select.day3").each(function(){
				day3+=parseFloat(this.value);
				$("input#total_3").val(day3);
		});
		$("select.day4").each(function(){
				day4+=parseFloat(this.value);
				$("input#total_4").val(day4);
		});
		$("select.day5").each(function(){
				day5+=parseFloat(this.value);
				$("input#total_5").val(day5);
		});
		$("select.day6").each(function(){
				day6+=parseFloat(this.value);
				$("input#total_6").val(day6);
		});
		
		var sum1=parseFloat($("input#total_1").val()),
			sum2=parseFloat($("input#total_2").val()),
			sum3=parseFloat($("input#total_3").val()),
			sum4=parseFloat($("input#total_4").val()),
			sum5=parseFloat($("input#total_5").val()),
			sum6=parseFloat($("input#total_6").val()),
			sum=sum1+sum2+sum3+sum4+sum5+sum6
		$("input#sum").val(sum);
		if(day1==value || day2==value || day3==value || day4==value || day5==value || day6==value){
			return true;
		}
		return false;
	});
});