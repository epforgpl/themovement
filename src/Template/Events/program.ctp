<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
	echo $this->Less->less('less/items.less');
	echo $this->Less->less('less/event-program.less');
	
	$this->prepend('script', $this->Html->script('page'));
	
	echo $this->element('Items/Events/header', [
		'item' => $item
	]);
?>

<div class="row">
	<div class="col-md-12">
		
		<header class="item_header">
			<h1>Program for the event</h1>
		</header>
		
		<div class="row">
			<div class="col-md-2">
				
				<div class="items_filters">
					
					<div class="filter">
						<ul class="list-group">
						<?php foreach( $dates as $d => $date ) { ?>
							<a class="list-group-item<?php if( $date_active == $d ) {?> active<?php } ?>" href="#<?php echo $date->format('Y-m-d'); ?>" data-toggle="tab"><?php echo $date->format('l, F j'); ?></a>
						<?php } ?>
						</ul>
					</div>
					
				</div>
				
			</div><div class="col-md-10">
		
				<?php if( $sessions ) {?>
				<div class="block block-program">
								
					<div class="tab-content">
						<?php foreach($sessions as $sessions_date => $sessions_items) { ?>
						<div class="tab-pane fade in<?php if( $sessions_date == $date_active ) {?> active<?php } ?>" id="<?php echo $sessions_date; ?>">
							<ul class="program">
								<?php
									foreach( $sessions_items as $session ) {
								?>
								<li class="session">
									<div class="session_header">
										<p class="time"><?php echo $session->time->format('G:i'); ?></p>
										<p class="title"><?php echo $session->title; ?></p>
									</div>
									<?php if( $session->description ) {?><div class="description"><?php echo $session->description; ?></div><?php } ?>
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



