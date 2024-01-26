<?php $title = "Supprimer un post" ?>

<?php ob_start(); ?>

<form action="/admin/publication/supprimer/confirmation/<?= $post->id; ?>" method="post">
	<label>Voulez-vous vraiment supprimer le post suivant ?</label>
	<br><br>

	<div class="col-lg-12 row">

		<div class="card">
			<div class="card-body">
				<h5 class="card-title"><?= strip_tags($post->title) ?></h5>
				<p class="card-text"><b>Chapo</b> : <?= strip_tags($post->chapo) ?></p>
				<p class="card-text"><b>Contenu</b> : <?= strip_tags(($post->content)); ?></p>
				<p class="card-text"><b>Auteur</b> : <?= $post->user_surname ?? '';  ?></p>
			</div>
		</div>
	</div>

	<br>
	<input type="hidden" name="title" value="<?= $post->title ?>">
	<button type="submit" class="btn btn-danger btn-sm">Supprimer le post</button>
	<a class="btn btn-secondary btn-sm" href="/admin/publications">Annuler</a>

</form>

<?php $content = ob_get_clean(); ?>

<?php require('../templates/admin/parts/admin_layout.php') ?>