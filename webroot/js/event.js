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
			
			var btn = $('#btn-submit-pay');
			
			if( res === true ) {
				$('#register-div .banner.without-coupon').hide();
				$('#register-div .banner.with-coupon').show();
				$('#register-div .msg-coupon.valid').show();
				btn.text('Submit');
				
			} else {
				$('#register-div .banner.with-coupon').hide();
				$('#register-div .banner.without-coupon').show();
				$('#register-div .msg-coupon.invalid').show();
				btn.text('Submit and pay');
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
			if( typeof(profileEditFormInit) == 'function' ) {
				profileEditFormInit();
			}
			
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
		profileEditFormInit();
		$('#register-user-div').slideUp();
		$('#register-div').slideDown();		
	});
	
	$('#form-cancel-registration').submit(function(event){
		if( !confirm('Do you really want to cancel your registration?') ) {
			event.preventDefault();
		}
	});
	
});





var _EP = function(){};
_EP.prototype = {
	
	modal: false,
	
	init: function(){
		
		var that = this;
		$(document).ready(function(){
			that.ready();
		});
	
	},
	ready: function(){
		
		var that = this;
		this.modal = $('#eventPublisherModal');
		
		if( typeof(_eventPublisherStart)!='undefined' ) {
			this.start();
		}
		
		$('.event-publisher-btn-share').click(function(event){
			event.preventDefault();
			that.start();
		});
	
		
	},
	start: function(){
		
		var that = this;
		
		this.modal.on('shown.bs.modal', function() {
			var height = Math.round( that.modal.find('.previewImg').width() * 788 / 940 );
			that.modal.find('.previewImg').height(height);
		});
		
		this.modal.modal('show');
		
		
		this.modal.find('.btn-upload').click(function(event){
			event.preventDefault();
			that.modal.find('.uploadForm .inputFile').click();
		});
			
		this.modal.find('.uploadForm .inputFile').change(function(event){
			
	
			var form = that.modal.find('.uploadForm');
			var form_data = new FormData( form[0] );
			
			$.ajax({
				url: form.attr('action') + '.json?filter=pdfcee17',
				type: 'POST',
				data: form_data,
				async: false,
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
							
					if( data['code']==200 ) {
						
						that.modal.find('.previewImg').data('id', data['id']).css({
							'background-image': 'url("/temp/' + data['id'] + '-block.jpg")'
						});
						
						that.modal.find('.btn-download').attr('href', '/images/' + data['id'] + '/download').show();
						
						/*
						$('#btn-img-cancel').show();
						$('#btn-img-save').show();
						*/
						
					} else {
						
						alert( data['msg'] );
						
					}
					
				}
			});
			
		});
		
	}
}
var _ep = new _EP();
_ep.init();