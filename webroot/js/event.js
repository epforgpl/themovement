function checkCoupon() {
	
	var input = $('#inputCoupon');
	var btn = $('#btnCoupon');
	var v = input.val();
	
	if( v ) {
		
		input.attr("disabled", true);
		btn.attr("disabled", true);
		$('#register-div .msg-coupon').hide();
		var event_id = $('#inputEventId').val();
		
		$.get('/coupons/check.json?code=' + v + '&event_id=' + event_id, function(res){
			
			if( res === true ) {
				$('#register-div .banner.without-coupon').hide();
				$('#register-div .banner.with-coupon').show();
				$('#register-div .msg-coupon.valid').show();
				$('#btn-submit-pay').text('Submit');
			} else {
				$('#register-div .banner.with-coupon').hide();
				$('#register-div .banner.without-coupon').show();
				$('#register-div .msg-coupon.invalid').show();
				$('#btn-submit-pay').text('Submit and pay');
			}
			
		});
		
		input.attr("disabled", false);
		btn.attr("disabled", false);
	
	}
}

$(document).ready(function(){
	
	// REGISTERING
	
	$('#btn-register').click(function(event){
		
		event.preventDefault();
		
		if( $('#register-div').is(':visible') ) {
			
			$('#register-div').slideUp();
			History.pushState({state:1}, null, "?");
			
		} else {
			
			$('#register-div').slideDown();
			History.pushState({state:1}, null, "?register");
			profileEditFormInit();
			
		}		
		
	});
	
	$('#btn-register-cancel').click(function(event){
		
		event.preventDefault();
		History.pushState({state:1}, null, "?")
		$('#register-div').slideUp();
		
		if( $('#register-user-div').length ) {
			$('#register-user-div').slideDown();
		}
		
	});
	
	$('#inputCoupon').keypress(function(event){
		if( event.which == 13 ) {
			event.preventDefault();
			checkCoupon();
		}
	});
	
	$('#btnCoupon').click(function(event){
		event.preventDefault();
		checkCoupon();
	});
	
	$('#btn-register-modify').click(function(event){
		event.preventDefault();
		$('#register-user-div').slideUp();
		$('#register-div').slideDown();		
	});
	
	$('#form-cancel-registration').submit(function(event){
		if( !confirm('Do you really want to cancel your registration?') ) {
			event.preventDefault();
		}
	});
	
});