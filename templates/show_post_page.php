<?php $title = htmlspecialchars($post->title); ?>

<?php ob_start(); ?>

<div id="content" class="container with-60">

	<div>
		<a class="btn btn-dark space" href="/publications">Retour à la liste des posts</a>
		<br>
		<br>
		<h3><?= htmlspecialchars($post->title); ?></h3>
		<p><i>
				<?php if($post->updated_at === null):?>
				publié le <?= date_format(date_create($post->created_at), "d/m/Y à H:i");?>
				<?php else:?>
				mis à jour le <?= date_format(date_create($post->updated_at), "d/m/Y à H:i");?>
				<?php endif; ?>
			</i></p>
		<p><?= nl2br(htmlspecialchars($post->content)); ?></p>
	</div>

	<div class="col-lg-12">
		<?php if(count($comments) > 0): ?>
		<hr>
		<h4>Commentaires</h4>
		<br>
		<div class="card-deck row">
			<?php foreach($comments as $comment): ?>
			<div class="mb-3 col-lg-6">
				<div class="card ">
					<div class="card-body">
						<h6 class="card-subtitle mb-2"><?= htmlspecialchars($comment->user_surname); ?></h6>
						<h6 class="card-subtitle mb-2 text-muted" style="font-weight:normal;"><i>
								publié le <?= date_format(date_create($comment->created_at), "d/m/Y à H:i"); ?>
							</i></h6>
						<p class="card-text"><?= nl2br(htmlspecialchars($comment->content)); ?></p>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
		<hr>
		<div>
			<?php include_once('components/comments_form_page.php'); ?>
		</div>

	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('parts/layout.php') ?>