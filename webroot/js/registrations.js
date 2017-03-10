$(document).ready(function(){
	
	var div = $('#registration-finish');
	var form = div.find('form');
	
	$('.registrationsTable .item-status:not(.item-status-finalized)').click(function(event){
		
		event.preventDefault();
		var item_status = $(event.target).closest('.item-status');
				
		if( item_status.hasClass('item-status-finalized') )
			return false;
		
		var row = item_status.parents('.row');		
		var item = row.data('item');
		
		form.find('.msgDiv').hide();
		form.find('input[name=send]').removeClass('disabled').prop('disabled', false);
		form.find('input[name=save]').removeClass('disabled').prop('disabled', false);
		
		form.find('input[name=registration_id]').val( item.id );
		form.find('input[name=send]').prop('checked', true);
		
		var info = div.find('.info');
		info.find('.name').html( item.user.name );
		info.find('.organization').html( item.user.organization_name );
				
		div.modal('show');
		
	});
	
	form.submit(function(event){
		event.preventDefault();
		
		var action = form.attr('action');
		var id = form.find('input[name=registration_id]').val();
		
		var params = {
			'id': id,
			'send': form.find('input[name=send]').prop('checked')
		};
		
		form.find('input[name=send]').addClass('disabled').prop('disabled', true);
		form.find('input[name=save]').addClass('disabled').prop('disabled', true);
		
		form.find('.status_code').hide();
		form.find('.status_send').hide();
		
		div.find('.progress').fadeIn({duration: 150});
		
		$.post(action + '.json', params).success(function(){
			
			form.find('.status_code.success').show();			
			$('.registrationsTable > .row[data-id=' + id + '] .item-status').addClass('item-status-finalized');
			
		}).error(function(xhr, ajaxOptions, thrownError){
			form.find('.status_code.fail').html(thrownError).show();
		}).always(function() {
		    form.find('.msgDiv').fadeIn({
				duration: 150
			});	
			div.find('.progress').fadeOut({duration: 150});	    
		});
		
		return false;
	});
	
});