<?
	echo $this->Less->less('less/items.less');
?>

<header>
	<h1>Events</h1>
</header>

<div class="items">
	<div class="row">
	<?
		foreach( $items as $item ) {
	?>
		<div class="col-md-4 col-sm-6 col-xs-12">
			<a href="<?= $item->getUrl() ?>" class="block tm_item">
				<?= $this->Layout->calendar( $item ); ?>
				<div class="img" style="background-image: url(/resources/<?= $item->id ?>-block.jpg);"></div>
				<div class="info">
					<h2><?= $item->name ?></h2>
				</div>
			</a>
		</div>
	<?
		}
	?>
	</div>
</div>