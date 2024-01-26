<?php $title = "Dashboard" ?>

<?php ob_start(); ?>
<hr>

<h2>Bienvenue, <?php if($_SESSION['user'] && $_SESSION['user']->role_name === 'Administrateur') {
    echo $_SESSION['user']->surname;
} ?>
</h2>

<div class="col-lg-12 row my-4">
	<?php if($nbPendingComments > 0) :?>
	<div class="alert alert-info alert-dismissible fade show" role="alert">
		Vous avez <?= $nbPendingComments ?>
		<?= $nbPendingComments == 1 ? "commentaire" : "commentaires"?> en attente
		<a class="btn btn-light btn-sm" href="/admin/commentaires">Voir</a>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
	<?php endif; ?>

	<div class="col-lg-4">
		<div class="card">
			<div class="card-body text-center">
				<h5 class="card-title">Publications</h5>
				<hr>
				<p class="card-text">Total : <?= $nbPosts ?></p>
				<p class="card-text">Publiées : <?= $nbPublishedPosts ?></p>
				<p class="card-text">Brouillons : <?= $nbDraftPosts ?></p>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="card">
			<div class="card-body text-center">
				<h5 class="card-title">Commentaires</h5>
				<hr>
				<p class="card-text">Total : <?= $nbComments ?></p>
				<p class="card-text">En attente : <?= $nbPendingComments ?></p>
				<p class="card-text">Validés : <?= $nbValidComments ?></p>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="card">
			<div class="card-body text-center">
				<h5 class="card-title">Utilisateurs</h5>
				<hr>
				<p class="card-text">Total : <?= $nbAllUsers ?></p>
				<p class="card-text">Comptes actifs : <?= $nbActiveAccounts ?></p>
				<p class="card-text">Administrateurs : <?= $nbAdmins ?></p>
				<p class="card-text">Utilisateurs : <?= $nbUsers ?></p>
			</div>
		</div>
	</div>
</div>


<?php $content = ob_get_clean(); ?>

<?php require('parts/admin_layout.php') ?>