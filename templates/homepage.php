<?php     
    include_once('templates/parts/header_page.php');
    include_once('templates/parts/navbar_page.php'); 
?>

<div id="content" class="container">
    <h1>Bienvenue, <?php if(isset($_SESSION['LOGGED_USER'])) echo $_SESSION['LOGGED_USER']; ?></h1>

    <h3>Méline Pischedda</h3>
    <img>
    <p>Je suis une phrase d'accroche</p>

    <?php include_once('templates/components/contact_form_page.php') ?>

</div>
<?php 
    include_once('parts/footer.php');
    include_once('templates/parts/footer_page.php'); 
?>