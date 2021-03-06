<?
	echo $this->Less->less('less/items.less');
?>

<header>
	<h1>Topics</h1>
</header>

<div class="items">
	<div class="row">
	<?
		foreach( $items as $item ) {
	?>
		<div class="col-md-4 col-sm-6 col-xs-12">
			<a href="<?= $item->getUrl() ?>" class="block tm_item">
				<?= $this->Layout->calendar( $item ); ?>
				<div class="img" style="background-image: url(<? if( $item->img ) { ?>/resources/topics/<?= $item->id ?>-block.jpg?v=<?= $item->version ?><? } else { ?>/img/topics-default.svg<? } ?>);"></div>
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