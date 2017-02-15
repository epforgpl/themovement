<? // debug($_user); ?>

<nav id="header-main" class="navbar">
	<div class="container">
		<div class="navbar-header">
			
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-main-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			
			<a class="navbar-brand" href="/"><span>The Movement</span></a>
		</div>
		
		
		
		<div class="collapse navbar-collapse" id="header-main-collapse">
			<ul class="nav navbar-nav navbar-right menu">
				<li><?php echo $this->Html->link('Topics', ['controller' => 'Topics', 'action' => 'index']); ?></li>
				<li><?php echo $this->Html->link('Events', ['controller' => 'Events', 'action' => 'index']); ?></li>
				<? /*
				<li><?php echo $this->Html->link('People', ['controller' => 'People', 'action' => 'index']); ?></li>
				<li><?php echo $this->Html->link('Organizations', ['controller' => 'Organizations', 'action' => 'index']); ?></li>
				<li><?php echo $this->Html->link('News', ['controller' => 'News', 'action' => 'index']); ?></li>
				*/ ?>
				<? /* <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', '#', ['escape' => false]); ?></li> */ ?>
				<? if( $_user ) { ?>
				<li class="logged_user dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><? if($_user['fb_id']) {?><img src="//graph.facebook.com/<?= $_user['fb_id'] ?>/picture" /><? } else {?><span class="glyphicon glyphicon-user"></span><?}?></a>
					<ul class="dropdown-menu logged_user_dropdown">
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span> Profile', ['controller' => 'Users', 'action' => 'view', $_user['slug']], ['escape' => false]); ?></li>
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-off"></span> Log out', ['controller' => 'Users', 'action' => 'logout'], ['escape' => false]); ?></li>
					</ul>
				</li>
				<? } else { ?>
				<li><?php echo $this->Html->link('Join', ['controller' => 'Users', 'action' => 'login'], ['escape' => false]); ?></li>
				<? } ?>
			</ul>
		</div>
		
		
		
	</div>
</nav>

<?
	if(
		!(
			( $this->request->params['controller'] == 'Users' ) && 
			( $this->request->params['action'] == 'login' )
		)
	) {
?>

<div id="_login_template" style="display: none;">
	<div class="block block-login" style="display: none;">
		
		<div class="msg"></div>
		
		<header><h2>Log in using social media:</h2></header>
		<div class="content">
			
			<div class="text-center">
				<a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'facebook_login']) ?>" class="btn btn-block btn-social btn-facebook"><span class="fa fa-facebook"></span> Log in with Facebook</a>
			</div>				
			
		</div>
		
		<div id="login-email">
		
			<header><h2>Log in using e-mail address:</h2></header>
			<div class="content">
				
				<form class="form-horizontal" action="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>" method="post">
					<? echo $this->Form->hidden('next', ['class' => 'inputNext', 'value' => $this->request->here]); ?>
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
					<a class="btn-show-register" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login', '?' => ['register' => true]]) ?>">Create account using e-mail address &raquo;</a>
				</div>
				
			</div>
		
		</div>
			
	</div>
</div>
<? } ?>

<div id="body-main">
	<div class="container">
		<?= $this->Flash->render() ?>