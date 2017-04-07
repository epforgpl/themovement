<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/event-surveys_present.less');
	
	$this->prepend('script', $this->Html->script('highcharts.js'));		
	$this->prepend('script', $this->Html->script('event-surveys_present.js'));		
?>

<div id="surveys_presenter" data-event_id="<?= $item->id ?>">
	<div id="url">pdfcee17.pl/survey</div>
	<div id="chart"></div>
</div>