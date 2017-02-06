<?php
	$this->assign('title', $topic->name . ' | The Movement');
	echo $this->Less->less('less/topic.less');
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">

			<div class="block block-topic-header">
				<div class="row">
					<div class="col-sm-8">
						<img class="header-img" src="http://movement.epf.p5.tiktalik.io/sites/default/files/styles/banner/public/images/chapters/keyboard-417089_1920.jpg" />
					</div><div class="col-sm-4">
						<div class="info">
							<div class="code" style="background-color: #f1e425;"><p>POL</p></div>
							<p class="name"><?php echo $topic->name; ?></p>
							<p class="stats">2 members</p>
						</div>
						<div class="buttons">
							
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<div class="row">
		<div class="col-md-6">

			<div class="block">
				<header><h2>About</h2></header>
				<div class="content">
					<?php echo $topic->about; ?>
				</div>
			</div>
			
			<div class="block">
				<header><h2>Events</h2></header>
			</div>

		</div><div class="col-md-6">

			<div class="block">
				<header><h2>Community</h2></header>
			</div>

		</div>
	</div>
</div>