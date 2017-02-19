<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
	echo $this->Less->less('less/items.less');
	echo $this->Less->less('less/manager.less');
	$this->prepend('script', $this->Html->script('page'));
	$this->prepend('script', $this->Html->script('event'));
	$this->prepend('script', $this->Html->script('coupons'));
	
	echo $this->element('Items/Events/header', [
		'item' => $item
	]);
?>

<div id="coupons-generate-new" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Generate new coupon</h4>
			</div>
			<form class="form-horizontal">
				<div class="modal-body">
					
					
					<fieldset>
				
						<div class="form-group">
							<label for="inputCode" class="col-lg-2 control-label">Code</label>
							<div class="col-lg-10">
								<input type="text" class="form-control" id="inputCode" placeholder="Code">
							</div>
						</div>
						
					</fieldset>
				
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="row">
	<div class="col-md-2">
		
		<?= $this->element('Items/admin-nav', [
			'item' => $item,
			'selected' => 'coupons',
		]) ?>
				
	</div><div class="col-md-10">
		<div class="block">
			<header><h2>Coupons</h2></header>
			<div class="toolbar">
				<button class="input-link btn-coupons-generate-new" data-toggle="modal" data-target="#coupons-generate-new">Generate new</button>
			</div>
			<div class="content">
				<div class="tmTable">
					<? foreach( $coupons as $r ) {?>
					<div class="row">
						<div class="col-md-3"><span class="item-status <? if($r->used) { ?>item-status-finalized<? }?>"></span> <?= $r->code ?></div>
					</div>
					<? } ?>
				</div>
			</div>
		</div>		
	</div>
</div>