var _PAGE = function(){};
_PAGE.prototype = {
	
	window: false,
	header_main: false,
	body_main: false,
	footer_main: false,
	last_window_width: false,
	last_window_height: false,
	
	init: function(){
		
		var that = this;
		$(document).ready(function(){
			that.ready();
		});
	
	},
	ready: function(){
		
		this.window = $(window);
		this.header_main = $('#header-main');
		this.body_main = $('#body-main');
		this.footer_main = $('#footer-main');
		var that = this;
		
		this.window.resize(function(){
			that.resize();
		});
		
		this.resize();
		this.armButtons();
		
	},
	resize: function(){
				
		if( this.body_main.length ) {
		
			var width = this.window.width();
			var height = this.window.height();
			
			if( 
				( width != this.last_window_width ) || 
				( height != this.last_window_height )
			) {
				
				var min_height = height - this.header_main.height() - this.footer_main.height() - 40;
				
				this.body_main.css({
					'min-height': min_height
				});
				
				this.last_window_height = height;
				
			}
		
		}
				
	},
	armButtons: function(){
		
		$('.login-required').click(function(event){
			
			event.preventDefault();
			var btn = $(event.target).closest('.login-required');
			var msg = btn.data('msg');
			var data_next = btn.data('next');
									
			var modal = $('<div class="modal fade modal-plan"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title text-center">Please log in to continue</h4></div><div class="modal-body"></div><div class="modal-footer text-center"><button type="button" class="btn btn-default btn-sm btn-sm-fixed-width" data-dismiss="modal">Close</button></div></div></div></div>');
			
			modal.find('.modal-body').html( $('#_login_template').html() );
			
			if( msg ) {
				modal.find('.modal-header h4').remove();
				modal.find('.modal-body .msg').html('<div class="well well-sm">' + msg + '</div>');
			}
			
			var next = data_next ? data_next : modal.find('.modal-body .inputNext').val();			
			if( next ) {
				
				modal.find('.modal-body .inputNext').val(next);
				
				var fb_btn = modal.find('.modal-body .btn-facebook');
				var href = fb_btn.attr('href') + '?next=' + encodeURIComponent(next);
				fb_btn.attr('href', href);
				
				var register_btn = modal.find('.modal-body .btn-show-register');
				var href = '/join?register=1&next=' + encodeURIComponent(next);
				register_btn.attr('href', href);
								
			}
			
			modal.find('.modal-body .block-login').show();
			$('body').prepend(modal);

			modal.modal('show').on('hidden.bs.modal', function(){
				modal.remove();
			});
			
		});
		
	}
}

var _page = new _PAGE();
_page.init();