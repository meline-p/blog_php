<?php include_once('parts/header.php'); ?>
<?php include_once('parts/navbar.php'); ?>

<?php

$email = "";
$password = "";

if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
   isset($_POST['password']) && !empty($_POST['password'])) 
{
    $email = $_POST['email'];
    $password = $_POST['password'];
}

?>

<div id="content" class="container">
    <h1>Bienvenue, <?php echo $email; ?></h1>

    <h3>Méline Pischedda</h3>
    <img>
    <p>Je suis une phrase d'accroche</p>

    <?php include_once('contact.php') ?>

</div>

<?php include_once('parts/footer.php') ?>
