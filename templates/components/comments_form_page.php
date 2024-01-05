<h5>Laisser un commentaire</h5>
<div class="comment">
	<?php if(isset($_SESSION['user'])): ?>
	<form action="/publication/<?= $post->id ?>/commenter" method="POST">
		<div class="mb-3">
			<label for="comment" class="form-label">Votre commentaire</label>
			<textarea class="form-control" placeholder="Votre commentaire" id="comment" name="comment"></textarea>
		</div>
		<button type="submit" class="btn btn-warning space">Envoyer</button>
	</form>
	<?php else: ?>
	<div class="jumbotron">
		<p class="lead">Veuillez vous connecter pour laisser un commentaire</p>
		<a class="btn btn-warning btn-sm space" href="/connexion" role="button">Se connecter</a>
	</div>
	<?php endif; ?>
</div>