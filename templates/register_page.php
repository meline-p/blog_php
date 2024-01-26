<?php $title = "S'inscire" ?>

<?php ob_start(); ?>

<div id="content" class="container with-60">

	<h3>S'inscrire</h3>
	<form action="/inscription" method="POST">
		<div class="mb-3">
			<label for="surname" class="form-label">Pseudo</label>
			<input required
				value="<?= isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : ''; ?>"
				type="surname" class="form-control" id="surname" name="surname" aria-describedby="surname-help">
		</div>
		<div class="mb-3">
			<label for="first_name" class="form-label">Prénom</label>
			<input required
				value="<?= isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>"
				type="first_name" class="form-control" id="first_name" name="first_name" aria-describedby="surname-help">
		</div>
		<div class="mb-3">
			<label for="last_name" class="form-label">Nom</label>
			<input
				value="<?= isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>"
				required type="last_name" class="form-control" id="last_name" name="last_name" aria-describedby="surname-help">
		</div>
		<div class="mb-3">
			<label for="email" class="form-label">Email</label>
			<input required
				value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
				type="email" class="form-control" id="email" name="email" aria-describedby="email-help">
		</div>
		<div class="mb-3">
			<label for="password" class="form-label">Mot de passe</label>
			<input required type="password" class="form-control" id="password" name="password" aria-describedby="password-help">
		</div>
		<input required type="hidden" class="form-control" id="role_id" name="role_id" aria-describedby="role-help">
		<button type="submit" class="btn btn-warning">S'inscrire</button>
	</form>
	<hr>
	<a class="btn btn-dark" href="/connexion">Se connecter</a>

</div>


<?php $content = ob_get_clean(); ?>

<?php require('parts/layout.php') ?>