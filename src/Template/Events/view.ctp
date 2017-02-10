<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
	$this->prepend('script', $this->Html->script('event'));
?>

<div class="row">
	<div class="col-md-12">
		
		<div class="block block-item-header" data-id="<?= $item->id ?>">
			<div class="row">
				<div class="col-md-8">
					<div class="block-col-img" style="background-image: url(<? if( $item->img ) { ?>/resources/events/<?= $item->id ?>-block.jpg?v=<?= $item->version ?><? } else { ?>/img/event-default.svg<? } ?>);">
						<div class="btn-group">
							<button id="btn-img-upload" class="btn btn-primary"><span class="glyphicon glyphicon-upload"></span></button><button id="btn-img-cancel" class="btn btn-danger" style="display: none;"><span class="glyphicon glyphicon-remove"></span></button><button id="btn-img-remove" class="btn btn-danger" style="display: none;"><span class="glyphicon glyphicon-remove"></span></button><button id="btn-img-save" class="btn btn-success" style="display: none;"><span class="glyphicon glyphicon-ok"></span></button>
						</div>
						<form id="form-img-upload" action="<?= $this->Url->build(['controller' => 'Events', 'action' => 'image_upload']) ?>" enctype="multipart/form-data" style="display: none;">
							<input class="file" type="file" name="file" id="file" required />
						</form>
					</div>
				</div>
				<div class="col-md-4">
					
					<div class="block-col-info">
						<div class="tm_item_cont">
							<div class="tm_item">

								<?= $this->Layout->calendar( $item ); ?>
																
								<h1 class="name"><?php echo $item->name; ?></h1>
								<?php if( false ) {?><p class="stats">325 person is going</p><?php } ?>
								
								<? if( !$user_registration ) { ?><button id="btn-register" class="btn btn-md btn-register btn-main" data-toggle="modal" data-target="#modal-register">Register</button><? } ?>
								
							</div>
							<div class="buttons">
								<div class="buttons_inner">
									<div class="btn-group">
										<button id="btn-register" class="btn btn-md btn-themovement btn-main"><span class="icon-text">&plus;</span> Follow</button><button class="btn btn-md btn-default"><span class="glyphicon glyphicon-comment"></span></button><button class="btn btn-md btn-default"><span class="glyphicon glyphicon-share"></span></button><button class="btn btn-md btn-default"><span class="glyphicon glyphicon-cog"></span></button>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>

	</div>
</div>

<div class="row" id="register-div" style="display: none;">
	<div class="col-md-12">
		
		<div class="block block-registration block-minimal">
			
			<header class="text-center"><h2>You are about to register</h2></header>
			
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<p class="banner">The price for the event is <strong>20 PLN</strong>. Please fill out the form below and press the "Submit and Pay" button. In the next step you will be required to pay the registration fee via PayPal.</p>
				</div>
			</div>
			
			<form class="form-vertical" action="/events/register" method="post">
				
				<input type="hidden" name="event_id" value="<?= $item->id ?>" />
				
				<div class="form_inner">
				
					<div class="row">
						<div class="col-md-4">
							
							<fieldset>
								<div class="form-group row">
									<label for="inputParticipant" class="col-md-12 control-label">Participant</label>
									<div class="col-md-12">
										<input disabled="disabled" type="text" class="form-control disabled" id="inputParticipant" name="participant" value="Daniel Macyszyn">
									</div>
								</div>
							</fieldset>
							
						</div><div class="col-md-4">
						
							<fieldset>
								<div class="form-group row">
									<label for="inputOrganizationName" class="col-md-12 control-label">Organization name</label>
									<div class="col-md-12">
										<input name="organization_name" type="text" class="form-control" id="inputOrganizationName" placeholder="Organization name" value="<?= isset($user_registration) ? $user_registration['organization_name'] : '' ?>">
									</div>
								</div>
							</fieldset>
							
						</div><div class="col-md-4">
						
							<fieldset>
								<div class="form-group row">
									<label for="inputOrganizationWWW" class="col-md-12 control-label">Organization website address</label>
									<div class="col-md-12">
										<input name="organization_www" type="text" class="form-control" id="inputOrganizationWWW" placeholder="Organization website address">
									</div>
								</div>
							</fieldset>
						
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4">
							
							<fieldset>
								<div class="form-group row">
									<label for="textAreaDietary" class="col-md-12 control-label">Dietary restrictions</label>
									<div class="col-md-12">
										<textarea name="dietary" class="form-control" rows="3" id="textAreaDietary"></textarea>
										<span class="help-block">Food allergies, requirements (e.g. vegetarian).</span>
									</div>
								</div>
							</fieldset>
							
						</div><div class="col-md-4">
						
							<fieldset>
								<div class="form-group row">
									<label for="textAreaComments" class="col-md-12 control-label">Additional comments / special needs</label>
									<div class="col-md-12">
										<textarea name="comments" class="form-control" rows="3" id="textAreaComments"></textarea>
									</div>
								</div>
							</fieldset>
							
						</div><div class="col-md-4">
						
							<fieldset>
								<div class="form-group row">
									<label for="inputCoupon" class="col-md-12 control-label">I have a coupon</label>
									<div class="col-md-12">
										<input name="coupon" type="text" class="form-control" id="inputCoupon" placeholder="Coupon Code">
									</div>
								</div>
							</fieldset>
						
						</div>
					</div>
				
				</div>
				
				<div class="buttons">
					<div class="buttons-primary">
						<button type="submit" class="btn btn-primary btn-lg">Submit and Pay</button>
					</div>
					
					<div class="buttons-secondary">
						<a href="#" id="btn-register-cancel">Cancel</a>
					</div>
				</div>
						
			</form>
				
		</div>
		
	</div>
</div>

<? if($user_registration) { ?>
<div class="row" id="register-user-div">
	<div class="col-md-12">
		
		<div class="block block-registration block-confirm">

			<header class="text-center"><h2>Confirm your registration</h2></header>

			<div class="content">
						
				<input type="hidden" name="event_id" value="<?= $item->id ?>" />
				
				<div class="form_inner">
				
					<div class="row">
						<div class="col-md-4">
							
							<fieldset>
								<div class="form-group row">
									<label for="inputParticipant" class="col-md-12 control-label">Participant</label>
									<div class="col-md-12">
										<p class="value">Daniel Macyszyn</p>
									</div>
								</div>
							</fieldset>
							
						</div><div class="col-md-4">
						
							<fieldset>
								<div class="form-group row">
									<label for="inputOrganizationName" class="col-md-12 control-label">Organization name</label>
									<div class="col-md-12">
										<p class="value"><?= $item->organization_name ?></p>
									</div>
								</div>
							</fieldset>
							
						</div><div class="col-md-4">
						
							<fieldset>
								<div class="form-group row">
									<label for="inputOrganizationWWW" class="col-md-12 control-label">Organization website address</label>
									<div class="col-md-12">
										<p class="value"><?= $item->organization_name ?></p>
									</div>
								</div>
							</fieldset>
						
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4">
							
							<fieldset>
								<div class="form-group row">
									<label for="textAreaDietary" class="col-md-12 control-label">Dietary restrictions</label>
									<div class="col-md-12">
										<p class="value"><?= $item->organization_name ?></p>
									</div>
								</div>
							</fieldset>
							
						</div><div class="col-md-4">
						
							<fieldset>
								<div class="form-group row">
									<label for="textAreaComments" class="col-md-12 control-label">Additional comments / special needs</label>
									<div class="col-md-12">
										<p class="value"><?= $item->organization_name ?></p>
									</div>
								</div>
							</fieldset>
							
						</div><div class="col-md-4">
						
							<fieldset>
								<div class="form-group row">
									<label for="inputCoupon" class="col-md-12 control-label">I have a coupon</label>
									<div class="col-md-12">
										<p class="value"><?= $item->organization_name ?></p>
									</div>
								</div>
							</fieldset>
						
						</div>
					</div>
				
				</div>

				<div class="buttons text-center">
					
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="6LRKHRHU2NWYQ">
						<input type="image" src="https://www.paypalobjects.com/en_US/PL/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">
						<input type="hidden" value="http://themovement.loca/paypal/return" name="return">
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

	</div><div class="col-md-6">
		
		<?php if(
			$item->begin_date ||
			$item->end_date ||
			$item->location ||
			$item->location_address
		) {?>
		<div class="block">
			<header><h2>Details</h2></header>
			<ul class="tm_list">
								
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