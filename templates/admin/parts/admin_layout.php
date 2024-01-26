<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title ?></title>
	<link rel="stylesheet" type="text/css" href="/styles.css">
	<link rel="icon" href="favicon.ico" type="image/png">
	<link rel="shortcut icon" href="favicon.ico" type="image/png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
		crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
		integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="d-flex flex-column min-vh-100">
	<div class="col-lg-12 row" style="margin: 0;">
		<div class="col-xl-2 col-lg-3 col-md-3 col-sm-4" style="margin: 0; padding:0;">
			<?php include_once('sidebar_page.php') ?>
		</div>
		<div id="content" class="container admin col-xl-10 col-lg-9 col-md-9 col-sm-8" style="margin: 0; padding:10px;">
			<h1 style="margin: 10px; padding:10px;"><?= $title ?></h1>
			<?php while($alert = \App\lib\AlertService::get()): ?>
			<div class="alert alert-<?= $alert['type'] ?> alert-dismissible fade show" role="alert">
				<?= $alert['message'] ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			<?php endwhile; ?>
			<div style="margin: 10px; padding:10px;"><?= $content ?></div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
		crossorigin="anonymous"></script>
</body>

</html>