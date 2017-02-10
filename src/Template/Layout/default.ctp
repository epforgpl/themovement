<?php

use Cake\Core\Configure;

/**
 * Default `html` block.
 */
if (!$this->fetch('html')) {
    $this->start('html');
    printf('<html lang="%s" class="no-js">', Configure::read('App.language'));
    $this->end();
}

/**
 * Default `title` block.
 */
if (!$this->fetch('title')) {
    $this->start('title');
    echo Configure::read('App.title');
    $this->end();
}

/**
 * Default `footer` block.
 */
if (!$this->fetch('tb_footer')) {
    $this->start('tb_footer');
    printf('&copy;%s %s', date('Y'), Configure::read('App.title'));
    $this->end();
}

/**
 * Default `body` block.
 */
$this->prepend('tb_body_attrs', ' class="' . implode(' ', [$this->request->controller, $this->request->action]) . '" ');
if (!$this->fetch('tb_body_start')) {
    $this->start('tb_body_start');
    echo '<body' . $this->fetch('tb_body_attrs') . '>';
    $this->end();
}
/**
 * Default `flash` block.
 */
if (!$this->fetch('tb_flash')) {
    $this->start('tb_flash');
    if (isset($this->Flash))
        echo $this->Flash->render();
    $this->end();
}
if (!$this->fetch('tb_body_end')) {
    $this->start('tb_body_end');
    echo '</body>';
    $this->end();
}

/**
 * Prepend `meta` block with `author` and `favicon`.
 */
$this->prepend('meta', $this->Html->meta('author', null, ['name' => 'author', 'content' => Configure::read('App.author')]));
$this->prepend('meta', $this->Html->meta('favicon.ico', '/favicon.ico', ['type' => 'icon']));

/**
 * Prepend `css` block with Bootstrap stylesheets and append
 * the `$html5Shim`.
 */
$html5Shim =
<<<HTML
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
HTML;

$this->append('css', $html5Shim);

/**
 * Prepend `script` block with jQuery and Bootstrap scripts
 */
$this->prepend('script', $this->Html->script(['jquery/jquery.min', 'jquery.sticky', 'bootstrap/bootstrap.min', 'engine']));

?>
<!DOCTYPE html>

<?= $this->fetch('html') ?>

    <head>
        <?= $this->Html->charset() ?>
        <title><?= $this->fetch('title') ?></title>
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->Less->less('less/base.less') ?>
        <? if( isset($this->request->query['invert']) ) {
	        echo $this->Less->less('less/base-invert.less');
        } ?>
        <?= $this->Less->less('less/icomoon.less') ?>
        <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
		<link rel="icon" type="image/png" href="/favicon/favicon-32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="/favicon/favicon-16x16.png" sizes="16x16">
		<link rel="manifest" href="/favicon/manifest.json">
		<link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="theme-color" content="#ffffff">
    </head>

    <?php
    echo $this->fetch('tb_body_start');
    echo $this->element('header');
    echo $this->fetch('tb_flash');
    echo $this->fetch('content');
    echo $this->element('footer');
    echo $this->fetch('script');
    echo $this->fetch('tb_body_end');
    ?>

</html>