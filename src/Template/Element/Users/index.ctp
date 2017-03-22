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
				<div class="img" style="background-image: url(<? if( $_item->img ) { ?>/resources/events/<?= $_item->id ?>-block.jpg?v=<?= $_item->version ?><? } else { ?>/img/people-default.svg<? } ?>);"></div>
				<div class="info">
					<h2><?= $_item->name ?></h2>
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