</div>
<footer id="footer-main">
	<div class="container">
		<div class="row">
			

					
			<div class="col-xs-6 col-sm-4">
				<section class="links">
					<h3>The Movement</h3>
					<ul>
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-menu-right"></span> About', ['controller' => 'Pages', 'action' => 'about'], ['escape' => false]) ?></li>
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-menu-right"></span> Contact', ['controller' => 'Pages', 'action' => 'contact'], ['escape' => false]) ?></li>
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-menu-right"></span> Start a topic', ['controller' => 'Pages', 'action' => 'topic'], ['escape' => false]) ?></li>
					</ul>
				</section>
			</div>
			
			<div class="col-xs-6 col-sm-4">
				<section class="sm">
					<h3>Follow us</h3>
					<ul>
						<li><?php echo $this->Html->link('<span class="icon-twitter"></span> Twitter', ['controller' => 'Pages', 'action' => 'about'], ['escape' => false]) ?></li>
						<li><?php echo $this->Html->link('<span class="icon-facebook"></span> Facebook', ['controller' => 'Pages', 'action' => 'contact'], ['escape' => false]) ?></li>
					</ul>
				</section>
			</div>
			
			<div class="col-xs-12 col-sm-4">
		
				<section class="copyright">
					<img src="/img/logo-yellow.svg" />
				</section>
				
			</div>
		
			
		</div>
	</div>
</footer>