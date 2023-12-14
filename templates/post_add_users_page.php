<?php $title = "Bienvenue !" ?>

<?php ob_start(); ?>

<div id="content" class="container col-lg-9">
	<h1>Bienvenue, <?= $_SESSION['user']->surname ?></h1>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('parts/layout.php') ?>