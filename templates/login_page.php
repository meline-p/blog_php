<?php $title = "Se Connecter" ?>

<?php ob_start(); ?>

<div id="content" class="container">

	<?php if(!isset($_SESSION['LOGGED_USER'])): ?>

	<?php if($errorMessage !== ''): ?>
	<div class="alert alert-danger">
		<?= $errorMessage ?>
	</div>
	<?php endif; ?>

	<h3>Se connecter</h3>
	<form action="/connexion" method="POST">
		<div class="mb-3">
			<label for="email" class="form-label">Email</label>
			<input type="email" class="form-control" id="email" name="email" aria-describedby="email-help">
		</div>
		<div class="mb-3">
			<label for="password" class="form-label">Mot de passe</label>
			<input type="password" class="form-control" id="password" name="password" aria-describedby="password-help">
		</div>
		<button type="submit" class="btn btn-primary">Se connecter</button>
	</form>
	<hr>
	<a class="btn btn-dark" href="/inscription">S'inscrire</a>

	<?php else: ?>
	<div class="alert alert-success" role="alert">
		Bonjour <strong><?= $_SESSION['LOGGED_USER']; ?></strong> et bienvenue sur le site !
	</div>
	<?php endif; ?>

</div>

<?php $content = ob_get_clean(); ?>

<?php require('parts/layout.php') ?>