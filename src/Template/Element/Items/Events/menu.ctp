<? if( $menu ) {?>
<div class="row">
	<div class="col-md-12">
		
		<ul class="nav nav-tabs">
			<? foreach( $menu as $m ) {?>
			<li<? if( $m['href'] == $menu_active ) {?> class="active"<? } ?>><a href="<?= $item->getUrl($m['href']) ?>"><?= $m['label'] ?></a></li>
			<? } ?>	
		</ul>
		
	</div>
</div>
<? } ?>