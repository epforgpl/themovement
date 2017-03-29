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
				
		$(window).resize(
            ResponsiveBootstrapToolkit.changed(function() {
	            that.changeView();
            })
        );
        
        this.changeView();
		
		this.div.find('.list-dates a').each(function(){
			
			var a = $(this);
			a.addClass(a.data('date'));
			
		}).on('show.bs.tab', function(event){
			
			var key = 'events.' + that.event_id + '.agenda.selectedDay';
			var val = $(event.target).data('date');
			localStorage.setItem(key, val);
			
		});
		
		var key = 'events.' + that.event_id + '.agenda.selectedDay';
		var val = localStorage.getItem(key);
		
		if( val ) {
			var a = this.div.find('.list-dates a.' + val);
			if( a.length ) {
				a.tab('show');
			}
		}
		
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
							_chr.prop('checked', true);
							session_div.data('subsession_id', val);
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
				session_div.removeData('subsession_id');
			} else {
				localStorage.setItem(key, value);				
				session_div.data('subsession_id', value);
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
				
		var my_agenda = this.agenda_switcher.prop('checked');
		
		this.div.find('.program .session').each(function(){
			
			var session_div = $(this);
			var input = session_div.find('.session_header .ch');
			var inputs = session_div.find('.chr');
			
			if( my_agenda ) {
				
				if( session_div.hasClass('subscribable') ) {
					
					if( input.prop('checked') ) {
						session_div.show();
					} else {
						session_div.hide();
					}
				
				} else {
					
					if( inputs.length ) {
						
						var subsession_id = session_div.data('subsession_id');
						
						if( subsession_id ) {
							
							inputs.each(function(){
								
								var _inp = $(this);
								
								if( _inp.val() == subsession_id ) {
									_inp.parents('.subsession').show();
								} else {
									_inp.parents('.subsession').hide();									
								}
								
							});
							
							session_div.show();
							
						} else {
							session_div.hide();
						}
					
					} else {					
						session_div.show();
					}
					
				}
				
			} else {
				session_div.show().find('.subsession').show();
			}
			
		});
		
	},
	
	changeView: function() {
		
		this.div.removeClass('xs').removeClass('sm').removeClass('md').removeClass('lg').addClass( ResponsiveBootstrapToolkit.current() );
		
        if( ResponsiveBootstrapToolkit.is('<=sm') ) {
	        
	        var list_dates = this.div.find('.filter');
	        
	        list_dates.sticky({
				topSpacing: 0,
				zIndex: 1
			});
			
			this.div.find('.my-agenda-nav').sticky({
				topSpacing: list_dates.height()+15,
				zIndex: 1
			});
	        
        } else {
	        
	        this.div.find('.filter').sticky({
				topSpacing: 0,
				zIndex: 1
			});
			
			this.div.find('.my-agenda-nav').sticky({
				topSpacing: 0,
				zIndex: 1
			});
	        
        }
		
	}
	
}

var _agnd = new _AGENDA();
_agnd.init('#agenda');