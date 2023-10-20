<?php session_start(); ?>
<?php include_once('parts/header.php'); ?>
<?php include_once('parts/navbar.php'); ?>

<div id="content" class="container">

<?php if(
     (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
     || (!isset($_POST['message']) || empty($_POST['message']))
    ) 
{
    echo ('Il faut un email et un message pour soumettre le formulaire.');
    return;
}

$email = $_POST['email'];
$message = $_POST['message']
?>

    <h1>Message bien reçu !</h1>
            
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Rappel de vos informations :</h5>
            <p class="card-text"><b>Email</b> : <?php echo ($email); ?></p>
            <p class="card-text"><b>Message</b> : <?php echo strip_tags($message); ?></p>
        </div>
    </div>

</div>

<?php include_once('parts/footer.php'); ?>