<?
	if( !isset($avatar) )
		$avatar = false;
?>
<div class="block block-item-header" data-chapter="<?= $chapter ?>" data-id="<?= $item->id ?>">
	<div class="row">
		<div class="col-md-8">
			<div class="block-col-img" style="background-image: url(<? if( $item->img ) { ?>/resources/<?= $chapter ?>/<?= $item->id ?>-block.jpg?v=<?= $item->version ?><? } else { ?>/img/<?= $chapter ?>-default.svg<? } ?>);">
				<? if( isset($avatar_manage) && $avatar_manage ) {?>
				<div class="btn-group">
					<button id="btn-img-upload" class="btn btn-primary"><span class="glyphicon glyphicon-upload"></span></button><button id="btn-img-cancel" class="btn btn-danger" style="display: none;"><span class="glyphicon glyphicon-remove"></span></button><button id="btn-img-remove" class="btn btn-danger" style="display: none;"><span class="glyphicon glyphicon-remove"></span></button><button id="btn-img-save" class="btn btn-success" style="display: none;"><span class="glyphicon glyphicon-ok"></span></button>
				</div>
				<form id="form-img-upload" action="<?= $this->Url->build(['controller' => 'Images', 'action' => 'upload']) ?>" enctype="multipart/form-data" style="display: none;">
					<input class="file" type="file" name="file" id="file" required />
				</form>
				<? } ?>
			</div>
		</div>
		<div class="col-md-4">
			
			<div class="block-col-info">
				<div class="tm_item_cont">
					<div class="tm_item">
						
						<?
							if( $avatar == 'calendar' ) {
								
								echo $this->Layout->calendar( $item );
								
							} elseif( $avatar == 'user' ) {
						?>
						<div class="code_avatar user">
							<div class="code_avatar_inner">
								<?= $this->Layout->userAvatar($item, ['gender' => true]) ?>
							</div>
						</div>
						<?		
							}
						?>
						
					    
					    					     						
						<h1 class="name"><a href="<?= $item->getUrl() ?>"><?php echo $item->name; ?></a></h1>
						<?php if( false ) {?><p class="stats">325 person is going</p><?php } ?>
						
						<?
							if( isset($title_buttons) ) { foreach( $title_buttons as $button ) {
								
								$tag = isset($button['href']) ? 'a' : 'button';
								
						?>
							<<?= $tag ?><? if( isset($button['href']) ) {?> href="<?= $button['href'] ?>"<? } ?> id="<?= $button['id'] ?>" class="btn btn-md <?= $button['class'] ?>"<? if(isset($button['data'])) { foreach($button['data'] as $key => $val) { echo ' data-' . $key . '="' . $val . '"'; } }?>><?= $button['content'] ?></<?= $tag ?>>
						<? } } ?>
												
					</div>
					<? if( isset($buttons) && $buttons ) {?>
					<div class="buttons">
						<form action="<?= $item->getUrl() ?>" method="post">
							<div class="buttons_inner">
								<div class="btn-group">
								<? foreach( $buttons as $button ) { ?>
									<? if( isset($button['before']) ) echo $button['before']; ?>
									<?
										
										$tag = isset($button['tag']) ? $button['tag'] : 'button';
										
										if( isset($button['dropdown']) ) {
											
											if( !isset($button['class']) )
												$button['class'] = 'dropdown-toggle';
											else
												$button['class'] .= ' dropdown-toggle';
											
									?><? } ?>
									<<?= $tag ?><? if(isset($button['id'])) {?> id="<?= htmlspecialchars($button['id']) ?>"<? } ?> class="btn btn-md<? if( isset($button['class']) ) { echo ' ' . $button['class']; } ?>"<? if( isset($button['attr']) ) echo ' ' . $button['attr']; ?><? if(isset($button['data'])) { foreach($button['data'] as $key => $val) { echo ' data-' . $key . '="' . $val . '"'; } }?><? if( isset($button['name']) && $button['name'] ) {?> name="<?= $button['name'] ?>"<?}?><? if( isset($button['href']) && $button['href'] ) {?> href="<?= $button['href'] ?>"<?}?>><? if( isset($button['content']) ) { echo ' ' . $button['content']; } ?></<?= $tag ?>>
									<? if( isset($button['dropdown']) ) { ?>
										<ul class="dropdown-menu">
										<? foreach( $button['dropdown'] as $o ) {?>
									    <li><a href="<?= $o['href'] ?>"><?= $o['content'] ?></a></li>
									    <? } ?>
										</ul>
									<? } ?>
									<? if( isset($button['after']) ) echo $button['after']; ?>
								<? } ?>
								</div>
							</div>
						</form>
					</div>
					<? } ?>
				</div>
			</div>
			
		</div>
	</div>
</div>