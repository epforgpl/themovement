<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
	echo $this->Less->less('less/items.less');
	echo $this->Less->less('less/manager.less');
	echo $this->Less->less('less/event-registrations.less');
	
	$this->prepend('script', $this->Html->script('page'));
	$this->prepend('script', $this->Html->script('event'));
	$this->prepend('script', $this->Html->script('registrations'));
	
	echo $this->element('Items/Events/header', [
		'item' => $item
	]);
?>

<div id="registration-finish" class="modal fade modal-manager registration-finish-ask" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Finish registration</h4>
			</div>
			<form class="form-horizontal" method="post" action="<?= $this->Url->build(['controller' => 'Registrations', 'action' => 'finish']) ?>">
				<input type="hidden" name="registration_id" value="" />
				<div class="modal-body">
					
					<div class="info">
						<p class="name"></p>
						<p class="organization"></p>
					</div>
					
					<fieldset class="sendDiv active">
												
						<div class="form-group">
							<div class="col-lg-12">
								<div class="checkbox text-center">
									<label>
										<input name="send" type="checkbox"> Send confirmation via email</label>
									</label>
								</div>
							</div
						</div>
					
					</fieldset>
					
					<div class="msgCont">
						<div class="msgDiv text-center " style="display: none;">
							<div class="msgDivInner">
								<p class="status_code success alert alert-success">Registration has been finished</p>
								<p class="status_code fail alert alert-danger"></p>
								<p class="status_send">A confirmation have been sent to:<br/><span class="addresse"></span></p>
							</div>
						</div>
					</div>
				
				</div>
				<div class="modal-footer text-center">
					<input type="submit" name="save" value="Finish" class="btn btn-primary" />
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

<div id="registration-ask" class="modal fade modal-manager registration-finish-ask" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Ask for the registration</h4>
			</div>
			<form class="form-horizontal" method="post" action="<?= $this->Url->build(['controller' => 'Registrations', 'action' => 'ask']) ?>">
				<input type="hidden" name="registration_id" value="" />
				<div class="modal-body">
					
					<div class="info">
						<p class="name"></p>
						<p class="organization"></p>
					</div>
										
					<div class="msgCont">
						<div class="msgDiv text-center " style="display: none;">
							<div class="msgDivInner">
								<p class="status_code success alert alert-success">An e-mail has been sent</p>
								<p class="status_code fail alert alert-danger"></p>
							</div>
						</div>
					</div>
				
				</div>
				<div class="modal-footer text-center">
					<input type="submit" name="save" value="Ask" class="btn btn-primary" />
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
		
		<header class="item_header overflow-auto">
			<h1 class="pull-left">Registrations (<?= $registrations->count() ?>)</h1>
			<div class="pull-right"><a href="<?= $this->Url->build([
				'controller' => 'Events',
				'action' => 'registrations',
				'slug' => $item->slug,
				'?' => [
					'download' => 'csv',
				],
			]) ?>" class="btn btn-default"><span class="glyphicon glyphicon-download"></span></a></div>
		</header>
		
		<div class="block">
			<div class="content">
				<div class="tmTable registrationsTable">
					<? foreach( $registrations as $r ) {?>
					<div class="row" data-id="<?= $r->id ?>" data-item="<?= $this->Layout->data_encode( $r ) ?>">
						<div class="col-md-2"><p class="timestamp"><?= $r->created->format('Y-m-d H:i') ?></p></div>
						<div class="col-md-3"><span class="dropdown"><span class="caret_cont" data-toggle="dropdown"><span class="caret"></span></span><ul class="dropdown-menu"></ul></span><span class="item-status<? if($r->status==1) { ?> item-status-finalized<? }?><? if($r->status==2) { ?> item-status-asked<? }?><? if($r->confirmation_sent) { ?> item-confirmation-sent<? }?>"></span> <?= $this->Text->truncate($r->user->name, 25) ?></div>
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