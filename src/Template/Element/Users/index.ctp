<?
	echo $this->Less->less('less/items.less');
?>
<div class="items">
	<div class="row">
	<?
		foreach( $items as $_item ) {
			$__item = $_item;
			$_item = $_item->user;
	?>
		<div class="col-md-4 col-sm-6 col-xs-12">
			<a href="<?= $_item->getUrl() ?>" class="block tm_item">
				<div class="code_avatar user">
					<div class="code_avatar_inner">
						<?= $this->Layout->userAvatar($_item, ['gender' => true]) ?>
					</div>
				</div>
				<div class="img"<? if( $_item->img ) { ?> style="background-image: url(/resources/people/<?= $_item->id ?>-block.jpg?v=<?= $_item->version ?>);"<? } ?>></div>
				<div class="info">
					<div class="info_inner">
						<h2><?= $_item->name ?></h2>
						<p><?= $_item->organization_name ?></p>
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
	<ul class="pagination">
		<?php echo $this->Paginator->prev('&laquo;', ['escape' => false]); ?>
		<?php echo $this->Paginator->numbers(); ?>
		<?php echo $this->Paginator->next('&raquo;', ['escape' => false]); ?>
	</ul>
</div>