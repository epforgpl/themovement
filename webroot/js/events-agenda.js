var _AGENDA = function(){};
_AGENDA.prototype = {
	
	div: false,
	event_id: false,
	agenda_switcher: false,
	
	init: function(div) {
		
		var that = this;
		$(document).ready(function(){
			that.ready(div);
		});
		
	},
	
	ready: function(div) {
		
		var that = this;
		this.div = $(div);
		this.agenda_switcher = this.div.find('.ch_agenda');
		this.event_id = this.div.data('event_id');
		
		this.div.find('.program .session').each(function(){
						
			var session_div = $(this);
			var session_id = session_div.data('id');
			var session_header = session_div.find('.session_header');
			var input = session_header.find('.ch');
			
			session_header.click(function(event){
				
				var _target = $(event.target);
				if( !_target.hasClass('ch') ) {
				
					var _session_header = _target.closest('.session_header');
					var _input = _session_header.find('.ch');
					
					_input.prop('checked', !_input.prop('checked'));
					
					that.checkProgram(session_div);
				
				}
				
			});
			
			input.prop('checked', false).change(function(event){
				that.checkProgram( $(event.target).closest('.session') );
			});
			
			session_div.find('.chr').prop('checked', false).change(function(event){
				
				var chr = $(event.target).closest('.chr');
				if( chr.prop('checked') ) {
					
					chr.parents('.subsessions').find('.chr').each(function(){
						var _chr = $(this);
												
						if( _chr.val()!=chr.val() ) {
							_chr.prop('checked', false);
						}
					});
					
				}
				
				that.checkProgram( $(event.target).closest('.session') );
				
			});
			
			var key = that.getLocalStorageKey(session_id);
			var val = localStorage.getItem(key);
						
			if( val ) {
				
				var chrs = session_div.find('.chr');
			
				if( chrs.length ) {
					
					chrs.each(function(){
						var _chr = $(this);
												
						if( _chr.val() == val ) {
							console.log('match', _chr);
							_chr.prop('checked', true);
						}
					});
					
				} else {
					input.prop('checked', true);
				}
				
			}
							
		});
		
		this.agenda_switcher.prop('checked', false).change(function(){
			localStorage.setItem('events.' + that.event_id + '.agenda.my_agenda', that.agenda_switcher.prop('checked'));
			that.updateView();
		});
		
		var status = localStorage.getItem('events.' + this.event_id + '.agenda.my_agenda');
		if( status==='false' )
			status = false;
				
		if( status ) {
						
			this.agenda_switcher.prop('checked', true);
			this.updateView();
			
		}
		
	},
	
	checkProgram: function(session_div) {
				
		var session_id = session_div.data('id');
		var key = this.getLocalStorageKey(session_id);
		var chrs = session_div.find('.chr');		
		
		if( chrs.length ) {
			
			var value = false;
			
			chrs.each(function(){
				var chr = $(this);
				if( chr.prop('checked') )
					value = chr.val();
			});
			
			if( value===false ) {
				localStorage.removeItem(key);
			} else {
				localStorage.setItem(key, value);				
			}
						
		} else {
				
			var input = session_div.find('.ch');
					
			if( input.prop('checked') ) {
				localStorage.setItem(key, true);
			} else {
				localStorage.removeItem(key);
			}
		
		}
		
		this.updateView();
				
	},
	
	getLocalStorageKey: function(session_id) {
		return 'events.' + this.event_id + '.agenda.sessions.' + session_id;
	},
	
	updateView: function() {
		
		console.log('updateView');
		
		var my_agenda = this.agenda_switcher.prop('checked');
		
		this.div.find('.program .session').each(function(){
			
			var session_div = $(this);
			var input = session_div.find('.session_header .ch');
			
			if( my_agenda && session_div.hasClass('subscribable') ) {
				
				if( input.prop('checked') ) {
					
					session_div.show();
					
				} else {
					
					session_div.hide();
					
				}
				
			} else {
				
				session_div.show();
				
			}
			
		});
		
	}
	
}

var _agnd = new _AGENDA();
_agnd.init('#agenda');