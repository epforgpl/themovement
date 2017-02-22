<? foreach($followers as $f) {?>
	<a class="row" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $f->user->slug]) ?>" data-id="<?= $f->id ?>">
		<div class="col-md-12">
			<?= $this->Layout->userAvatar($f->user, ['gender' => true]) ?>
			<p class="name"><?= $f->user->name ?></p>
			<p class="desc"><?= $f->user->organization_name ?></p>
		</div>
	</a>					
<? } ?>