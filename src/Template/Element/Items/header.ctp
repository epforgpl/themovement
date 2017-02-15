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

						<?= $this->Layout->calendar( $item ); ?>
														
						<h1 class="name"><?php echo $item->name; ?></h1>
						<?php if( false ) {?><p class="stats">325 person is going</p><?php } ?>
						
						<?
							if( isset($title_buttons) ) { foreach( $title_buttons as $button ) {
								
								$tag = isset($button['href']) ? 'a' : 'button';
								
						?>
							<<?= $tag ?><? if( isset($button['href']) ) {?> href="<?= $button['href'] ?>"<? } ?> id="<?= $button['id'] ?>" class="btn btn-md <?= $button['class'] ?>"<? if(isset($button['data'])) { foreach($button['data'] as $key => $val) { echo ' data-' . $key . '="' . $val . '"'; } }?>><?= $button['content'] ?></<?= $tag ?>>
						<? } } ?>
												
					</div>
					<? /*
					<div class="buttons">
						<div class="buttons_inner">
							<div class="btn-group">
								<button id="btn-register" class="btn btn-md btn-themovement btn-main"><span class="icon-text">&plus;</span> Follow</button><button class="btn btn-md btn-default"><span class="glyphicon glyphicon-comment"></span></button><button class="btn btn-md btn-default"><span class="glyphicon glyphicon-share"></span></button><button class="btn btn-md btn-default"><span class="glyphicon glyphicon-cog"></span></button>
							</div>
						</div>
					</div>
					*/ ?>
				</div>
			</div>
			
		</div>
	</div>
</div>