<?php $title = "Ajouter un utilisateur" ?>

<?php ob_start(); ?>

<form action="/admin/utilisateur/ajouter/confirmation" method="post">
	<div class="row">
		<div class="row col-lg-6">
			<div class="form-group">
				<label for="first_name">Prénom</label>
				<input value="<?= $data['first_name'] ?? "" ?>" type="text" required type="text"
					id="first_name" name="first_name" class="form-control">
			</div>
			<br>
			<div class="form-group">
				<label for="last_name">Nom</label>
				<input value="<?= $data['last_name'] ?? "" ?>" type="text" required type="text"
					id="last_name" name="last_name" class="form-control">
			</div>
			<br>
			<div class="form-group">
				<label for="surname">Pseudo</label>
				<input value="<?= $data['surname'] ?? "" ?>" type="text" required id="surname" name="surname"
					class="form-control">
			</div>
		</div>
		<div class="row col-lg-6">
			<br>
			<div class="form-group">
				<label for="email">Email</label>
				<input value="<?= $data['email'] ?? "" ?>" type="email" required id="email" name="email"
					class="form-control">
			</div>
			<br>
			<div class="form-group col-lg-6">
				<label for="password">Mot de passe</label>
				<input type="password" required id="password" name="password" class="form-control">
			</div>
			<br>
			<div class="form-group col-lg-6">
				<label for="confirm_password">Confirmer le mot de passe</label>
				<input type="password" required id="confirm_password" name="confirm_password" class="form-control">
			</div>
			<br>
			<div class="form-group">
				<label for="role_id">Role :</label>
				<select name="role_id" id="role_id" class="form-select">
					<?php foreach ($roles as $role): ?>
					<option value="<?= $role->id ?>" <?= $data['role_id'] === $role->id ? 'selected' : ''; ?>>
						<?= $role->name ?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>
			<br>
		</div>
	</div>
	<br>

	<button type="submit" class="btn btn-success btn-sm">Ajouter un utilisateur</button>
	<a class="btn btn-secondary btn-sm" href="/admin/utilisateurs">Annuler</a>

</form>

<?php $content = ob_get_clean(); ?>

<?php require('../templates/admin/parts/admin_layout.php') ?>