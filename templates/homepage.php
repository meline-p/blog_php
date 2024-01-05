<?php $title = "Bienvenue !" ?>

<?php ob_start(); ?>

<?php while($alert = \App\lib\AlertService::get()): ?>
<div class="alert alert-<?= $alert['type'] ?> alert-dismissible fade show" role="alert">
	<?= $alert['message'] ?>
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endwhile; ?>

<div class="hero">
	<img class="img" src="/img/logo.png">

	<div class="content text-center">
		<a class="btn btn-dark" href="/publications">Voir les publications</a>
	</div>

</div>

<div class="about">
	<div class="row col-lg-12">
		<div class="col-lg-4 col-md-4 text-center">
			<img class="img" src="/img/profil_picture.jpg">
		</div>
		<div class="col-lg-8 col-md-4">
			<h3>Hello World <i class="fa-solid fa-mug-hot"></i></h3>
			<p>Dev web la journée, super-héroïne du code la nuit. Entre deux tasses de thé, je métamorphose les bugs en licornes et les lignes de code en blagues geek. Prête à apporter une touche
				magique à chaque projet, que ce soit en codant ou en dégustant une tasse de thé!</p>
			<a class="btn btn-outline-dark btn-sm" href="#">Télécharger le CV</a>
		</div>
	</div>
</div>

<div class="social-media text-center">
	<h3>Retrouvez-moi sur les réseaux sociaux</h3>
	<div class="icons">
		<a href="#"><i class="fa-brands fa-github"></i></a>
		<a href="#"><i class="fa-brands fa-linkedin"></i></a>
		<a href="#"><i class="fa-brands fa-instagram"></i></a>
	</div>
</div>


<div class="contact">
	<div class=" col-lg-12 col-md-12 row">
		<h3 class="text-center">Restons en contact</h3>
		<div class="infos col-lg-6 col-md-6">
			<p><i class="fa-solid fa-paper-plane"></i> meline.pischedda@gmail.com</p>
			<p><i class="fa-solid fa-phone"></i> 06 23 36 90 92</p>
			<p><i class="fa-solid fa-location-dot"></i> Aix-en-Provence</p>
		</div>
		<div class="col-lg-6 col-md-6">
			<?php include_once(__DIR__ . '/../templates/components/contact_form_page.php') ?>
		</div>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php
require_once(__DIR__ . '/../templates/parts/layout.php');
?>