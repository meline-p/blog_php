<?php $title = "Dashboard" ?>

<?php ob_start(); ?>
<hr>

<h2>Bienvenue, <?php if($_SESSION['user'] && $_SESSION['user']->role_name === 'Administrateur') {
    echo $_SESSION['user']->surname;
} ?>
</h2>

<div class="col-lg-12 row my-4">
	<div class="col-lg-4">
		<div class="card">
			<div class="card-body text-center">
				<h5 class="card-title">Posts</h5>
				<p class="card-text"><?= $nbPosts ?></p>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="card">
			<div class="card-body text-center">
				<h5 class="card-title">Commentaires</h5>
				<p class="card-text"><?= $nbComments ?></p>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="card">
			<div class="card-body text-center">
				<h5 class="card-title">Utilisateurs</h5>
				<p class="card-text"><?= $nbUsers ?></p>
			</div>
		</div>
	</div>
</div>


<?php $content = ob_get_clean(); ?>

<?php require('parts/admin_layout.php') ?>