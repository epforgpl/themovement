<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
	$this->prepend('script', $this->Html->script('page'));
	$this->prepend('script', $this->Html->script('event'));
?>

<div class="row">
	<div class="col-md-12">
		
		<?
			$params = [
				'item' => $item,
				'chapter' => 'events',
				'avatar_manage' => ( $_user && ($_user['role']=='admin') )
			];
						
			if( $item['registration'] && !$user_registration ) {					
				
				if( $_user ) {
					$data = [];
					$class = 'btn-register';
				} else {
					$data = [
						'msg' => 'In order to register for this event, you need to login.',
						'next' => $item->getUrl() . '?register'
					];
					$class = 'btn-register login-required';
				}
				
				$params['title_buttons'] = [
					[
						'id' => 'btn-register',
						'class' => $class,
						'content' => 'Register',
						'data' => $data,
					]
				];
			}
			
			echo $this->element('Items/header', $params);
		?>
		
	</div>
</div>

<? if( $_user && $item['registration'] ) { ?>
<div class="row" id="register-div"<? if( !isset($this->request->query['register']) ) {?> style="display: none;"<? } ?>>
	<div class="col-md-12">
		
		<div class="block block-registration block-minimal">
			
			<header class="text-center"><h2>You are about to register</h2></header>
			
			<div class="row">
				
				<div class="col-md-8 col-md-offset-2">
					
					<p class="banner without-coupon">The price for the event is <strong>20 PLN</strong>. Please fill out the form below and press the "Submit and Pay" button. In the next step you will be required to pay the registration fee via PayPal.</p>
					<p class="banner with-coupon" style="display: none;">Please fill out the form below and press the "Submit" button.</p>
					
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
							</div>
						</div>
						
						<div class="buttons">
							<div class="buttons-primary">
								<button id="btn-submit-pay" type="submit" class="btn btn-register btn-lg btn-profile-edit-submit disabled" disabled="disabled">Submit and Pay</button>
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
							
						</div><? if( $user_registration->dietary ) {?><div class="col-md-4">
						
							<fieldset>
								<div class="form-group row">
									<label for="textAreaDietary" class="col-md-12 control-label">Dietary restrictions</label>
									<div class="col-md-12">
										<p class="value"><?= $user_registration->dietary ?></p>
									</div>
								</div>
							</fieldset>
							
						</div><? } if( $user_registration->comments ) { ?><div class="col-md-4">
						
							<fieldset>
								<div class="form-group row">
									<label for="textAreaComments" class="col-md-12 control-label">Additional comments / special needs</label>
									<div class="col-md-12">
										<p class="value"><?= $user_registration->comments ?></p>
									</div>
								</div>
							</fieldset>
						
						</div><? } ?>
					</div>
									
				</div>

				<div class="buttons text-center">
				
				
					<? if( $user_registration->coupon && $user_registration->coupon_valid ) {?>
					
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

	</div><div class="col-md-6">
		
		<?php if(
			$item->begin_date ||
			$item->end_date ||
			$item->location ||
			$item->location_address || 
			( $user_registration && ($user_registration->status==1) )
		) {?>
		<div class="block">
			<header><h2>Details</h2></header>
			<ul class="tm_list">
				<? if($user_registration && ($user_registration->status==1)) {?>
				<li class="dates nopadding">
					<div class="icon"><span class="glyphicon glyphicon-plane"></span></div>
					<div class="content"><p class="label label-success label-yag">You are going!</p></div>
				</li>
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
							$part .= ' &mdash; ' . $item->begin_time->format('G:i');
						
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
									
			</ul>
		</div>
		<? } ?>
		
		<?php if( false ) { ?>
		<div class="block">
			<header><h2>Who's Going?</h2></header>
			<ul class="tm_list">
			</ul>
		</div>
		<?php } ?>

	</div>
</div>