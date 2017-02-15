<?
	echo $this->Less->less('less/profile-edit.less');
	$this->prepend('script', $this->Html->script('profile-edit'));

	$disableBasicFields = isset($disableBasicFields) ? (boolean) $disableBasicFields : false;
	$autoInit = isset($autoInit) ? (boolean) $autoInit : false;	
?>
<div class="profile-edit-form<? if($autoInit) {?> autoInit<? } ?>">

	<p class="well well-sm visibility-info">The information below will be publicly available.</p>
	
	<div class="row">
		<div class="col-md-4">
			
			<fieldset>
				<div class="form-group row">
					<label for="inputFirstName" class="col-md-12 control-label">First Name</label>
					<div class="col-md-12">
						<?
							$params = ['class' => 'form-control', 'id' => 'inputFirstName', 'placeholder' => 'First Name', 'value' => isset($user) ? $user->first_name : false];
							if( $disableBasicFields )
								$params['disabled'] = true;
							echo $this->Form->text('first_name', $params);
						?>
					</div>
				</div>
			</fieldset>
			
		</div><div class="col-md-4">
		
			<fieldset>
				<div class="form-group row">
					<label for="inputLastName" class="col-md-12 control-label">Last Name</label>
					<div class="col-md-12">
						<?
							$params = ['class' => 'form-control', 'id' => 'inputLastName', 'placeholder' => 'Last Name', 'value' => isset($user) ? $user->last_name : false];
							if( $disableBasicFields )
								$params['disabled'] = true;
							echo $this->Form->text('last_name', $params);
						?>
					</div>
				</div>
			</fieldset>
			
		</div><div class="col-md-4">
			
			<fieldset>
				<div class="form-group row">
					<label for="inputCountry" class="col-md-12 control-label">Country</label>
					<div class="col-md-12">
						<select class="form-control" id="inputCountry" name="country" data-value="<?= isset($user) ? $user->country : '' ?>"></select>
					</div>
				</div>
			</fieldset>
			
		</div>
	</div>
		
	<div class="row">
		<div class="col-md-12">
			<div class="checkbox"><label><?= $this->Form->checkbox('organization', ['value' => 1, 'hiddenField' => false, 'id' => 'checkboxOrganization', 'checked' => ( isset($user) ? $user->organization : true )]) ?> I'm affiliated with:</label></div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			
			<fieldset>
				<div class="form-group row">
					<label for="inputOrganizationName" class="col-md-12 control-label">Organization name</label>
					<div class="col-md-12">
						<?= $this->Form->text('organization_name', ['class' => 'form-control', 'id' => 'inputOrganizationName', 'placeholder' => 'Organization name', 'value' => isset($user) ? $user->organization_name : false]); ?>
					</div>
				</div>
			</fieldset>
			
			
		
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-md-6">
			
			<fieldset>
				<div class="form-group row">
					<label for="inputOrganizationWWW" class="col-md-12 control-label">Organization website address</label>
					<div class="col-md-12">
						<?= $this->Form->text('organization_www', ['class' => 'form-control', 'id' => 'inputOrganizationWWW', 'placeholder' => 'Organization website address', 'value' => isset($user) ? $user->organization_www : false]); ?>
					</div>
				</div>
			</fieldset>
			
		</div>

		<div class="col-md-6">
			
			<fieldset>
				<div class="form-group row">
					<label for="inputOrganizationRole" class="col-md-12 control-label">Role in organization</label>
					<div class="col-md-12">
						<?= $this->Form->text('organization_role', ['class' => 'form-control', 'id' => 'inputOrganizationRole', 'placeholder' => 'Role in organization', 'value' => isset($user) ? $user->organization_role : false]); ?>
					</div>
				</div>
			</fieldset>
			
		</div><div class="col-md-6">			
			
			
			
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<fieldset>
				<div class="form-group row">
					<label for="textAreaAbout" class="col-md-12 control-label">Profession</label>
					<div class="col-md-12">
						<?
							$ids = [];
							if( isset($user) && isset($user->professions) ) {
								foreach( $user->professions as $p ) {
									$ids[] = $p->id;
								}
							}
						?>
						<div class="row" id="professions_div" data-value="<?= json_encode($ids) ?>"></div>
					</div>
				</div>
				<div class="form-group row" id="otherProfession"<? if( !(isset($user) && $user->other_profession) ) {?> style="display: none;"<? } ?>>
					<label for="inputOtherProfession" class="col-md-12 control-label">Other Profession</label>
					<div class="col-md-12">
						<?= $this->Form->text('other_profession', ['class' => 'form-control', 'id' => 'inputOtherProfession', 'placeholder' => 'Other Profession', 'value' => isset($user) ? $user->other_profession : false]); ?>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<fieldset>
				<div class="form-group row">
					<label for="textAreaAbout" class="col-md-12 control-label">About</label>
					<div class="col-md-12">
						<?= $this->Form->textarea('about', ['name' => 'about', 'class' => 'form-control', 'rows' => 3, 'id' => 'textAreaAbout', 'value' => isset($user) ? $user->about : false]) ?>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
	
	<p class="well well-sm visibility-info">The information below will not be public. It will only be used for statistical purposes.</p>
	
	<div class="row">
		<div class="col-md-6">
		
			<fieldset>
				<div class="form-group row">
					<label class="col-md-12 control-label">Birthday</label>
					<div id="birthdayDiv" class="birthdaySelects" data-value="<?= (isset($user) && $user->birthday) ? $user->birthday->format('Y-m-d') : '' ?>">
						<div class="row">
							<div class="col col-xs-3">
								
								<select name="birthdayYear" class="selectYear form-control">
									<option value="">Year</option>
									<?
										$y = (int) date('Y');
										for( $i=$y; $i>=$y-100; $i-- ) {
									?>
									<option value="<?= $i ?>"><?= $i ?></option>
									<? } ?>
								</select>
								
							</div><div class="col col-xs-6">
								
								<select name="birthdayMonth" class="selectMonth form-control">
									<option value="">Month</option>
									<?
										for( $i=1; $i<=12; $i++ ) {
										$dateObj   = DateTime::createFromFormat('!m', $i);
									?>
									<option value="<?= str_pad($i, 2, '0', false) ?>"><?= $dateObj->format('F') ?></option>
									<? } ?>
								</select>
								
							</div><div class="col col-xs-3">
								
								<select name="birthdayDay" class="selectDay form-control">
									<option value="">Day</option>
									<? for( $i=1; $i<=31; $i++ ) {?>
									<option value="<?= str_pad($i, 2, '0', false) ?>"><?= $i ?></option>
									<? } ?>
								</select>
								
							</div>
						</div>										
						
					</div>
				</div>
			</fieldset>
		
		</div><div class="col-md-6">
			
			<fieldset>
				<div class="form-group row">
					<label for="inputGender" class="col-md-12 control-label">Gender</label>
					<div class="col-md-12">
						<select id="inputGender" name="gender" class="form-control" data-value="<?= isset($user) ? $user->gender : '' ?>">
							<option value=""></option>
							<option value="male">Male</option>
							<option value="female">Female</option>
							<option value="other">Other</option>
						</select>
					</div>
				</div>
			</fieldset>
			
		</div>
	</div>

</div>