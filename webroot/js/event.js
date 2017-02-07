$(document).ready(function(){
	
	$('#btn-register').click(function(event){
		
		event.preventDefault();
		$('#register-div').slideToggle();
		
	});
	
	$('#btn-register-cancel').click(function(event){
		
		event.preventDefault();
		$('#register-div').slideUp();
		
	});	
	
});