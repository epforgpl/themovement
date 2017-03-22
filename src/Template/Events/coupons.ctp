<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
	echo $this->Less->less('less/items.less');
	echo $this->Less->less('less/manager.less');
	echo $this->Less->less('less/coupons.less');
	$this->prepend('script', $this->Html->script('page'));
	$this->prepend('script', $this->Html->script('event'));
	$this->prepend('script', $this->Html->script('coupons'));
	
	echo $this->element('Items/Events/header', [
		'item' => $item
	]);
?>

<div id="coupons-generate-new" class="modal fade modal-manager" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Generate new coupon</h4>
			</div>
			<form class="form-horizontal" method="post" action="<?= $this->Url->build(['controller' => 'Coupons']) ?>">
				<input type="hidden" name="event_id" value="<?= $item->id ?>" />
				<div class="modal-body">
					
					
					<fieldset>
				
						<div class="form-group">
							<label for="inputCode" class="col-lg-2 control-label">Code</label>
							<div class="col-lg-10">
								<input name="code" type="text" class="form-control" id="inputCode" placeholder="Code">
							</div>
						</div>
						
					</fieldset>
					
					<fieldset class="sendDiv">
						
						<div class="form-group">
							<div class="col-lg-10">
								<div class="checkbox text-center">
									<label>
										<input name="send" type="checkbox"> Send instructions via email</label>
									</label>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="inputName" class="col-lg-2 control-label">Name</label>
							<div class="col-lg-10">
								<input name="name" type="text" class="form-control disabled" id="inputName" placeholder="Name" disabled="disabled">
							</div>
						</div>
						
						<div class="form-group">
							<label for="inputEmail" class="col-lg-2 control-label">Email</label>
							<div class="col-lg-10">
								<input name="email" type="text" class="form-control disabled" id="inputEmail" placeholder="Email" disabled="disabled">
							</div>
						</div>
					
					</fieldset>
					
					<div class="msgCont">
						<div class="msgDiv" style="display: none;">
							<div class="msgDivInner">
								<p class="status_code success alert alert-success">Your coupon has been saved</p>
								<p class="status_code fail alert alert-danger"></p>
								<p class="status_send">Instructions have been sent to:<br/><span class="addresse"></span></p>
								<p class="btn_generate_new"><button class="input-link btn-coupons-generate-renew">Generate new coupon</button></p>
							</div>
						</div>
					</div>
				
				</div>
				<div class="modal-footer text-center">
					
					<input type="submit" name="save" value="Save" class="btn btn-primary" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<div class="progress-cont">
					<div class="progress progress-striped active" style="display: none;">
				    	<div class="progress-bar"></div>
				    </div>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="row">
	<div class="col-md-12">
		
		<header class="item_header">
			<h1>Coupons</h1>
		</header>
		
		<div class="toolbar">
			<button class="input-link btn-coupons-generate-new" data-toggle="modal" data-target="#coupons-generate-new"><span class="glyphicon glyphicon-plus"></span> Generate new</button>
		</div>
		
		<div class="block">
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