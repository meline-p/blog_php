<?php $title = "Votre message a bien été envoyé" ?>

<?php ob_start(); ?>

<div id="content" class="container">

	<?php
    if(
        (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        || (!isset($_POST['message']) || empty($_POST['message']))
    ) {
        echo('Il faut un email et un message pour soumettre le formulaire.');
        return;
    }

    $email = htmlspecialchars($_POST['email']);
$message =  nl2br(htmlspecialchars($_POST['message']));
?>

	<h1>Message bien reçu !</h1>

	<div class="card">
		<div class="card-body">
			<h5 class="card-title">Rappel de vos informations :</h5>
			<p class="card-text"><b>Email</b> : <?= $email ?></p>
			<p class="card-text"><b>Message</b> : <?= strip_tags($message); ?></p>
		</div>
	</div>

</div>

<?php $content = ob_get_clean(); ?>

<?php require('parts/layout.php') ?>