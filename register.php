<?php session_start(); ?>
<?php include_once('parts/header.php'); ?>
<?php include_once('parts/navbar.php'); ?>

<div id="content" class="container">

<h3>S'inscrire</h3>
<form action="index.php" method="POST">
<div class="mb-3">
        <label for="surname" class="form-label">Pseudo</label>
        <input type="surname" class="form-control" id="surname" name="surname" aria-describedby="surname-help">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" aria-describedby="password-help">
    </div>
    <button type="submit" class="btn btn-primary">S'inscrire</button>
</form>

</div>

<?php include_once('parts/footer.php'); ?>