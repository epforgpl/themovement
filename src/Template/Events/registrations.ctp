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
			'selected' => 'registrations',
		]) ?>
				
	</div><div class="col-md-10">
		<div class="block">
			<header><h2>Registrations</h2></header>
			<div class="content">
				<div class="tmTable">
					<? foreach( $registrations as $r ) {?>
					<div class="row">
						<div class="col-md-2"><p class="timestamp"><?= $r->created->format('Y-m-d H:i') ?></p></div>
						<div class="col-md-3"><span class="item-status <? if($r->status) { ?>item-status-finalized<? }?>"></span> <?= $this->Text->truncate($r->user->name, 25) ?></div>
						<div class="col-md-4"><?= $this->Text->truncate($r->user->organization_name, 35) ?></div>
						<div class="col-md-3">
							<div class="icons">
							<? if( $r->coupon ) { ?><span class="glyphicon glyphicon-tag" data-toggle="tooltip" data-placement="bottom" title="<?= htmlspecialchars( $r->coupon ) ?>"></span><? } ?>
							<? if( $r->dietary ) { ?><span class="glyphicon glyphicon-cutlery" data-toggle="tooltip" data-placement="bottom" title="<?= htmlspecialchars( $r->dietary ) ?>"></span><? } ?>
							<? if( $r->comments ) { ?><span class="glyphicon glyphicon-comment" data-toggle="tooltip" data-placement="bottom" title="<?= htmlspecialchars( $r->comments ) ?>"></span><? } ?>
							</div>
						</div>
					</div>
					<? } ?>
				</div>
			</div>
		</div>		
	</div>
</div>