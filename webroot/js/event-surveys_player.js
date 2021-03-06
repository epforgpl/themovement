var _SURVEYS_PLAYER = function(){};
_SURVEYS_PLAYER.prototype = {
	
	div: null,
	block: null,
	event_id: null,
	timeout_init: 3000,
	timeout: null,
	
	current_question: null,
	current_answer: null,
	current_other: null,
	
	other_block: false,
	
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
		this.action = this.div.data('action');
		this.block = this.div.find('.block');
		this.status = this.div.find('.status');
		this.event_id = this.div.data('event_id');
		this.vote_button = this.div.find('.btn-vote').removeClass('disable').prop('disabled', null);
		this.progress = this.div.find('.progress');
		
		this.vote_button.click(function(){
			that.save();
		});
		
		this.checkQuestion();
				
	},
	
	checkQuestion: function(){
		
		var that = this;
		
		if( !this.other_block ) {
					
			$.get('/events/' + this.event_id + '/getActiveQuestion.json').always(function(data){
				
				that.block.removeClass('loading');
				
				if( data && data.id ) {
					
					if( that.current_question && ( that.current_question.id != data.id ) ) {
						that.current_answer = null;
					}
					
					that.block.data('id', data.id);
					that.block.removeClass('empty');
					that.block.find('h2').html( data.text );
					
					var answers_ul = that.block.find('.answers').html('');
					
					for( var i=0; i<data.surveys_answers.length; i++ ) {
						
						var ans = data.surveys_answers[i];
						var li = $('<li><label><input type="radio" name="ans" value="' + ans.id + '" />' + ans.text + '</label></li>');
						
						var inp = li.find('input').prop('checked', false);
						
						if( data.result ) {
							
							inp.addClass('disabled').prop('disabled', 'disabled');
							
							if( data.result.answer_id == ans.id ) {
								inp.prop('checked', true);
							}
							
						}
						
						inp.change(function(event){
							var _inp = $(event.target).closest('input');
							that.current_answer = _inp.val();
						});
						
						if( that.current_answer && ( that.current_answer == ans.id ) ) {
							inp.prop('checked', true);
						}
						
						answers_ul.append(li);
						
					}
					
					if( data.others ) {
						
						var li = $('<li><input type="text" class="form-control inp-other" style="width: 90%;" name="other" placeholder="Other..." /></li>');
						
						var inp = li.find('input');
						
						inp.focus(function(event){
							
							that.other_block = true;
							
							that.block.find('input[type=radio]').each(function(){
								$(this).prop('checked', false);
							});
							that.current_answer = false;
							
						}).blur(function(event){
							
							that.current_other = $(event.target).closest('input').val();
							that.other_block = false;
							
						});
						
						
						if( that.current_other )
							inp.val(that.current_other);
						
						
						
						answers_ul.append(li);
	
						
					}
					
					if( data.result ) {
						that.vote_button.addClass('disable').prop('disabled', 'disabled');
						that.status.show();
					} else {
						that.vote_button.removeClass('disable').prop('disabled', false);
						that.status.hide();
					}
					
					current_question = data;
					
				} else {
					
					that.block.addClass('empty');
					
				}
				
				
				
			});
		
		}
		
		setTimeout(function(){
			that.checkQuestion();
		}, that.timeout);
		
	},
	
	save: function() {
		
		var that = this;
		
		var answer = false;
		var answer_other = false;
		this.div.find('.answers input').each(function(){
			var inp = $(this);
			if( inp.prop('checked') ) {
				answer = inp.val();
			}
		});
		
		answer_other = this.div.find('.answers .inp-other').val();
		
		console.log('save', answer, answer_other);
		
		if( (answer !== false) || answer_other ) {
			
			if( !answer )
				answer = 0;
			
			this.vote_button.addClass('disable').prop('disabled', 'disabled');
			this.div.find('.answers input').addClass('disable').prop('disabled', 'disabled');
			this.progress.css({visibility: 'visible'});
			
						
			$.post(this.action + '.json', {
				question_id: that.block.data('id'),
				answer_id: answer,
				other: answer_other,
			}, function(data){
				
				that.status.slideDown();
				that.progress.css({visibility: 'hidden'});
				
			});
		
		}
		
	}
	
}

var _sp = new _SURVEYS_PLAYER();
_sp.init('#surveys_player');