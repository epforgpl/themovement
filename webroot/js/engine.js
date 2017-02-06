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
				
	}
}

var _page = new _PAGE();
_page.init();