<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
	echo $this->Less->less('less/items.less');
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
			
			if( $item['registration'] && !@$user_registration->id ) {					
				
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


<div class="row">
	<div class="col-md-2">
		
		<?= $this->element('Items/admin-nav', [
			'item' => $item,
			'selected' => 'coupons',
		]) ?>
				
	</div><div class="col-md-10">
		<div class="block">
			<header><h2>Coupons</h2></header>
			<div class="content">
				
			</div>
		</div>		
	</div>
</div>