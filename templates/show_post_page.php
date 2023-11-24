<?php session_start(); ?>
<?php $title = htmlspecialchars($post['title']); ?>

<?php ob_start(); ?>

<div id="content" class="container">

	<?php
        if($post) {
            ?>
	<div>
		<h3><?= htmlspecialchars($post['title']); ?></h3>
		<p><i>
				<?php if($post['updated_at'] === null):?>
				publié le <?= date_format(date_create($post['created_at']), "d/m/Y à H:i");?>
				<?php else:?>
				mis à jour le <?= date_format(date_create($post['updated_at']), "d/m/Y à H:i");?>
				<?php endif; ?>
			</i></p>
		<p><?= nl2br(htmlspecialchars($post['content'])); ?></p>
		<a class="btn btn-dark" href="/publications">Retour à la liste des posts</a>
	</div>

	<?php
        } else {
            echo "Aucun post trouvé pour cet ID.";
        }
?>
	<br>
	<hr>

	<h4>Commentaires</h4>
	<br>

	<div class="card-deck">
		<?php foreach($comments as $comment): ?>
		<div class="card mb-3">
			<div class="card-body">
				<h6 class="card-subtitle mb-2"><?= htmlspecialchars($comment['user_surname']); ?></h6>
				<h6 class="card-subtitle mb-2 text-muted" style="font-weight:normal;"><i>
						publié le <?= date_format(date_create($comment['created_at']), "d/m/Y à H:i"); ?>
					</i></h6>
				<p class="card-text"><?= nl2br(htmlspecialchars($comment['content'])); ?></p>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<hr>
	<div>
		<?php include_once('components/comments_form_page.php'); ?>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('parts/layout.php') ?>