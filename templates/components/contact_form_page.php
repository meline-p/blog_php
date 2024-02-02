<form action="/message-envoye" method="POST" accept-charset="UTF-8">
	<input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
	<div class="mb-3">
		<label for="name" class="form-label">Nom</label>
		<input type="name" class="form-control" id="name" name="name">
	</div>
	<div class="mb-3">
		<label for="email" class="form-label">Email</label>
		<input type="email" class="form-control" id="email" name="email" aria-describedby="email-help">
	</div>
	<div class="mb-3">
		<label for="message" class="form-label">Votre message</label>
		<textarea class="form-control" placeholder="Votre message" id="message" name="message"></textarea>
	</div>
	<button type="submit" class="btn btn-dark">Envoyer</button>
</form>