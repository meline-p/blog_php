<?php session_start(); ?>
<?php include_once('parts/header.php'); ?>
<?php include_once('parts/navbar.php'); ?>

<?php

include_once('php/functions.php');
include_once('sql/pdo.php');

// Validation du formulaire
if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
   isset($_POST['password']) && !empty($_POST['password'])) 
{
    $loggedIn = false;
    foreach ($users as $user) {
        if ($user['email'] === $_POST['email'] && $user['password'] === $_POST['password']) {
            $loggedUser = [
                'email' => $user['email'],
                'surname' => $user['surname'],
            ];
            $loggedIn = true;
            $_SESSION['LOGGED_USER'] = $user['surname'];
            break;
        }
    }
    if (!$loggedIn) {
        $errorMessage = 'Les informations envoyées ne permettent pas de vous identifier.';
    }
}
?>

<div id="content" class="container">

<?php if(!isset($_SESSION['LOGGED_USER'])): ?>

    <?php if(isset($errorMessage)): ?>
        <div class="alert alert-danger">
            <?= $errorMessage ?>
        </div>
    <?php endif; ?>

    <h3>Se connecter</h3>
    <form action="login.php" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" aria-describedby="password-help">
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
    <hr>
    <a class="btn btn-dark" href="register.php">S'inscrire</a>

<?php else: ?>
    <div class="alert alert-success" role="alert">
        Bonjour <strong><?= $_SESSION['LOGGED_USER']; ?></strong> et bienvenue sur le site !
    </div>
<?php endif; ?>

</div>

<?php include_once('parts/footer.php'); ?>