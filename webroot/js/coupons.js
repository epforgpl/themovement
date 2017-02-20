$(document).ready(function(){
	
	var div = $('#coupons-generate-new');
	var form = div.find('form');
	
	var sendCheckedFun = function(){
		var checked = div.find('input[name=send]').prop('checked');
		if( checked ) {
			div.find('.sendDiv').addClass('active');
			div.find('input[name=name]').removeClass('disabled').prop('disabled', false);
			div.find('input[name=email]').removeClass('disabled').prop('disabled', false);
			
			div.find('input[name=save]').val('Save and Send');
			div.find('input[name=name]').focus();
			
		} else {
			div.find('.sendDiv').removeClass('active');
			div.find('input[name=name]').addClass('disabled').prop('disabled', true);
			div.find('input[name=email]').addClass('disabled').prop('disabled', true);

			div.find('input[name=save]').val('Save');
		}
	};
	
	var generateCoupon = function(){
		
	    var code = "";
	    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	
	    for( var i=0; i < 5; i++ ) {
	        code += possible.charAt(Math.floor(Math.random() * possible.length));			
		};
		
		div.find('input[name=code]').val(code);
		
	}
	
	var verifyForm = function(){
		
		var errors = [];
		
		if( !div.find('input[name=code]').val() ) {
			errors.push({name: 'code'});
		}
		
		if( div.find('input[name=send]').prop('checked') ) {
			
			if( !div.find('input[name=name]').val() ) {
				errors.push({name: 'name'});
			}
			
			if( !div.find('input[name=email]').val() ) {
				errors.push({name: 'email'});
			}
			
		}
		
		if( errors.length ) {
			
			div.find('input[name=save]').addClass('disabled').prop('disabled', true);
			return false;
			
		} else {
			
			div.find('input[name=save]').removeClass('disabled').prop('disabled', false);
			return true;
			
		}
		
		
	};
	
	var resetForm = function(){
				
		form.find('input[name=code]').val('').prop('readonly', false);
		form.find('input[name=send]').prop('checked', false).prop('disabled', false);
		form.find('input[name=name]').val('');
		form.find('input[name=email]').val('');
		form.find('input[name=save]').addClass('disabled').prop('disabled', true);
		
		form.find('.msgDiv').hide();
		form.find('.btn-coupons-generate-renew').addClass('disabled').prop('disabled', true);
		
		sendCheckedFun();
		generateCoupon();
		verifyForm();
		
	};
	
	var resetFormPost = function(){
				
		var height = form.find('.sendDiv').height();
		form.find('.msgDiv').height(height).css({
			'marginTop': -height-30,
		});
						
	};
	
	var inputKeyUp = function(event){
		verifyForm();
		/*
		if(event.which == 10 || event.which == 13) {
            formSubmit();
        }
        */		
	};
	
	var formSubmit = function(){
		if( verifyForm() ) {
			
			var action = form.attr('action');
			var send = div.find('input[name=send]').prop('checked');
			
			var params = {
				'code': form.find('input[name=code]').val(),
				'event_id': form.find('input[name=event_id]').val(),
			};
			
			if( div.find('input[name=send]').prop('checked') ) {
				params['send'] = true;
				params['name'] = form.find('input[name=name]').val();
				params['email'] = form.find('input[name=email]').val();
			}
			
			form.find('input[name=code]').addClass('disabled').prop('readonly', true);
			form.find('input[name=send]').addClass('disabled').prop('disabled', true);
			form.find('input[name=name]').addClass('disabled').prop('disabled', true);
			form.find('input[name=email]').addClass('disabled').prop('disabled', true);
			form.find('input[name=save]').addClass('disabled').prop('disabled', true);
			
			form.find('.status_code').hide();
			form.find('.status_send').hide();
			
			div.find('.progress').fadeIn({duration: 150});
			
			$.post(action + '.json', params).success(function(){
				form.find('.status_code.success').show();
			}).error(function(xhr, ajaxOptions, thrownError){
				form.find('.status_code.fail').html(thrownError).show();
			}).always(function() {
			    form.find('.btn-coupons-generate-renew').removeClass('disabled').prop('disabled', false);
			    form.find('.msgDiv').fadeIn({
					duration: 150
				});	
				div.find('.progress').fadeOut({duration: 150});	    
			});
			
		}
	};
	
	
	div.find('.btn-coupons-generate-renew').click(function(event){
				
		event.preventDefault();
		resetForm();
		resetFormPost();
		
	});

	div.find('input[name=send]').change(function(){
		sendCheckedFun();	
	});
	
	form.submit(function(event){
		event.preventDefault();
		formSubmit();
		return false;
	});
	
	
	form.find('input[name=code]').change(function(){verifyForm();});
	form.find('input[name=code]').keyup(inputKeyUp);
	form.find('input[name=name]').change(function(){verifyForm();});
	form.find('input[name=name]').keyup(inputKeyUp);
	form.find('input[name=email]').change(function(){verifyForm();});
	form.find('input[name=email]').keyup(inputKeyUp);
	form.find('input[name=send]').change(function(){verifyForm();});
		
	div.on('show.bs.modal', function(event) {
		resetForm();		
	});
	div.on('shown.bs.modal', function(event) {
		resetFormPost();		
	});
		
});