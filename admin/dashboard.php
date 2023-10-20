<?php session_start(); ?>
<?php include_once('../parts/header.php'); ?>

<div class="col-lg-12 row">
    <div class="col-lg-3">
        <?php include_once('parts/sidebar.php'); ?>
    </div>

    <div id="content" class="container col-lg-9">
        <h1>Bienvenue<h1>

        <?php 
            include_once('../php/variables.php');
            include_once('../php/functions.php');
        ?>

        <div class="col-lg-12 row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Posts</h5>
                        <p class="card-text"><?php echo count($posts); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Commentaires</h5>
                        <p class="card-text"><?php echo count($posts); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Utilisateurs</h5>
                        <p class="card-text"><?php echo count($posts); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>


<?php include_once('parts/admin_footer.php'); ?>