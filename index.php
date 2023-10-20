<?php session_start(); ?>
<?php include_once('parts/header.php'); ?>
<?php include_once('parts/navbar.php'); ?>

<?php
include_once('php/variables.php');
include_once('php/functions.php');

$email = "";
$surname = "";
$loggedIn = false;

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

    if ($loggedIn) {
        $email = $loggedUser['email'];
        $surname = $loggedUser['surname'];
    }
}
?>

<div id="content" class="container">
    <h1>Bienvenue, <?php if(isset($_SESSION['LOGGED_USER'])) echo $_SESSION['LOGGED_USER']; ?></h1>

    <h3>Méline Pischedda</h3>
    <img>
    <p>Je suis une phrase d'accroche</p>

    <?php include_once('parts/contact.php') ?>

</div>

<?php include_once('parts/footer.php') ?>
