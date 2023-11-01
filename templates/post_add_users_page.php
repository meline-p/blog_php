<?php     
    include_once('templates/parts/header_page.php');
    include_once('templates/parts/navbar_page.php'); 
?>

<div id="content" class="container col-lg-9">
    <h1>Bienvenue, <?= $_SESSION['LOGGED_USER'] ?></h1>
</div>


<?php 
    include_once('parts/footer.php');
    include_once('templates/parts/footer_page.php'); 
?>