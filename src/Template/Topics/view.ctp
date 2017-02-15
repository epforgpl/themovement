<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
	$this->prepend('script', $this->Html->script('page'));
?>

<div class="row">
	<div class="col-md-12">
		
		<?
			$params = [
				'item' => $item,
				'chapter' => 'topics',
				'avatar_manage' => ( $_user && ($_user['role']=='admin') )
			];
			
			echo $this->element('Items/header', $params);
		?>

	</div>
</div>

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
		
		<? /*	
		<div class="block">
			<header><h2>Community</h2></header>
			<ul class="tm_list">
			</ul>
		</div>
		*/ ?>

	</div>
</div>