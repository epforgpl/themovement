<?
	$this->assign('title', 'Login');
	echo $this->Less->less('less/login.less');
	$this->prepend('script', $this->Html->script('login'));
?>
	
<div class="row">
	<div class="col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-12">
		<div class="block block-login">
			
			<header><h2>Log in using social media:</h2></header>
			<div class="content">
				
				<div class="text-center">
					<a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'facebookLogin']) ?>" class="btn btn-block btn-social btn-facebook"><span class="fa fa-facebook"></span> Log in with Facebook</a>
				</div>				
				
			</div>
			
			<div id="login-email"<? if( isset($this->request->query['register']) ) {?> style="display: none;"<? } ?>>
			
				<header><h2>Log in using e-mail address:</h2></header>
				<div class="content">
					
					<form class="form-horizontal" action="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>" method="post">
						<fieldset>
							<div class="form-group">
								<label for="inputEmail" class="col-md-3 control-label">E-mail</label>
								<div class="col-md-9">
									<input name="email" type="text" class="form-control" id="inputEmail" placeholder="Username" />
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword" class="col-md-3 control-label">Password</label>
								<div class="col-md-9">
									<input name="password" type="password" class="form-control" id="inputPassword" placeholder="Password" />
								</div>
							</div>
							
							<div class="form-group buttons text-center separator">
								<button type="submit" class="btn btn-themovement btn-sm btn-login btn-sm-fixed-width">Login</button>
							</div>
						</fieldset>
					</form>
					
					<div class="text-center button-separator">
						<a id="btn-show-register" href="#">Create account using e-mail address &raquo;</a>
					</div>
					
				</div>
			
			</div>
			
			<div id="register-email"<? if( !isset($this->request->query['register']) ) {?> style="display: none;"<? } ?>>
			
				<header><h2>Create account using e-mail address:</h2></header>
				<div class="content">
					
					<form class="form-horizontal" action="<?= $this->Url->build(['controller' => 'Users', 'action' => 'register']) ?>" method="post">
						<fieldset>
							<div class="form-group">
								<label for="inputEmail" class="col-md-3 control-label">E-mail</label>
								<div class="col-md-9">
									<input name="email" type="text" class="form-control" id="inputEmail" placeholder="Username" />
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword" class="col-md-3 control-label">Password</label>
								<div class="col-md-9">
									<input name="password" type="password" class="form-control" id="inputPassword" placeholder="Password" />
								</div>
							</div>
							<div class="form-group">
								<label for="inputConfirmPassword" class="col-md-3 control-label">Confirm password</label>
								<div class="col-md-9">
									<input name="confirmPassword" type="password" class="form-control" id="inputConfirmPassword" placeholder="Confirm password" />
								</div>
							</div>
							
							<div class="form-group separator">
								<label for="inputFirstName" class="col-md-3 control-label">First name</label>
								<div class="col-md-9">
									<input name="first_name" type="text" class="form-control" id="inputFirstName" placeholder="First name" />
								</div>
							</div>
							
							<div class="form-group">
								<label for="inputLastName" class="col-md-3 control-label">Last name</label>
								<div class="col-md-9">
									<input name="last_name" type="text" class="form-control" id="inputLastName" placeholder="Last name" />
								</div>
							</div>
							
							<div class="form-group">
								<label for="input" class="col-md-3 control-label">Birthday</label>
								<div class="col-md-9">
									<div class="birthdaySelects">
										<div class="row">
											<div class="col-xs-3">
												
												<select name="birthayYear" class="selectYear form-control">
													<option value="0">Year</option>
													<?
														$y = (int) date('Y');
														for( $i=$y; $i>=$y-100; $i-- ) {
													?>
													<option value="<?= $i ?>"><?= $i ?></option>
													<? } ?>
												</select>
												
											</div><div class="col-xs-6">
												
												<select name="birthayMonth" class="selectMonth form-control">
													<option value="0">Month</option>
													<?
														for( $i=1; $i<=12; $i++ ) {
														$dateObj   = DateTime::createFromFormat('!m', $i);
													?>
													<option value="<?= $i ?>"><?= $dateObj->format('F') ?></option>
													<? } ?>
												</select>
												
											</div><div class="col-xs-3">
												
												<select name="birthayDay" class="selectDay form-control">
													<option value="0">Day</option>
													<? for( $i=1; $i<=31; $i++ ) {?>
													<option value="<?= $i ?>"><?= $i ?></option>
													<? } ?>
												</select>
												
											</div>
										</div>										
										
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Gender</label>
								<div class="col-md-9">
									<div class="radio">
										<label>
											<input type="radio" name="gender" value="male"> Male
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="gender" value="female"> Female
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="gender" value="other"> Other
										</label>
									</div>
								</div>
							</div>
							
							<div class="form-group buttons text-center separator">
								<button type="submit" class="btn btn-themovement btn-sm btn-login btn-sm-fixed-width">Create account</button>
							</div>
						</fieldset>
					</form>
					
					<div class="text-center button-separator">
						<a id="btn-show-login" href="#">Log in using e-mail address &raquo;</a>
					</div>
					
				</div>
			
			</div>
			
		</div>
	</div>
</div>