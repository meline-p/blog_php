<?php session_start(); ?>
<?php $title = "Admin - Dashboard" ?>

<?php ob_start(); ?>

<h1>Bienvenue, <?php if(isset($_SESSION['IS_ADMIN'])) {
    echo $_SESSION['LOGGED_ADMIN'];
} ?></h1>

<div class="col-lg-12 row">
	<div class="col-lg-4">
		<div class="card">
			<div class="card-body text-center">
				<h5 class="card-title">Posts</h5>
				<p class="card-text"></p>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="card">
			<div class="card-body text-center">
				<h5 class="card-title">Commentaires</h5>
				<p class="card-text"></p>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="card">
			<div class="card-body text-center">
				<h5 class="card-title">Utilisateurs</h5>
				<p class="card-text"></p>
			</div>
		</div>
	</div>
</div>


<?php $content = ob_get_clean(); ?>

<?php require('parts/admin_layout.php') ?>