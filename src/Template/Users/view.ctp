<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
	$this->prepend('script', $this->Html->script('page'));
?>

<div class="row">
	<div class="col-md-12">
		
		<?
			$params = [
				'item' => $item,
				'chapter' => 'people',
			];
						
			if( $item->isLoggedUser() ) {
				
				$params['avatar_manage'] = true;
				$params['title_buttons'] = [
					[
						'id' => 'btn-edit-profile',
						'class' => 'btn-register',
						'content' => 'Edit Profile',
						'href' => $this->Url->build(['controller' => 'Users', 'action' => 'edit', $item->slug]),
					]
				];
				
			}
			
			echo $this->element('Items/header', $params);
		?>

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
		
		<? if( $item->professions ) { ?>
		<div class="block">
			<header><h2>Professions</h2></header>
			<ul class="tm_list">
				
				<? foreach( $item->professions as $profession ) {?>
				<li class="nopadding">
					<div class="icon"><span class="glyphicon glyphicon-equalizer"></span></div>
					<div class="content text">
					<?php echo $profession->name ?>							
					</div>
				</li>
				<? } ?>
								
			</ul>
		</div>
		<? } ?>

	</div><div class="col-md-6">
		
		<?php if( $item->organization_name ) {?>
		<div class="block">
			<header><h2>Organization</h2></header>
			<ul class="tm_list">
				
				<li class="nopadding">
					<div class="icon"><span class="glyphicon glyphicon-equalizer"></span></div>
					<div class="content text">
					<?php echo $item->organization_name ?>							
					</div>
				</li>
				
				<? if( $item->organization_role ) {?>
				<li class="nopadding">
					<div class="icon"><span class="glyphicon glyphicon-user"></span></div>
					<div class="content text">
					Position: <?php echo $item->organization_role ?>							
					</div>
				</li>
				<? } ?>
				
				<? if( $item->organization_www ) {?>
				<li class="nopadding">
					<div class="icon"><span class="glyphicon glyphicon-link"></span></div>
					<div class="content text">
					<a href="<?= $item->organization_www ?>" target="_blank"><?php echo $item->organization_www ?></a>						
					</div>
				</li>
				<? } ?>
				
			</ul>
		</div>
		<? } ?>
		
	</div>
</div>