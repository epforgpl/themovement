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
				<li><?php echo $this->Html->link('People', ['controller' => 'People', 'action' => 'index']); ?></li>
				<li><?php echo $this->Html->link('Organizations', ['controller' => 'Organizations', 'action' => 'index']); ?></li>
				<li><?php echo $this->Html->link('News', ['controller' => 'News', 'action' => 'index']); ?></li>
			</ul>
		</div>
	</div>
</nav>