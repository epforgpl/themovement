<?php
	$this->assign('title', 'The Movement');
	echo $this->Less->less('less/home.less');
?>

<div class="hompage">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			
			<div id="info">
				
				<div class="text">
					<h1><? if($_user) { ?>Welcome back, <? echo $_user['name']; } else { ?>Be Part Of The Movement.<? } ?></h1>
					
					<p class="motto">The Movement connects thousands of open data specialists to meet, learn and collaborate in joint initiatives and at international events. We are a global community of activists, leaders and innovators who have the ambition to change the world.</p>
					
					<div class="counters">
						<div class="row">
							<div class="col-md-8 col-md-offset-2">
								<div class="row">
									<div class="col-xs-4">
										
										<a href="<?= $this->Url->build(['controller' => 'Topics']) ?>">
											<p class="number"><?= $counters['topics'] ?></p>
											<p class="desc">Topics</p>
										</a>
										
									</div><div class="col-xs-4">
										
										<a href="<?= $this->Url->build(['controller' => 'Events']) ?>">
											<p class="number"><?= $counters['events'] ?></p>
											<p class="desc">Events</p>
										</a>
										
									</div><div class="col-xs-4">
										
										<? /* <a href="<?= $this->Url->build(['controller' => 'Users']) ?>"> */ ?>
											<p class="number"><?= $counters['people'] ?></p>
											<p class="desc">People</p>
										<? /* </a> */ ?>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<? /*
				<? if( !$_user ) {?>
				<a class="btn btn-lg btn-themovement btn-lg-fixed-width" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>">Join now</a>
				<? } ?>
				*/ ?>
				
			</div>
			
		</div>
	</div>
	
	<h2 class="text text-center">Upcoming events</h2>
	
	<div class="items">
		<div class="row">
		<?
			foreach( $events as $item ) {
		?>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<a href="<?= $item->getUrl() ?>" class="block tm_item">
					<?= $this->Layout->calendar( $item ); ?>
					<div class="img" style="background-image: url(<? if( $item->img ) { ?>/resources/events/<?= $item->id ?>-block.jpg?v=<?= $item->version ?><? } else { ?>/img/event-default.svg<? } ?>);"></div>
					<div class="info">
						<div class="info_inner">
							<h2><?= $item->name ?></h2>
						</div>
					</div>
				</a>
			</div>
		<?
			}
		?>
		</div>
	</div>
	
	<div class="text-center">
		<a class="btn btn-lg btn-themovement btn-lg-fixed-width" href="<?= $this->Url->build(['controller' => 'Events']) ?>">View all</a>
	</div>
</div>