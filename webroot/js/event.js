$(document).ready(function(){
	
	// REGISTERING
	
	$('#btn-register').click(function(event){
		
		event.preventDefault();
		$('#register-div').slideToggle();
		
	});
	
	$('#btn-register-cancel').click(function(event){
		
		event.preventDefault();
		$('#register-div').slideUp();
		
	});
		
	
	
	// UPLODADING IMAGES
	
	$('.block-col-img').data('old_style', $('.block-col-img').css('background-image'));
	$('#btn-img-cancel').click(function(){
		$('.block-col-img').data('id', null).css({
			'background-image': $('.block-col-img').data('old_style')
		});
		$('#btn-img-cancel').hide();
		$('#btn-img-save').hide();
	});
	
	$('#btn-img-save').click(function(){
		
		var id = $('.block-col-img').data('id');
		if( id ) {
			
			$.ajax({
				url: '/events/image_save.json',
				type: 'POST',
				data: {
					event_id: $('.block-item-header').data('id'),
					id: id
				},
				success: function(data) {
									
					$('#btn-img-cancel').hide();
					$('#btn-img-save').hide();
					
				}
			});
			
		}
		
	});
	
	$('#btn-img-upload').click(function(event){
		event.preventDefault();
		$('#form-img-upload .file').click();
	});
		
	$('#form-img-upload .file').change(function(event){
		
		var form = $('#form-img-upload');
		var form_data = new FormData( form[0] );
		
		$.ajax({
			url: form.attr('action') + '.json',
			type: 'POST',
			data: form_data,
			async: false,
			contentType: false,
			cache: false,
			processData: false,
			success: function(data) {
								
				if( data['code']==200 ) {
										
					$('.block-col-img').data('id', data['id']).css({
						'background-image': 'url("/temp/' + data['id'] + '-block.jpg")'
					});
					
					$('#btn-img-cancel').show();
					$('#btn-img-save').show();
					
				} else {
					
					alert( data['msg'] );
					
				}
				
			}
		});
		
	});
	
});