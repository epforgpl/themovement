<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
	echo $this->Less->less('less/items.less');
	echo $this->Less->less('less/manager.less');
	$this->prepend('script', $this->Html->script('page'));
	$this->prepend('script', $this->Html->script('event'));
	
	echo $this->element('Items/Events/header', [
		'item' => $item
	]);
?>

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
							<a href="mailto:<?= htmlspecialchars( $r->user->email ) ?>"><span class="glyphicon glyphicon-envelope" data-toggle="tooltip" data-placement="bottom" title="<?= htmlspecialchars( $r->user->email ) ?>"></span></a>
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