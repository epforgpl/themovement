<?
	$this->assign('title', 'Sign up');
	echo $this->Less->less('less/login.less');
?>
	
<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
		<div class="block block-login">
			<header><h2>Sign up</h2></header>
			<div class="content">
				
				<form class="form-horizontal" action="/signup" method="post">
					<fieldset>
						<div class="form-group">
							<label for="inputEmail" class="col-md-2 control-label">Username</label>
							<div class="col-md-10">
								<input name="username" type="text" class="form-control" id="inputEmail" placeholder="Username" />
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword" class="col-md-2 control-label">Password</label>
							<div class="col-md-10">
								<input name="password" type="password" class="form-control" id="inputPassword" placeholder="Password" />
							</div>
						</div>
						<? /*
						<div class="form-group">
							<div class="checkbox col-lg-offset-2">
								<label>
									<input type="checkbox"> Checkbox
								</label>
							</div>
						</div>
						*/ ?>
						<div class="form-group buttons">
							<div class="col-md-10 col-md-offset-2">
								<button type="submit" class="btn btn-primary">Sign up</button>
							</div>
						</div>
					</fieldset>
				</form>
				
			</div>
		</div>
	</div>
</div>