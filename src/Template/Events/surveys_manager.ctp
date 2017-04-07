<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
	echo $this->Less->less('less/items.less');
	echo $this->Less->less('less/event-surveys_manager.less');
	echo $this->Less->less('less/jquery-ui.min.less');
	
	$this->prepend('script', $this->Html->script('page'));
	$this->prepend('script', $this->Html->script('jquery/jquery-ui-min'));
	
	
	if( !@$this->request->query['others'] )
		$this->prepend('script', $this->Html->script('event-surveys_manager.js'));
	
	echo $this->element('Items/Events/header', [
		'item' => $item
	]);
		
?>

<div class="row">
	<div class="col-md-12">
		
		
		
		<div id="surveys_manager" data-event_id="<?= $item->id ?>" data-questions="<? echo $this->Layout->data_encode($item->surveys_questions) ?>" data-question_id="<?= $item->surveys_question_id ?>" class="surveys_manager">
		
			<header class="item_header" style="overflow: auto;">
				<h1 class="pull-left">Surveys Managment</h1>
			</header>
			
			<? if( isset($others) ) {?>
				<ul>
				<? foreach( $others as $o ) {?>
					<li><?= $o->other ?></li>
				<? } ?>
				</ul>
			<? } ?>
			
			<div class="questions">
				
			</div>
			
			<div class="text-center">
				<button class="btn btn-themovement btn-add-question">Add Question</button>
			</div>
		
		</div>
			
	</div>
</div>