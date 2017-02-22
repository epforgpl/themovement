<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
	echo $this->Less->less('less/items.less');
	$this->prepend('script', $this->Html->script('page'));
	$this->prepend('script', $this->Html->script('event'));
	
	echo $this->element('Items/Events/header', [
		'item' => $item
	]);

	if( $item->toc ) {	
?>
<div id="tocModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Terms and Conditions</h4>
      </div>
      <div class="modal-body">

	  	<div class="terms_text">
		<?= $item->toc ?>
		</div>
	  	
      </div>
      <div class="modal-footer text-center">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<? } ?>

<div id="followingModal" class="modal fade" tabindex="-1" role="dialog" data-url="<?= $item->getUrl() ?>/following">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= $item->registration ? 'Who is going' : 'Following' ?></h4>
      </div>
      <div class="modal-body">
	  	
	  	<div class="scrollDiv">
	  	<div class="tmTable followers"></div>
	  	</div>
	  	<div class="loader"><?= $this->Layout->spinner() ?></div>
	  	
      </div>
      <div class="modal-footer text-center">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<? if( $_user && $item['registration'] ) { ?>
	
	
	<? if($user_registration && $user_registration->status===0) { ?>
	<div class="row" id="register-user-div">
		<div class="col-md-12">
			
			<div class="block block-registration block-confirm">
	
				<header class="text-center"><h2>Confirm your registration</h2></header>
	
				<div class="content">
									
					<? if( $user_registration->coupon ) {?>
						<div class="row">
							<div class="col-sm-6 col-sm-offset-3">
						<? if( $user_registration->coupon_valid ) { ?>
								<div class="alert alert-success">Your coupon is valid.</div>
						<? } else { ?>
								<div class="alert alert-danger">Your coupon is invalid.</div>
						<? } ?>
							</div>
						</div>
					<? } ?>
					
					<input type="hidden" name="event_id" value="<?= $item->id ?>" />
					
					<div class="form_inner">
					
						<div class="row">
							<div class="col-md-4">
								
								<fieldset>
									
									<div class="form-group row">
										<label for="inputParticipant" class="col-md-12 control-label">Participant</label>
										<div class="col-md-12">
											<p class="value"><?= $_user['name'] ?></p>
										</div>
									</div>
									
								</fieldset>
								
							</div><div class="col-md-4">
							
								<fieldset>
									<div class="form-group row">
										<label for="textAreaDietary" class="col-md-12 control-label">Dietary restrictions</label>
										<div class="col-md-12">
											<p class="value"><?= $user_registration->dietary ? $user_registration->dietary : '<span class="none">None</span>' ?></p>
										</div>
									</div>
								</fieldset>
								
							</div><div class="col-md-4">
							
								<fieldset>
									<div class="form-group row">
										<label for="textAreaComments" class="col-md-12 control-label">Additional comments / special needs</label>
										<div class="col-md-12">
											<p class="value"><?= $user_registration->comments ? $user_registration->comments : '<span class="none">None</span>' ?></p>
										</div>
									</div>
								</fieldset>
							
							</div>
						</div>
						
						<? if( $user_registration->events_days ) {?>
						<div class="row">
							<div class="col-md-12">
								
								<div class="form-group row text-center">
									<label class="col-md-12 control-label">You will participate in <?= $item->name ?> on:</label>
									<div class="col-md-12 days_values">
										<? foreach( $user_registration->events_days as $day ) { ?>
										<p class="value"><?= $day->date->format('l, F j, Y') ?></p>
										<? } ?>
									</div>
								</div>
								
							</div>
						</div>
						<? } ?>
										
					</div>
	
					<div class="buttons text-center">
					
					
						<? if( 
							$item->registration_free || 
							(
								$user_registration->coupon && 
								$user_registration->coupon_valid
							)
							
						) {?>
						
							<div class="buttons-primary">
								<a href="<?= $this->Url->build(['controller' => 'Events', 'action' => 'finishRegistration', $item->slug]) ?>" class="btn btn-register btn-lg">Finish Registration</a>
							</div>
							
						<? } else { ?>
						
							<div class="buttons-primary">
								<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
									<input type="hidden" name="cmd" value="_s-xclick">
									<input type="hidden" name="hosted_button_id" value="6LRKHRHU2NWYQ">
									<input type="image" src="https://www.paypalobjects.com/en_US/PL/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
									<img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">
								</form>
	
							</div>
						
						<? } ?>
						
						<div class="buttons-secondary">
							<p><a href="#" id="btn-register-modify">Modify registration data</a></p>
							<form id="form-cancel-registration" method="post" action="<?= $item->getUrl() ?>">
								<p><input type="submit" name="cancel-registration" class="input-link" href="#" id="btn-register-cancel-registration" value="Cancel registration" />
							</form>
						</div>
						
						
						
					</div>
							
				</div>
					
			</div>
			
		</div>
	</div>
	<? } ?>
	<div class="row" id="register-div"<? if( !isset($this->request->query['register']) || ( isset($this->request->query['register']) && $user_registration && !$user_registration->isNew() ) ) {?> style="display: none;"<? } ?>>
		<div class="col-md-12">
			
			<div class="block block-registration block-minimal">
				
				<header class="text-center"><h2>You are about to register</h2></header>
				
				<div class="row">
					
					<div class="col-md-8 col-md-offset-2">
						
						<? if( $item->registration_free ) { ?>
						<p class="banner">Registration for this event is free. Please fill out the form below and press the "Submit" button.</p>
						<? } else { ?>
						<p class="banner without-coupon">The price for the event is <strong>20 PLN</strong>. Please fill out the form below and press the "Submit and Pay" button. In the next step you will be required to pay the registration fee via PayPal.</p>
						<p class="banner with-coupon" style="display: none;">Please fill out the form below and press the "Submit" button.</p>
						<? } ?>
						
						<form class="form-vertical" action="/events/register" method="post">
					
							<input id="inputEventId" type="hidden" name="event_id" value="<?= $item->id ?>" />
							
							<div class="form_inner">
								
								<?= $this->element('Users/profile', [
									'user' => $user,
									'disableBasicFields' => true,
									'autoInit' => isset( $this->request->query['register'] )
								]); ?>
								
								<div class="row">
									<div class="col-md-6">
									
										<fieldset>
											<div class="form-group row">
												<label for="textAreaDietary" class="col-md-12 control-label">Dietary restrictions for the event</label>
												<div class="col-md-12">
													<?= $this->Form->textarea('dietary', ['class' => 'form-control', 'rows' => 3, 'id' => 'textAreaDietary', 'value' => isset($user_registration) ? $user_registration->dietary : false]) ?>
													<span class="help-block">Food allergies, requirements (e.g. vegetarian).</span>
												</div>
											</div>
										</fieldset>
										
									</div><div class="col-md-6">
									
										<fieldset>
											<div class="form-group row">
												<label for="textAreaComments" class="col-md-12 control-label">Additional comments / special needs for the event</label>
												<div class="col-md-12">
													<?= $this->Form->textarea('comments', ['class' => 'form-control', 'rows' => 3, 'id' => 'textAreaComments', 'value' => isset($user_registration) ? $user_registration->comments : false]) ?>
												</div>
											</div>
										</fieldset>
									
									</div>
								</div>					
							</div>
							
							<div class="row">
								<div class="col-md-6 col-md-offset-3">
									
									<? if( $item->events_days ) { ?>
									<div class="form-group row daysCheckboxesDiv">
										<label class="col-md-12 control-label">I will attend PDF CEE 2017 on:</label>
										<?
											$ids = [];
											if( $user_registration->events_days ) {
												if( isset($user_registration->events_days['_ids']) )
													$ids = $user_registration->events_days['_ids'];
											}
										?>
										<div class="col-md-12" id="daysCheckboxes" data-value="<?= htmlspecialchars(json_encode($ids)) ?>">
											<? foreach( $item->events_days as $day ) {?>
											<div class="checkbox">
												<label class="ch">
													<input name="events_days[_ids][]" type="checkbox" value="<?= $day->id ?>"> <?= $day->date->format('l, F j, Y') ?>
												</label>
									        </div>
									        <? } ?>
										</div>
									</div>
									<? } ?>
									
									<? if( $item->registration_coupons ) {?>
									<div class="form-group row">
										<label for="inputCoupon" class="col-md-12 control-label">I have a coupon</label>
										<div class="col-md-12">
											<div class="input-group">
												<?= $this->Form->text('coupon', ['class' => 'form-control', 'id' => 'inputCoupon', 'placeholder' => 'Coupon Code', 'value' => isset($user_registration) ? $user_registration->coupon : false]) ?><span class="input-group-btn"><button id="btnCoupon" class="btn btn-default btn-coupon" type="button">Check</button></span>
											</div>
											
											<p class="msg-coupon valid" style="display: none;"><span class="glyphicon glyphicon-ok"></span> Your coupon is valid</p>
											<p class="msg-coupon invalid" style="display: none;"><span class="glyphicon glyphicon-remove"></span> Your coupon is invalid</p>
											
										</div>
									</div>
									<? } ?>
								</div>
							</div>
							
							<div class="buttons">
								<div class="buttons-primary">
									<button id="btn-submit-pay" type="submit" class="btn btn-register btn-lg btn-profile-edit-submit disabled" disabled="disabled"><?= $item->registration_free ? 'Submit' : 'Submit and Pay' ?></button>
								</div>
								
								<div class="buttons-secondary">
									<p><a href="#" id="btn-register-cancel">Cancel</a></p>
								</div>
							</div>
									
						</form>
						
					</div>
					
				</div>
								
			</div>
			
		</div>
	</div>
	
<? } ?>


<div class="row">
	<div class="col-md-6">
		
		<?php if( $item->about ) {?>
		<div class="block">
			<header><h2>About</h2></header>
			<ul class="tm_list">
				
				<li class="nopadding">
					<div class="icon"><span class="glyphicon glyphicon-align-justify"></span></div>
					<div class="content text">
					<?php echo $item->about ?>							
					</div>
				</li>
				
			</ul>
		</div>
		<? } ?>
		
		<?
			if($item->organizations_groups) {
				foreach( $item->organizations_groups as $group ) {
					$role = $group['role'];
					$orgs = $group['organizations'];
		?>
		<div class="block">
			<header><h2><?= $role['name'] ?></h2></header>
			<ul class="tm_organizations">
			<? foreach( $orgs as $o ) {?>
				<li>
					<p>
						<span class="glyphicon glyphicon-menu-right"></span>
						<? if( $o->www ) {?><a target="_blank" href="<?= $o->www ?>"><? } ?>
						<?= $o->name ?>
						<? if( $o->www ) {?></a><? } ?>
					</p>
				</li>
			<? } ?>
			</ul>
		</div>
		
		
		<? } } ?>

	</div><div class="col-md-6">
		
		<?php if(
			$item->begin_date ||
			$item->end_date ||
			$item->location ||
			$item->location_address || 
			$item->toc || 
			( $user_registration && ($user_registration->status==1) )
		) {?>
		<div class="block">
			<header><h2>Details</h2></header>
			<ul class="tm_list">
				<? if($user_registration && ($user_registration->status==1)) {?>
				<li class="dates nopadding">
					<div class="icon"><span class="glyphicon glyphicon-plane"></span></div>
					<div class="content">
						<p class="label label-success label-yag">You are going!</p>
						<? if( $item->registration_photo_generator ) { ?><p><a class="event-publisher-btn-share" href="#">Photo Generator</a></p><? } ?>
					</div>
				</li>
				
				<?
					$gender = 'other';
					if( in_array($_user['gender'], ['male', 'female']) )
						$gender = $_user['gender'];
				?>
				
				<div id="eventPublisherModal" class="modal fade" tabindex="-1" role="dialog">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title">Your registration has been finalized</h4>
				      </div>
				      <div class="modal-body">
					  	
					  	<div id="event-publisher" class="eventPublisherDiv">						  	
						  	<p>Now you can share it on social media by publishing your personalized photo which can look like this:</p>
						  	
						  	<div class="previewImg" style="background-image: url(/img/event-ban-pdfcee17-<?= $gender ?>-en.jpg)"></div>
						  	
						  	<div class="buttons text-center">
							  	<form class="uploadForm"  action="<?= $this->Url->build(['controller' => 'Images', 'action' => 'upload']) ?>" enctype="multipart/form-data" style="display: none;">
									<input class="inputFile" type="file" name="file" required />
								</form>
							  	<a class="btn btn-themovement btn-md btn-download" style="display: none;" href="#">Download image</a>
							  	<button class="btn btn-themovement btn-md btn-upload">Try with your own photo</button>
						  	</div>
					  	</div>
					  	
				      </div>
				      <div class="modal-footer text-center">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				      </div>
				    </div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				
				<? } ?>			
				<?php
					
					$date_parts = [];
					
					if( $item->begin_date ) {
						
						$part = '<span>Start</span> <strong>' . $item->begin_date->format('l, F j, Y') . '</strong>';
						if( $item->begin_time )
							$part .= ' &mdash; ' . $item->begin_time->format('G:i');
						
						$date_parts[] = $part;
						
					}
					
					if( $item->end_date ) {
						
						$part = '<span>End</span> <strong>' . $item->end_date->format('l, F j, Y') . '</strong>';
						if( $item->end_time )
							$part .= ' &mdash; ' . $item->end_time->format('G:i');
						
						$date_parts[] = $part;
						
					}
					
					if( $date_parts ) {
				?>
				<li class="dates nopadding">
					<div class="icon"><span class="glyphicon glyphicon-time"></span></div>
					<div class="content"><p><?php echo implode('</p><p>', $date_parts) ?></p></div>
				</li>
				<?php } ?>
				
				<?php if( $item->location || $item->location_address ) {?>
				<li class="nopadding">
					<div class="icon"><span class="glyphicon glyphicon-map-marker"></span></div>
					<div class="content">
						<?php if( $item->location ) { ?><p><strong><?php echo $item->location ?></strong></p><?php } ?>
						<?php if( $item->location_address ) { ?><p><?php echo $item->location_address ?></p><?php } ?>
					</div>
				</li>
				<?php } ?>
				
				<?php if( $item->www ) {?>
				<li class="nopadding">
					<div class="icon"><span class="glyphicon glyphicon-link"></span></div>
					<div class="content">
						<p><a target="_blank" href="<?php echo $item->www; ?>"><?php echo $item->www; ?></a></p>
					</div>
				</li>
				<?php } ?>
				
				<? if( $item->toc ) {?>
				<li class="nopadding">
					<div class="icon"><span class="glyphicon glyphicon-align-justify"></span></div>
					<div class="content">
						<p><a href="#" onclick="return false;" data-toggle="modal" data-target="#tocModal">See Terms and Conditions</a></p>
					</div>
				</li>
				<? } ?>
									
			</ul>
		</div>
		<? } ?>
		
		<? if( $followers && $followers->count() ) { ?>
		<div class="block block-followers">
			<header><h2><?= $followers_label ?></h2></header>
			<div class="content">
				<div class="tmTable followers">
				<?= $this->element('Items/Events/following', ['followers' => $followers]) ?>
				</div>
								
				<? if( $followers->all()->count() < $followers->count() ) {?>
				<div class="buttons">
					<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#followingModal">See all</button>
				</div>
				<? } ?>
				
			</div>
		</div>
		<? } ?>
		
		<? if( $relatedGroups = $item->groupRelatedEvents() ) { foreach( $relatedGroups as $related ) { ?>
		<div class="block block-see-also">
			<header><h2><?= $related['type']['label'] ?></h2></header>
			<div class="content items">
				<? foreach( $related['events'] as $related_event ) {?>
				<a href="<?= $related_event->getUrl() ?>" class="block tm_item">
					<?= $this->Layout->calendar( $related_event ); ?>
					<div class="img" style="background-image: url(<? if( $related_event->img ) { ?>/resources/events/<?= $related_event->id ?>-block.jpg?v=<?= $related_event->version ?><? } else { ?>/img/events-default.svg<? } ?>);"></div>
					<div class="info">
						<h2><?= $related_event->name ?></h2>
					</div>
				</a>
				<? } ?>
			</div>
		</div>
		<? } } ?>
		
		<?php if( false ) { ?>
		<div class="block">
			<header><h2>Who's Going?</h2></header>
			<ul class="tm_list">
			</ul>
		</div>
		<?php } ?>

	</div>
</div>