<?php
	$this->assign('title', 'Creating new topic - The Movement');
?>

<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">

			<form class="form-horizontal" method="post" action="<?php echo $this->Url->build([
				'controller' => 'Topics',
				'action' => 'create'
			]) ?>">
				<fieldset>
					
					<legend>Create new topic</legend>
					
					<div class="form-group">
						<label for="inputName" class="col-lg-2 control-label">Name</label>
						<div class="col-lg-10">
							<input class="form-control" id="inputName" name="name" placeholder="Name of your topic" type="text">
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputPurpose" class="col-lg-2 control-label">Purpose</label>
						<div class="col-lg-10">
							<textarea class="form-control" name="purpose" rows="6" id="inputPurpose"></textarea>
						</div>
					</div>
					
				</fieldset>
			</form>

		</div>
	</div>
</div>