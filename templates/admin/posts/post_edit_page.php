<?php $title = "Post modifié" ?>

<?php ob_start(); ?>

<div class="card">
	<div class="card-body">
		<h5 class="card-title" id="title" name="title"><?= $post->title ?></h5>
		<p class="card-text" id="chapo" name="chapo"><b>Chapo</b> : <?= $post->chapo ?></p>
		<p class="card-text" id="content" name="content"><b>Contenu</b> : <?= strip_tags($post->content); ?></p>
		<p class="card-text" id="user_id" name="user_id"><b>Auteur</b> : <?= $post->user_surname ?></p>
		<p class="card-text" id="is_published" name="is_published"><b>Publié</b> :
			<?= $post->is_published === 1 ? 'Oui' : 'Non' ?></p>
		<p class="card-text" id="updated_at" name="updated_at"><b>Mis à jour </b> : <?= $post->updated_at ?></p>
	</div>
</div>

<br>
<a class="btn btn-secondary btn-sm" href="/admin/publications">Revenir aux posts</a>

<?php $content = ob_get_clean(); ?>

<?php require('../templates/admin/parts/admin_layout.php') ?>