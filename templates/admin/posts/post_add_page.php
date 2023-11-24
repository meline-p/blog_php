<?php $title = "Admin - Post ajouté" ?>

<?php ob_start(); ?>

<h1>Post ajouté</h1>

<div class="card">
	<div class="card-body">
		<h5 class="card-title"><?= $title ?></h5>
		<p class="card-text"><b>Chapo</b> : <?= $chapo ?></p>
		<p class="card-text"><b>Contenu</b> : <?= strip_tags($content); ?></p>
		<p class="card-text"><b>Auteur</b> : <?= $user_surname ?></p>
		<p class="card-text"><b>Publié</b> : <?= $is_published === 1 ? 'Oui' : 'Non' ?></p>
	</div>
</div>

<br>
<a class="btn btn-secondary btn-sm" href="/admin/publications">Revenir aux posts</a>


<?php $content = ob_get_clean(); ?>

<?php require('../templates/admin/parts/admin_layout.php') ?>