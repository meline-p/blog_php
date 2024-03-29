<?php $title = "Modifier un post" ?>

<?php ob_start(); ?>

<form action="/admin/publication/modifier/confirmation/<?= $post->id; ?>" method="post">
	<div class="row">
		<div class="col-lg-8">
			<div class="form-group">
				<label for="title">Titre</label>
				<input required type="text" id="title" name="title" class="form-control" value="<?= $post->title ?>">
			</div>
			<br>
			<div class="form-group">
				<label for="chapo">Chapô</label>
				<input type="text" id="chapo" name="chapo" class="form-control" value="<?= $post->chapo ?>">
			</div>
			<br>
			<div class="form-group">
				<label for="content">Contenu</label>
				<textarea required id="content" name="content" rows="15" class="form-control"><?= $post->content ?></textarea>
			</div>
		</div>
		<div class="col-lg-4">

			<div class="form-group">
				<label for="user_id">Auteur</label>
				<select id="user_id" name="user_id" class="form-control">
					<?php foreach($admins as $admin): ?>
					<option value="<?= $admin->id ?>" <?= ($admin->id === $post->user_id) ? 'selected' : ''; ?>><?= $admin->first_name.' '.$admin->last_name ?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>
			<br>
			<div class="form-group">
				<label for="is_published">Publié</label>
				<input type="checkbox" id="is_published" name="is_published" value="1"
					<?= $post->is_published ? 'checked' : ''?>
				>
			</div>
		</div>
	</div>
	<br>
	<button type="submit" class="btn btn-primary btn-sm">Modifier le post</button>
	<a class="btn btn-secondary btn-sm" href="/admin/publications">Annuler</a>

</form>

<?php $content = ob_get_clean(); ?>

<?php require('../templates/admin/parts/admin_layout.php') ?>