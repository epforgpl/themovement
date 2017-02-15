var _profileEditFormVars = {
	'countries': false,
	'professions': false
};

function profileEditFormInitFinish() {
	if(
		_profileEditFormVars['countries'] && 
		_profileEditFormVars['professions']
	) {
		
		$('.btn-profile-edit-submit').removeClass('disabled').prop('disabled', false);
		
	}
}

function profileEditFormInit() {
		
	var div = $('.profile-edit-form');
	if( !div.length )
		return false;
	
	if( div.hasClass('init') )
		return false;
	
	div.addClass('init');
		
	$.get('/countries.json', function(countries){
		var html = '<option value=""></option>';
		for( var i=0; i<countries.length; i++ ) {
			var c = countries[i];
			html = html + '<option value="' + c['iso'] + '">' + c['name'] + '</option>';
		}
		$('#inputCountry').html( html );
		
		var val = $('#inputCountry').data('value');
		if( val ) {
			$('#inputCountry').val(val);
		}
		
		_profileEditFormVars['countries'] = true;
		profileEditFormInitFinish();
		
	});
	
	var val = $('#inputGender').data('value');
	if( val ) {
		$('#inputGender').val(val);
	}
	
	var val = $('#birthdayDiv').data('value');
	if( val ) {
		var parts = val.split('-');
		$('#birthdayDiv .selectYear').val( parts[0] );
		$('#birthdayDiv .selectMonth').val( parts[1] );
		$('#birthdayDiv .selectDay').val( parts[2] );
	}
	
	
	
	
	$.get('/professions.json', function(professions){
				
		var html = '';
		for( var i=0; i<professions.length; i++ ) {
			var p = professions[i];
			html = html + '<div class="col-sm-4"><label><input class="ch" type="checkbox" name="professions[_ids][]" value="' + p['id'] + '" />' + p['name'] + '</label></div>';
		}
		html = html + '<div class="col-sm-4"><label><input name="profession_other" id="checkboxProfessionOther" type="checkbox" value="1" />Other</label></div>';
		$('#professions_div').html( html );
		
		var val = $('#inputOtherProfession').val();
		if( val ) {
			$('#checkboxProfessionOther').prop('checked', true);
		}
		
		$('#checkboxProfessionOther').click(function(){
			if( !$('#checkboxProfessionOther').prop('checked') ) {
				$('#inputOtherProfession').val('');
			}
			$('#otherProfession').toggle();
		});
		
		var val = $('#professions_div').data('value');
		if( val ) {
			for( var i=0; i<val.length; i++ ) {
				
				var v = val[i];
				$('#professions_div input.ch[value=' + v + ']').prop('checked', true);
				
			}
		}
		
		_profileEditFormVars['professions'] = true;
		profileEditFormInitFinish();
		
	});
	
	$('#checkboxOrganization').change(function(event){
		
		if( $('#checkboxOrganization').is(':checked') ) {
			$('#inputOrganizationName').prop('disabled', false).removeClass('disabled');
			$('#inputOrganizationWWW').prop('disabled', false).removeClass('disabled');
			$('#inputOrganizationRole').prop('disabled', false).removeClass('disabled');
		} else {
			$('#inputOrganizationName').prop('disabled', true).addClass('disabled');
			$('#inputOrganizationWWW').prop('disabled', true).addClass('disabled');
			$('#inputOrganizationRole').prop('disabled', true).addClass('disabled');
		}
		
	});
	
}

$(document).ready(function(){
	
	var div = $('.profile-edit-form');
	if( div.length && div.hasClass('autoInit') ) {
		profileEditFormInit();
	} 
	
});