<?php $title = "S'inscire" ?>

<?php ob_start(); ?>

<div id="content" class="container">

	<h3>S'inscrire</h3>
	<form action="post_add_users.php" method="POST">
		<div class="mb-3">
			<label for="surname" class="form-label">Pseudo</label>
			<input type="surname" class="form-control" id="surname" name="surname" aria-describedby="surname-help">
		</div>
		<div class="mb-3">
			<label for="first_name" class="form-label">Prénom</label>
			<input type="first_name" class="form-control" id="first_name" name="first_name" aria-describedby="surname-help">
		</div>
		<div class="mb-3">
			<label for="last_name" class="form-label">Nom</label>
			<input type="last_name" class="form-control" id="last_name" name="last_name" aria-describedby="surname-help">
		</div>
		<div class="mb-3">
			<label for="email" class="form-label">Email</label>
			<input type="email" class="form-control" id="email" name="email" aria-describedby="email-help">
		</div>
		<div class="mb-3">
			<label for="password" class="form-label">Mot de passe</label>
			<input type="password" class="form-control" id="password" name="password" aria-describedby="password-help">
		</div>
		<button type="submit" class="btn btn-primary">S'inscrire</button>
	</form>

</div>


<?php $content = ob_get_clean(); ?>

<?php require('parts/layout.php') ?>