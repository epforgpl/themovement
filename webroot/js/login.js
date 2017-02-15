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
	
	var val = $('#registerBirthdayDiv .selectYear').data('value');
	$('#registerBirthdayDiv .selectYear').val( val );
	
	var val = $('#registerBirthdayDiv .selectMonth').data('value');
	$('#registerBirthdayDiv .selectMonth').val( val );
	
	var val = $('#registerBirthdayDiv .selectDay').data('value');
	$('#registerBirthdayDiv .selectDay').val( val );
	
	var val = $('#registerGenderDiv').data('value');
	$('#registerGenderDiv input[value=' + val + ']').prop('checked', true);
	
});