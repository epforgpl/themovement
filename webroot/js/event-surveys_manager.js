var _SURVEYS_MANAGER = function(){};
_SURVEYS_MANAGER.prototype = {
	
	div: null,
	questions_div: null,
	event_id: null,
	
	init: function(div){
		
		var that = this;		
		$(document).ready(function(){
			that.ready(div);
		});
		
	},
	
	ready: function(div){
		
		var that = this;
		this.div = $(div)
		
		this.event_id = this.div.data('event_id');
		this.questions_div = this.div.find('.questions');
		
		this.div.find('.btn-add-question').click(function(event){
			event.preventDefault();
			that.addQuestion();
			that.countQuestions();
		});
		
		var questions = this.div.data('questions');
		var questions_length = questions.length;
		
		if( questions_length ) {
			for( var i=0; i<questions_length; i++ ) {
				this.addQuestion(questions[i]);
			}
		} else {
			this.addQuestion();
		}
		
		this.countQuestions();
		
		this.questions_div.sortable({
			items: '.block-question',
			handle: 'header .toolbar .btn-drag',
			helper: 'clone',
			axis: 'y',
			update: function(event, ui){
				
				var block_question = $(ui.item);
				
				var item_id = block_question.data('id');
				if( item_id ) {
					that.saveQuestion(block_question, {
						'save_orders': true
					});
				}
				
			}
		});
		
		var main_toolbar = this.div.find('.item_header .toolbar');
		main_toolbar.find('.btn-play').click(function(){
			that.togglePlay();
		});
		
		main_toolbar.find('.btn-lock').click(function(){
			that.toggleLock();
		});
				
	},
	
	togglePlay: function(){
	
		if( this.div.data('play') ) {
			this.stop();
		} else {
			this.play();
		}
		
	},
	
	play: function() {
		
		this.div.data('play', true).addClass('play');
		
	},
	
	stop: function() {
		
		this.div.data('play', false).removeClass('play');
		
	},
	
	toggleLock: function(){
	
		if( this.div.data('locked') ) {
			this.unlock();
		} else {
			this.lock();
		}
		
	},
	
	lock: function() {
		
		this.div.data('locked', true).addClass('locked');
		
	},
	
	unlock: function() {
		
		this.div.data('locked', false).removeClass('locked');
		
	},
	
	countQuestions: function(){
		
		var i=0;
		this.questions_div.find('.block-question').each(function(){
			$(this).data('i', i);
			i++;
		});
	
	},
	
	countAnswers: function(question_div){
		
		var i=0;
		question_div.find('.answer').each(function(){
			$(this).data('i', i);
			i++;
		});
	
	},
	
	addQuestion: function(question){
		
		var that = this;
		
		var question_div = $('<div class="block block-question"><div class="presenter_toolbar"><button class="button btn-play"><span class="glyphicon glyphicon-play"></span></button><button class="button btn-lock"><span class="glyphicon glyphicon-lock"></span></button></div><header><div class="toolbar"><p class="button btn-drag"><span class="glyphicon glyphicon-move"></span></p><button class="button btn-remove"><span class="glyphicon glyphicon-remove"></span></button></div><h2 class="placeholder" contentEditable="true">Enter question...</h2></header><div class="block-inner"><ul class="answers"></ul><div class="buttons"><button class="btn-add-answer">Add answer</button></div></div><div class="progress progress-striped active"><div class="progress-bar" style="width: 100%"></div></div></div>').hide();
				
		if( question ) {
			question_div.data('id', question.id).find('h2').data('content', question.text).removeClass('placeholder').text(question.text);
		}
		
		question_div.find('.btn-remove').click(function(event){
			if( confirm('Do you really want to remove this question?') ) {
				that.removeQuestion( $(event.target).closest('.block-question') );
			}
		});
		
		question_div.find('.btn-add-answer').click(function(event){
			that.addAnswer( $(event.target).closest('.block-question') );
		});
		
		question_div.find('.btn-play').click(function(event){
			
			that.setActiveQuestion($(event.target).closest('.block-question'));
			
		});
		
		question_div.find('.btn-lock').click(function(event){
			that.saveQuestion($(event.target).closest('.block-question'), {
				'lock': true
			}, function(question_div){
				
			});
		});
		
		this.makeEditable(question_div.find('h2'), 'Enter question...', function(element){
			that.saveQuestion(element.parents('.block-question'));
		});
				
		this.questions_div.append(question_div);
		question_div.slideDown();
		
		if( question ) {
			
			question_div.data('id', question.id).data('content', question.text).find('h2').removeClass('placeholder').text(question.text);
			
			var answers_length = question['surveys_answers'].length;
			
			if( answers_length ) {
				
				for( var i=0; i<answers_length; i++ ) {
					this.addAnswer(question_div, question['surveys_answers'][i]);
				}
				
			} else {
				this.addAnswer( question_div );
			}
						
		} else {
			this.addAnswer( question_div );
		}
		
		question_div.find('.answers').sortable({
			items: '.answer',
			handle: '.toolbar .btn-drag',
			helper: 'clone',
			axis: 'y',
			update: function(event, ui){
								
				var answer = $(ui.item);
				
				var answer_id = answer.data('id');
				if( answer_id ) {
					that.saveAnswer(answer, {
						'save_orders': true
					});
				}
				
			}
		});
		
	},
	
	setActiveQuestion: function(question_div){
		
		var question_id = question_div.data('id');
		if( question_id ) {
		
			var that = this;
			
			if( question_div.hasClass('play') ) {
				var data = {
					'question_id': null
				};
				question_div.removeClass('play');
			} else {
				var data = {
					'question_id': question_id
				};
				this.questions_div.find('.block-question.play').removeClass('play');
				question_div.addClass('play');
			}
						
			this.lockQuestion(question_div);
			
			$.post('/events/' + this.event_id + '/setActiveQuestion.json', data, function(data){
				
				if( data.message == 'Set' ) {
					that.unlockQuestion(question_div);
				}
				
			});
			
		}
		
	},
	
	removeQuestion: function(question_div){
		
		var question_id = question_div.data('id');
		
		if( question_id ) {
			
			this.lockQuestion(question_div);
			$.post('/surveysquestions/' + question_id + '.json', {
				'_method': 'DELETE'
			}, function(data){
			
				if( data.message == 'Deleted' ) {
					question_div.slideUp();
				}
				
			});
			
		} else {
			
			question_div.slideUp();
			
		}
				
	},
	
	removeAnswer: function(answer_div){
		
		var that = this;
		var question_div = answer_div.parents('.block-question');
		var question_id = question_div.data('id');
		var answer_id = answer_div.data('id');
		
		if( answer_id ) {
			
			this.lockQuestion(question_div);
			$.post('/surveysanswers/' + answer_id + '.json', {
				'_method': 'DELETE'
			}, function(data){
			
				if( data.message == 'Deleted' ) {
					answer_div.slideUp();
				}
				
				that.unlockQuestion(question_div);
				
			});
			
		} else {
			answer_div.slideUp();
		}
				
	},
	
	lockQuestion: function(question_div){
		
		question_div.addClass('locked');
		
	},
	
	unlockQuestion: function(question_div){
		
		question_div.removeClass('locked');
		
	},
	
	addAnswer: function(question_div, answer){
		
		var that = this;
		var answers_ul = question_div.find('.answers');
		
		var answer_li = $('<li class="answer"><div class="toolbar"><p class="button btn-drag"><span class="glyphicon glyphicon-move"></span></p><button class="button btn-remove"><span class="glyphicon glyphicon-remove"></span></button></div><div class="text placeholder" contentEditable="true">Enter answer...</div></li>').hide();
		
		answer_li.find('.btn-remove').click(function(event){
			if( confirm('Do you really want to remove this answer?') ) {
				that.removeAnswer( $(event.target).closest('.answer') );
			}
		});
		
		if( answer )
			answer_li.data('id', answer.id).find('.text').data('content', answer.text).removeClass('placeholder').text(answer.text);
		
		answers_ul.append(answer_li);
		
		this.makeEditable(answer_li.find('.text'), 'Enter answer...', function(element){
			that.saveAnswer(element.parents('.answer'));
		});
		
		answer_li.slideDown();
		
	},
	
	saveQuestion: function(question_div, _options, callback) {
		
		this.lockQuestion(question_div);
		
		if( !_options )
			_options = {};
		
		var options = {
			'save_orders': true,
			'play': false
		};
		
		if( _options.hasOwnProperty('save_orders') )
			options['save_orders'] = _options['save_orders'];
		
		if( _options.hasOwnProperty('play') )
			options['play'] = _options['play'];
		
		this.countQuestions();
		
		var that = this;
		var content = question_div.find('h2').data('content');
		
		var data = {
			'event_id': this.event_id,
			'ord': question_div.data('i'),
			'text': content
		};
		
		var question_id = question_div.data('id');
		
		if( options['save_orders'] ) {
			
			var orders = {};
			
			var i=0;
			this.questions_div.find('.block-question').each(function(){
				var block_question = $(this);
				var _question_id = block_question.data('id');
				if( 
					_question_id && 
					( question_id != _question_id )
				) {
					orders[ _question_id ] = block_question.data('i');
				}
			});
			
			data['orders'] = orders;
			
		}
		
		if( question_id ) {
			var url = '/surveysquestions/' + question_id;
			data['_method'] = 'PUT';
		} else {
			var url = '/surveysquestions';
		}
				
		$.post(url + '.json', data, function(data){
			
			if( data.message == 'Saved' ) {
				question_div.data('id', data.question.id);
				that.unlockQuestion(question_div);
				
				if( callback )
					callback(question_div);
				
			}
			
		});
		
	},
	
	saveAnswer: function(answer_div, _options) {
		
		var that = this;
		var question_div = $(answer_div).parents('.block-question');
		var question_id = question_div.data('id');
		
		if( question_id ) {
			this.saveAnswerFinish(question_div, answer_div, _options);
		} else {
			this.saveQuestion(question_div, {}, function(){
				that.saveAnswerFinish(question_div, answer_div, _options);
			});
		}
		
	},
	
	saveAnswerFinish: function(question_div, answer_div, _options) {
		
		this.lockQuestion(question_div);
		
		if( !_options )
			_options = {};
		
		var options = {
			'save_orders': true,
		};
		
		if( _options.hasOwnProperty('save_orders') )
			options['save_orders'] = _options['save_orders']
				
		this.countAnswers(question_div);
		
		var that = this;
		var content = answer_div.find('.text').data('content');
				
		var data = {
			'question_id': question_div.data('id'),
			'ord': answer_div.data('i'),
			'text': content
		};
		
		var answer_id = answer_div.data('id');
		
		if( options['save_orders'] ) {
			
			var orders = {};
			
			var i=0;
			question_div.find('.answer').each(function(){
				var answer = $(this);
				var _answer_id = answer.data('id');
				if( 
					_answer_id && 
					( answer_id != _answer_id )
				) {
					orders[ _answer_id ] = answer.data('i');
				}
			});
			
			data['orders'] = orders;
			
		}
		
		if( answer_id ) {
			var url = '/surveysanswers/' + answer_id;
			data['_method'] = 'PUT';
		} else {
			var url = '/surveysanswers';
		}
				
		$.post(url + '.json', data, function(data){
			
			if( data.message == 'Saved' ) {
				answer_div.data('id', data.answer.id);
				that.unlockQuestion(question_div);
			}
			
		});
		
	},
	
	makeEditable: function(element, placeholder, callback){
		
		var element = $(element).addClass('editable');
		
		element.focus(function(){
			element.removeClass('placeholder').addClass('editing');
			if( !element.data('content') )
				element.text('');
			element.data('content', element.text());
		});
		
		element.blur(function(){
						
			element.removeClass('editing');
			var content = element.text().trim();
			var _content = element.data('content');
			
			if( !content )
				element.text(placeholder).addClass('placeholder');
			
			element.data('content', content);
			
			if( content != _content ) {
				callback(element, content);
			}
						
		});
		
		element.keydown(function(e){
			if( 
				( e.which == 13 ) && 
				( !e.shiftKey )
			) {
				element.blur();
			}
		});
		
	}
	
}

var _sm = new _SURVEYS_MANAGER();
_sm.init('#surveys_manager');