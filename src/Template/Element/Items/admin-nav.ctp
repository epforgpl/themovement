<ul class="nav nav-pills nav-stacked nav-page">
	<li<? if( $selected=='registrations' ) echo ' class="active"'; ?>><a href="<?= $item->getUrl() . '/registrations' ?>">Registrations</a></li>
	<li<? if( $selected=='coupons' ) echo ' class="active"'; ?>><a href="<?= $item->getUrl() . '/coupons' ?>">Coupons</a></li>
</ul>