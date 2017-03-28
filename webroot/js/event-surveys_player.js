var _SURVEYS_PLAYER = function(){};
_SURVEYS_PLAYER.prototype = {
	
	div: null,
	block: null,
	event_id: null,
	timeout_init: 3000,
	timeout: null,
	
	current_question: null,
	current_answer: null,
	
	init: function(div){
		
		var that = this;
		this.timeout = this.timeout_init;
				
		$(document).ready(function(){
			that.ready(div);
		});
		
	},
	
	ready: function(div){
		
		var that = this;
		this.div = $(div);
		this.block = this.div.find('.block');
		this.event_id = this.div.data('event_id');
		
		this.checkQuestion();
				
	},
	
	checkQuestion: function(){
		
		var that = this;
		
		$.get('/events/' + this.event_id + '/getActiveQuestion.json').always(function(data){
			
			that.block.removeClass('loading');
			
			if( data && data.id ) {
				
				if( that.current_question && ( that.current_question.id != data.id ) ) {
					that.current_answer = null;
				}
				
				that.block.removeClass('empty');
				that.block.find('h2').html( data.text );
				
				var answers_ul = that.block.find('.answers').html('');
				
				for( var i=0; i<data.surveys_answers.length; i++ ) {
					
					var ans = data.surveys_answers[i];
					var li = $('<li><label><input type="radio" name="ans" value="' + ans.id + '" />' + ans.text + '</label></li>');
					
					var inp = li.find('input');
					
					inp.change(function(event){
						var _inp = $(event.target).closest('input');
						that.current_answer = _inp.val();
					});
					
					if( that.current_answer && ( that.current_answer == ans.id ) ) {
						inp.prop('checked', true);
					}
					
					answers_ul.append(li);
					
				}
				
				current_question = data;
				
			} else {
				
				that.block.addClass('empty');
				
			}
			
			setTimeout(function(){
				that.checkQuestion();
			}, that.timeout);
			
		});
		
	}
	
}

var _sp = new _SURVEYS_PLAYER();
_sp.init('#surveys_player');