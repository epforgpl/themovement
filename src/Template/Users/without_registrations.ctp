<?php
	$this->assign('title', 'Users without registrations | The Movement');
	echo $this->Less->less('less/page.less');
	echo $this->Less->less('less/items.less');
	echo $this->Less->less('less/manager.less');
	echo $this->Less->less('less/event-registrations.less');
	
	$this->prepend('script', $this->Html->script('page'));
	$this->prepend('script', $this->Html->script('event'));
	$this->prepend('script', $this->Html->script('registrations'));	
?>

<div class="row">
	<div class="col-md-12">
		<div class="block">
			<header><h2>Users without registrations (<?= $users->count() ?>)</h2></header>
			<div class="content">
				<div class="tmTable registrationsTable">
					<? foreach( $users as $user ) {?>
					<div class="row" data-id="<?= $user->id ?>" data-item="<?= $this->Layout->data_encode( $user ) ?>">
						<div class="col-md-1"><p class="timestamp"><?= $user->id ?></p></div>
						<div class="col-md-2"><p class="timestamp"><?= $user->created->format('Y-m-d H:i') ?></p></div>
						<div class="col-md-3"><?= $this->Text->truncate($user->name, 25) ?></div>
						<div class="col-md-4"><?= $this->Text->truncate($user->organization_name, 35) ?></div>
					</div>
					<? } ?>
				</div>
			</div>
		</div>		
	</div>
</div>