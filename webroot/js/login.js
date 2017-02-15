$(document).ready(function(){
	
	$('#btn-show-register').click(function(event){
		event.preventDefault();
		$('#login-email').slideUp();
		$('#register-email').slideDown();
	});
	
	$('#btn-show-login').click(function(event){
		event.preventDefault();
		$('#register-email').slideUp();
		$('#login-email').slideDown();
	});
	
});