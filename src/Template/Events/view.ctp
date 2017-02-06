<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
?>

<div class="row">
	<div class="col-md-12">
		
		<div class="block block-item-header">
			<div class="row">
				<div class="col-md-8">
					<div class="block-col-img" style="background-image: url(/resources/1-block.jpg);"></div>
				</div>
				<div class="col-md-4">
					
					<div class="block-col-info">
						<div class="tm_item_cont">
							<div class="tm_item">
								
								<?php if( $item->begin_date ) {?>
								<div class="code_avatar event">
									<div class="code_avatar_inner">
										<p class="month"><?php echo $item->begin_date->format('M y'); ?></p>
										<p class="days"><?php
											
											$parts = [ $item->begin_date->format('j') ];
											
											if( $item->end_date )
												$parts[] = $item->end_date->format('j');
												
											echo implode('-', $parts);
											
										?></p>
									</div>
								</div>
								<?php } ?>
								
								<p class="name"><?php echo $item->name; ?></p>
								<?php if( false ) {?><p class="stats">325 person is going</p><?php } ?>
							</div>
							<div class="buttons">
								<div class="buttons_inner">
									<div class="btn-group">
										<button class="btn btn-md btn-primary btn-main"><span class="glyphicon glyphicon-plus"></span> Register</button><button class="btn btn-md btn-default"><span class="glyphicon glyphicon-comment"></span></button><button class="btn btn-md btn-default"><span class="glyphicon glyphicon-share"></span></button><button class="btn btn-md btn-default"><span class="glyphicon glyphicon-cog"></span></button>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>

	</div>
</div>
<div class="row">
	<div class="col-md-6">
		
		<?php if( $item->about ) {?>
		<div class="block">
			<header><h2>About</h2></header>
			<ul class="tm_list">
				
				<li class="nopadding">
					<div class="icon"><span class="glyphicon glyphicon-align-justify"></span></div>
					<div class="content text">
					<?php echo $item->about ?>							
					</div>
				</li>
				
			</ul>
		</div>
		<? } ?>

	</div><div class="col-md-6">
		
		<?php if(
			$item->begin_date ||
			$item->end_date ||
			$item->location ||
			$item->location_address
		) {?>
		<div class="block">
			<header><h2>Details</h2></header>
			<ul class="tm_list">
				
				<?php if( $item->www ) {?>
				<li class="nopadding">
					<div class="icon"><span class="glyphicon glyphicon-link"></span></div>
					<div class="content">
						<p><a target="_blank" href="<?php echo $item->www; ?>"><?php echo $item->www; ?></a></p>
					</div>
				</li>
				<?php } ?>
				
				<?php
					
					$date_parts = [];
					
					if( $item->begin_date ) {
						
						$part = '<span>Start</span> <strong>' . $item->begin_date->format('l, F j, Y') . '</strong>';
						if( $item->begin_time )
							$part .= ' &mdash; ' . $item->begin_time->format('G:i');
						
						$date_parts[] = $part;
						
					}
					
					if( $item->end_date ) {
						
						$part = '<span>End</span> <strong>' . $item->end_date->format('l, F j, Y') . '</strong>';
						if( $item->end_time )
							$part .= ' &mdash; ' . $item->begin_time->format('G:i');
						
						$date_parts[] = $part;
						
					}
					
					if( $date_parts ) {
				?>
				<li class="dates nopadding">
					<div class="icon"><span class="glyphicon glyphicon-time"></span></div>
					<div class="content"><p><?php echo implode('</p><p>', $date_parts) ?></p></div>
				</li>
				<?php } ?>
				
				<?php if( $item->location || $item->location_address ) {?>
				<li class="nopadding">
					<div class="icon"><span class="glyphicon glyphicon-map-marker"></span></div>
					<div class="content">
						<?php if( $item->location ) { ?><p><strong><?php echo $item->location ?></strong></p><?php } ?>
						<?php if( $item->location_address ) { ?><p><?php echo $item->location_address ?></p><?php } ?>
					</div>
				</li>
				<?php } ?>
									
			</ul>
		</div>
		<? } ?>
		
		<?php if( false ) { ?>
		<div class="block">
			<header><h2>Who's Going?</h2></header>
			<ul class="tm_list">
			</ul>
		</div>
		<?php } ?>

	</div>
</div>