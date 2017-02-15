<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
	$this->prepend('script', $this->Html->script('page'));
?>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		
		<h1><?= $item->name ?></h1>
		
		<div class="block block-registration block-minimal">
			
			<header class="text-center"><h2>Edit Your Account</h2></header>
			
			
			<form class="form-vertical" action="<?= $item->getUrl() ?>/edit" method="post">
				
				<input id="inputUserId" type="hidden" name="user_id" value="<?= $item->id ?>" />
				
				<div class="form_inner">
				
					<?= $this->element('Users/profile', [
						'user' => $item, 
						'autoInit' => true
					]) ?>				
				
				</div>
				
				<div class="buttons">
					<div class="buttons-primary">
						<input name="save" type="submit" class="btn btn-register btn-lg btn-profile-edit-submit disabled" disabled="disabled" value="Save" />
					</div>
					
					<div class="buttons-secondary">
						<p><a href="<?= $item->getUrl() ?>">Cancel</a></p>
					</div>
				</div>
						
			</form>
				
		</div>

	</div>
</div>