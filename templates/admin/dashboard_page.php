<?php include_once('../templates/parts/header_page.php'); ?>

<div class="col-lg-12 row">
    <div class="col-lg-3">
        <?php include_once('parts/sidebar_page.php'); ?>
    </div>

    <div id="content" class="container col-lg-9">
        <h1>Bienvenue, <?php if(isset($_SESSION['LOGGED_ADMIN'])) echo $_SESSION['LOGGED_ADMIN']; ?></h1>

        <div class="col-lg-12 row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Posts</h5>
                        <p class="card-text"><?= count($posts); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Commentaires</h5>
                        <p class="card-text"><?= count($comments); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Utilisateurs</h5>
                        <p class="card-text"><?= count($users); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>


<?php include_once('parts/admin_footer_page.php'); ?>