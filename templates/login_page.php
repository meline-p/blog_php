<?php $title = "Se Connecter" ?>

<?php ob_start(); ?>

<div id="content" class="container with-60">

	<?php ;
$_SESSION['redirect_back'] = $_SERVER["HTTP_REFERER"];
$redirectBack = parse_url($_SESSION['redirect_back'], PHP_URL_PATH);
?>

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

</div>

<?php $content = ob_get_clean(); ?>

<?php require('parts/layout.php') ?>