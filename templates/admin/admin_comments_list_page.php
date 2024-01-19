<?php $title = "Commentaires" ?>

<?php ob_start(); ?>
<hr>
<div class="col-lg-12 row">
	<table class="table text-center">
		<thead>
			<tr>
				<th scope="col">Commentaire</th>
				<th scope="col">Auteur du commentaire</th>
				<th scope="col">Titre du post</th>
				<th scope="col">Date de création</th>
				<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($comments as $comment) : ?>
			<tr>
				<td class='<?= $comment->is_enabled === null ? "table-active" : '' ?>'>
					<?php if(strlen($comment->content) > 30): ?>
					<?= $comment->content = substr($comment->content, 0, 30) . '...'; ?>
					<?php else: ?>
					<?= $comment->content ?>
					<?php  endif;?>
				</td>
				<td class='<?= $comment->is_enabled === null ? "table-active" : '' ?>'>
					<?= $comment->user_surname ?>
				</td>
				<td class='<?= $comment->is_enabled === null ? "table-active" : '' ?>'>
					<?php $shortTitle = (strlen($comment->post_title) > 30) ? substr($comment->post_title, 0, 30) . '...' : $comment->post_title;?>
					<a target="_blank" style="text-decoration:none;" class="btn btn-outline-dark" type="button"
						href="/publication/<?= $comment->post_id ?>"><?= $shortTitle ?></a>
				</td>
				<td class='<?= $comment->is_enabled === null ? "table-active" : '' ?>'>
					<?= $comment->created_at ?>
				</td>
				<td class='<?= $comment->is_enabled === null ? "table-active" : '' ?>'>
					<?php if ($comment->is_enabled === null) : ?>
					<a href="/admin/commentaire/valider/<?= $comment->id ?>" class="btn btn-success btn-sm">
						<i class="fa-solid fa-check"></i>
					</a>
					<a href="/admin/commentaire/supprimer/<?= $comment->id ?>" class="btn btn-danger btn-sm">
						<i class="fa-solid fa-trash"></i>
					</a>
					<?php elseif (!$comment->is_enabled) : ?>
					<a href="/admin/commentaire/restaurer/<?= $comment->id ?>" class="btn btn-secondary btn-sm">
						<i class="fa-solid fa-rotate-left"></i>
					</a>
					<?php else : ?>
					<a href="/admin/commentaire/supprimer/<?= $comment->id ?>" class="btn btn-danger btn-sm">
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