<?php $title = "Liste des posts" ?>

<?php ob_start(); ?>

<div id="content" class="container">

	<h1>Publications</h1>

	<div class="publication row col-lg-12">

		<?php foreach ($posts as $post): ?>
		<div class="col-lg-4">
			<div class="card mb-3">
				<div class="card-body">
					<h5 class="card-title"><?= htmlspecialchars($post->title); ?></h5>
					<h6 class="card-subtitle mb-2 text-muted" style="font-weight:normal;"><i>
							<?php if($post->updated_at === null):?>
							publié le <?= date_format(date_create($post->created_at), "d/m/Y à H:i");?>
							<?php else:?>
							mis à jour le <?= date_format(date_create($post->updated_at), "d/m/Y à H:i");?>
							<?php endif; ?>
						</i></h6>
					<p class="card-text"><?= htmlspecialchars($post->chapo); ?></p>
					<a class="btn btn-warning btn-sm" href="/publication/<?= $post->id; ?>">voir la suite</a>
				</div>
			</div>
		</div>
		<?php endforeach; ?>

	</div>

</div>

<?php $content = ob_get_clean(); ?>

<?php require('parts/layout.php') ?>