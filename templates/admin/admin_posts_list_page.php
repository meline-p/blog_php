<?php $title = "Posts" ?>

<?php ob_start(); ?>

<a class="btn btn-warning btn-sm" href="/admin/publication/ajouter"><i class="fa-solid fa-plus"></i> Ajouter un post</a>
<hr>

<div class="col-lg-12 row table-responsive table-container">
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Titre</th>
				<th scope="col">Auteur</th>
				<th scope="col">Publié</th>
				<th scope="col">Date de création</th>
				<th scope="col">Date de Modification</th>
				<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($posts as $post) : ?>
			<tr>
				<td>
					<?php $shortTitle = (strlen($post->title) > 30) ? substr($post->title, 0, 30) . '...' : $post->title;?>
					<?php if (empty($post->deleted_at)) : ?>
					<a style="text-decoration:none;" class="btn btn-outline-dark" type="button" target="_blank"
						href="/publication/<?= $post->id; ?>"><?= $shortTitle ?></a>
					<?php else : ?>
					<span class="text-muted"><?= $shortTitle ?></span>
					<?php endif; ?>

				</td>


				<td class="<?= $post->deleted_at ? 'text-muted' : '' ?>">
					<?= $post->user_surname ?>
				</td>
				<td
					class='<?= $post->deleted_at ? 'text-muted' : ($post->is_published ? 'text-success' : 'text-danger') ?>'>
					<strong><?= $post->is_published ? '✓' : 'X' ?></strong>
				</td>
				<td class="<?= $post->deleted_at ? 'text-muted' : '' ?>">
					<?= $post->created_at ?>
				</td>
				<td class="<?= $post->deleted_at ? 'text-muted' : '' ?>">
					<?= $post->updated_at ? $post->updated_at : '-' ?>
				</td>
				<td>
					<?php if ($post->deleted_at) : ?>
					<a href="/admin/publication/restaurer/<?= $post->id ?>" class="btn btn-secondary btn-sm">
						<i class="fa-solid fa-rotate-left"></i>
					</a>
					<?php else : ?>
					<a href="/admin/publication/modifier/<?= $post->id; ?>" class="btn btn-dark btn-sm">
						<i class="fa-solid fa-pen"></i>
					</a>
					<a href="/admin/publication/supprimer/<?= $post->id; ?>" class="btn btn-danger btn-sm">
						<i class="fa-solid fa-trash"></i>
					</a>
					<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('parts/admin_layout.php') ?>