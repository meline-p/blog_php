<?php $title = "Admin - Restaurer le post" ?>

<?php ob_start(); ?>

<h1>Restaurer le post</h1>

<form action="post_restore.php?id=<?= $allPost['id']; ?>" method="post">
	<label>Voulez-vous restaurer le post suivant ?</label>
	<br><br>

	<div class="col-lg-12 row">

		<div class="card">
			<div class="card-body">
				<h5 class="card-title"><?= $allPost['title'] ?></h5>
				<p class="card-text"><b>Chapo</b> : <?= $allPost['chapo'] ?></p>
				<p class="card-text"><b>Contenu</b> : <?= strip_tags($allPost['content']); ?></p>
				<p class="card-text"><b>Auteur</b> : <?= $allPost['user_id'] ?></p>
			</div>
		</div>
	</div>

	<br>
	<button type="submit" class="btn btn-success btn-sm">Restaurer le post</button>
	<a class="btn btn-secondary btn-sm" href="../admin_posts_list.php">Annuler</a>

</form>

<?php $content = ob_get_clean(); ?>

<?php require('../templates/admin/parts/admin_layout.php') ?>