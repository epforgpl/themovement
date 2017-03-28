<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
	echo $this->Less->less('less/items.less');
	echo $this->Less->less('less/event-program.less');
	
	$this->prepend('script', $this->Html->script('page'));
	$this->prepend('script', $this->Html->script('events-agenda'));
	
	echo $this->element('Items/Events/header', [
		'item' => $item
	]);
?>

<div class="row">
	<div class="col-md-12">
		
		<header class="item_header" style="overflow: auto;">
			<h1 class="pull-left">Agenda</h1>			
		</header>

		
		<div class="row" id="agenda" data-event_id="<?= $item->id ?>">
			<div class="col-md-3">
				
				<div class="items_filters">
					
					<div class="filter">
						<ul class="list-group list-dates" role="tablist">
						<?php foreach( $dates as $d => $date ) { ?>
							<li role="presentation" class="list-group-item<?php if( $date_active == $d ) {?> active<?php } ?>"><a role="tab" href="#<?php echo $date->format('Y-m-d'); ?>" data-toggle="tab"><?php echo $date->format('l, F j'); ?></a></li>
						<?php } ?>
						</ul>
					</div>
					
				</div>
				
			</div><div class="col-md-9">
		
				<?php if( $sessions ) {?>
				<div class="block block-program">
					
					<div class="my-agenda-nav">
						<div class="checkbox">
							<label>
								<input class="ch_agenda" type="checkbox"> Show only my agenda
							</label>
						</div>
					</div>
					
					<div class="my-agenda-info">
						<p>Create your own personal agenda by selecting sessions and workshops you want to attend.</p>
					</div>
					
					<div class="tab-content">
						<?php foreach($sessions as $sessions_date => $sessions_items) { ?>
						<div class="tab-pane fade in<?php if( $sessions_date == $date_active ) {?> active<?php } ?>" id="<?php echo $sessions_date; ?>">
							<ul class="program">
								<?php
									foreach( $sessions_items as $session ) {
								?>
								<li class="session<? if($session->isSubscribable()) {?> subscribable<? } ?>" data-id="<?= $session->id ?>">
									<div class="session_header">
										<p class="tools"><? if( $session->isSubscribable() ) {?><input class="ch" type="checkbox" ><? } ?></p>
										<p class="time"><?php echo $session->time->format('G:i'); ?></p>
										<p class="title"><?php echo $session->title; ?></p>
									</div>
									<?php if( $session->description ) {?><div class="description"><?php echo $session->description; ?></div><?php } ?>
									<? if( $session->events_subsessions ) {?>
									<ul class="subsessions">
										<? foreach( $session->events_subsessions as $subsession ) { ?>
										<li class="subsession" data-id="<?= $subsession->id ?>">
											<label>
												<input class="chr" type="checkbox" name="session_<?= $session->id ?>" value="<?= $subsession->id ?>"><?php echo $subsession->title; ?>
											</label>
										</li>
										<? } ?>
									</ul>
									<? } ?>
								</li>
								<?php
									}
								?>
							</ul>
						</div>
						<?php } ?>
					</div>
					
				</div>
				<? } ?>
		
			</div>
		</div>
			
	</div>
</div>



