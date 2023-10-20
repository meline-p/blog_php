<h3>Formulaire de contact</h3>
<form action="submit_contact.php" method="POST">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help">
    </div>
    <div class="mb-3">
        <label for="message" class="form-label">Votre message</label>
        <textarea class="form-control" placeholder="Votre message" id="message" name="message"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>