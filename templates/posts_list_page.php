<?php session_start(); ?>
<?php $title = "Liste des posts" ?>

<?php ob_start(); ?>

<div id="content" class="container">

	<h1>Affichage des posts</h1>

	<div class="card-deck">
		<?php foreach ($posts as $post): ?>

		<div class="card mb-3">
			<div class="card-body">
				<h5 class="card-title"><?= htmlspecialchars($post['title']); ?></h5>
				<h6 class="card-subtitle mb-2 text-muted" style="font-weight:normal;"><i>
						<?php if($post['updated_at'] === null):?>
						publié le <?= date_format(date_create($post['created_at']), "d/m/Y à H:i");?>
						<?php else:?>
						mis à jour le <?= date_format(date_create($post['updated_at']), "d/m/Y à H:i");?>
						<?php endif; ?>
					</i></h6>
				<p class="card-text"><i><?= htmlspecialchars($post['chapo']); ?></i></p>
				<p class="card-text">
					<?= (strlen($post['content']) > 300) ? htmlspecialchars(substr($post['content'], 0, 300)) . '...' : htmlspecialchars($post['content']); ?>
				</p>
				<a class="btn btn-outline-dark btn-sm" href="/publication/<?= $post['id']; ?>">voir la suite</a>
			</div>
		</div>

		<?php endforeach; ?>
	</div>

</div>

<?php $content = ob_get_clean(); ?>

<?php require('parts/layout.php') ?>