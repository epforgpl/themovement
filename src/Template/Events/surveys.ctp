<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
	echo $this->Less->less('less/items.less');
	echo $this->Less->less('less/event-surveys_player.less');
	
	$this->prepend('script', $this->Html->script('page'));
	$this->prepend('script', $this->Html->script('event-surveys_player.js'));
	
	echo $this->element('Items/Events/header', [
		'item' => $item
	]);
?>

<div class="row">
	<div class="col-md-12">
		
		<header class="item_header" style="overflow: auto;" >
			<h1 class="pull-left">Surveys</h1>			
		</header>

		<div id="surveys_player" class="surveys_player" data-event_id="<?= $item->id ?>" data-action="<?= $item->getUrl('surveys') ?>">
			
			<div class="block loading">
				<header>
					<h2></h2>
				</header>
				
				<div class="msg">
					<p class="empty">There are no active surveys at this time.</p>
					<p class="loading">Connecting to server...</p>
				</div>
				
				<ul class="answers">
					
				</ul>
				
				<div class="buttons">
					<button class="btn btn-themovement btn-vote">Vote</button>
				</div>
				
				<div class="status" style="display: none;">
					<p>Thanks for voting!</p>
				</div>
				
				<div class="progress progress-striped active" style="visibility: hidden;"><div class="progress-bar" style="width: 100%"></div></div>
				
			</div>
			
		</div>
			
	</div>
</div>



