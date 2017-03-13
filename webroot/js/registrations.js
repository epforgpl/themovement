$(document).ready(function(){
	
	var finish_div = $('#registration-finish');
	var finish_form = finish_div.find('form');
	
	var finishRegistration = function(row){
		
		row = $(row);
				
		var item = row.data('item');
		var item_status = row.find('.item-status');
				
		if( item_status.hasClass('item-status-finalized') )
			return false;
				
		finish_form.find('.msgDiv').hide();
		finish_form.find('input[name=send]').removeClass('disabled').prop('disabled', false);
		finish_form.find('input[name=save]').removeClass('disabled').prop('disabled', false);
		
		finish_form.find('input[name=registration_id]').val( item.id );
		finish_form.find('input[name=send]').prop('checked', true);
		
		var info = finish_div.find('.info');
		info.find('.name').html( item.user.name );
		info.find('.organization').html( item.user.organization_name );
				
		finish_div.modal('show');
		
	};
	
	finish_form.submit(function(event){
		event.preventDefault();
		
		var action = finish_form.attr('action');
		var id = finish_form.find('input[name=registration_id]').val();
		
		var params = {
			'id': id,
			'send': finish_form.find('input[name=send]').prop('checked')
		};
		
		finish_form.find('input[name=send]').addClass('disabled').prop('disabled', true);
		finish_form.find('input[name=save]').addClass('disabled').prop('disabled', true);
		
		finish_form.find('.status_code').hide();
		finish_form.find('.status_send').hide();
		
		finish_div.find('.progress').fadeIn({duration: 150});
		
		$.post(action + '.json', params).success(function(){
			
			finish_form.find('.status_code.success').show();			
			$('.registrationsTable > .row[data-id=' + id + '] .item-status').addClass('item-status-finalized');
			
		}).error(function(xhr, ajaxOptions, thrownError){
			finish_form.find('.status_code.fail').html(thrownError).show();
		}).always(function() {
		    finish_form.find('.msgDiv').fadeIn({
				duration: 150
			});	
			finish_div.find('.progress').fadeOut({duration: 150});	    
		});
		
		return false;
	});
	
	
	
	
	var ask_div = $('#registration-ask');
	var ask_form = ask_div.find('form');
	
	var askRegistration = function(row){
		
		row = $(row);
				
		var item = row.data('item');
		var item_status = row.find('.item-status');
				
		if( item_status.hasClass('item-status-asked') )
			return false;
				
		ask_form.find('.msgDiv').hide();
		ask_form.find('input[name=save]').removeClass('disabled').prop('disabled', false);
		
		ask_form.find('input[name=registration_id]').val( item.id );
		
		var info = ask_div.find('.info');
		info.find('.name').html( item.user.name );
		info.find('.organization').html( item.user.organization_name );
				
		ask_div.modal('show');
		
	};
	
	ask_form.submit(function(event){
		event.preventDefault();
		
		var action = ask_form.attr('action');
		var id = ask_form.find('input[name=registration_id]').val();
		
		var params = {
			'id': id,
		};
		
		ask_form.find('input[name=save]').addClass('disabled').prop('disabled', true);
		
		ask_form.find('.status_code').hide();
		
		ask_form.find('.progress').fadeIn({duration: 150});
		
		$.post(action + '.json', params).success(function(){
			
			ask_form.find('.status_code.success').show();			
			$('.registrationsTable > .row[data-id=' + id + '] .item-status').addClass('item-status-asked');
			
		}).error(function(xhr, ajaxOptions, thrownError){
			ask_form.find('.status_code.fail').html(thrownError).show();
		}).always(function() {
		    ask_form.find('.msgDiv').fadeIn({
				duration: 150
			});	
			ask_form.find('.progress').fadeOut({duration: 150});	    
		});
		
		return false;
	});
	
	
	
	
	
	
	$('.registrationsTable > .row .dropdown').on('show.bs.dropdown', function(event){
				
		var dropdown = $(event.target).closest('.dropdown');
		var row = dropdown.closest('.row');
		var item = row.data('item');
		var menu = dropdown.find('.dropdown-menu');
		menu.html('');
		
		
		// FINISH REGISTRATION
		
		if( item.status != 1 ) {
			var option = $('<li><a href="#">Finish</a></li>');
			option.find('a').click(function(event){
				event.preventDefault();
				finishRegistration( row );
			});
			menu.append(option);
		}
		
		
		
		// ASK FOR REGISTRATION
		
		if( item.status == 0 ) {
			var option = $('<li><a href="#">Ask</a></li>');
			option.find('a').click(function(event){
				event.preventDefault();
				askRegistration( row );
			});
			menu.append(option);
		}
		
	});
	
	
});