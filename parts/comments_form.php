<?php 
    include_once('sql/pdo.php');
?>

<h5>Laisser un commentaire</h5>
<?php if(isset($_SESSION['LOGGED_USER'])): ?>
<form action="parts/post_add_comments.php?id=<?= $post['id'] ?>" method="POST">
    <div class="mb-3">
        <label for="comment" class="form-label">Votre commentaire</label>
        <textarea class="form-control" placeholder="Votre commentaire" id="comment" name="comment"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>
<?php else: ?>
    <div class="jumbotron">
        <p class="lead">Veuillez vous connecter pour laisser un commentaire</p>
        <a class="btn btn-primary btn-sm" href="login.php" role="button">Se connecter</a>
    </div>
<?php endif; ?>