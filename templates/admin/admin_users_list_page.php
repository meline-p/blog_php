error_reporting(E_ALL);
ini_set('display_errors', 1);?>
<?php $title = "Admin - Utilisateurs" ?>

<?php ob_start(); ?>

<h1>Utilisateurs</h1>

<div class="col-lg-12 row">
	<div>Filter</div>
	<table class="table text-center">
		<thead>
			<tr>
				<th scope="col">Rôle</th>
				<th scope="col">Pseudo</th>
				<th scope="col">Nom</th>
				<th scope="col">Prénom</th>
				<th scope="col">Email</th>
				<th scope="col">Date de Création</th>
				<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users as $user) : ?>
			<tr>
				<td>
					<?php
                            $userRoleName = $user->role_name;
			    echo $userRoleName;
			    ?>
				</td>
				<td><?= $user->surname ?></td>
				<td><?= $user->last_name ?></td>
				<td><?= $user->first_name ?></td>
				<td><?= $user->email ?></td>
				<td><?= $user->created_at ?></td>
				<td>
					<?php if ($user->deleted_at) : ?>
					<a href="/admin/utilisateur/restaurer/<?= $user->id ?>" class="btn btn-secondary btn-sm">
						<i class="fa-solid fa-rotate-left"></i>
					</a>
					<?php else : ?>
					<a href="/admin/utilisateur/supprimer/<?= $user->id ?>" class="btn btn-danger btn-sm">
						<i class="fa-solid fa-trash"></i>
					</a>
					<?php endif; ?>
				</td>
				<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('parts/admin_layout.php') ?>