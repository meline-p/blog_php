<?php $title = "Bienvenue !" ?>

<?php ob_start(); ?>

<div id="content" class="container">
	<h3>Méline Pischedda</h3>
	<img>
	<p>Je suis une phrase d'accroche</p>

	<?php include_once(__DIR__ . '/../templates/components/contact_form_page.php') ?>

</div>
<?php $content = ob_get_clean(); ?>

<?php
require_once(__DIR__ . '/../templates/parts/layout.php');
?>