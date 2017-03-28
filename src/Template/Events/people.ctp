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
			<h1>People who are going for the event</h1>
		</header>
		
		<div class="row">
			<div class="col-md-3">
				
				<div class="items_filters">
					
					<div class="filter">
						<ul class="list-group">
						<?php
							foreach( $countries as $c ) {
								
								$options = isset($c['active']) ? [] : ['?' => ['country' => $c['id']]];
								$href = $item->getUrl('people', $options);
								
						?>						
							<a href="<?= $href ?>" class="list-group-item<?php if( isset($c['active']) ) {?> active <?php } ?>">
								<span class="badge"><?php echo $c['count'] ?></span>
								<?php echo $c['label']; ?>
							</a>
						<?php } ?>
						</ul>
					</div>
					
				</div>
				
			</div><div class="col-md-9">
		
				<?php echo $this->element('Users/index', [
					'items' => $regs,
				]); ?>
			
			</div>
		</div>
			
	</div>
</div>



