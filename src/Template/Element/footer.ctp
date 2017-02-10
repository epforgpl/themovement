	</div>
</div>
<footer id="footer-main">
	<div class="container">
		<div class="row">
			

					
			<div class="col-xs-6 col-sm-6">
				<section class="links">
					<h3>The Movement</h3>
					<ul>
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-menu-right"></span> About', ['controller' => 'Pages', 'action' => 'about'], ['escape' => false]) ?></li>
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-menu-right"></span> Join', ['controller' => 'Users', 'action' => 'add'], ['escape' => false]) ?></li>
					</ul>
				</section>
			</div>
			
			<? /*
			<div class="col-xs-6 col-sm-4">
				<section class="sm">
					<h3>Follow us</h3>
					<ul>
						<li><?php echo $this->Html->link('<span class="icon-twitter"></span> Twitter', ['controller' => 'Pages', 'action' => 'about'], ['escape' => false]) ?></li>
						<li><?php echo $this->Html->link('<span class="icon-facebook"></span> Facebook', ['controller' => 'Pages', 'action' => 'contact'], ['escape' => false]) ?></li>
					</ul>
				</section>
			</div>
			*/ ?>
			
			<div class="col-xs-6 col-sm-6">
		
				<section class="copyright">
					<img src="/img/themovement_logo_inverted.svg" />
					<div class="credits">
						<p>Project by <a href="http://epf.org.pl" target="_blank">EPF</a></p>
						<p>Inspired by <a href="https://travelmassive.com">Travel Massive</a></p>
					</div>
				</section>
				
			</div>
		
			
		</div>
	</div>
</footer>