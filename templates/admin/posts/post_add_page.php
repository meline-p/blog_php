<?php include_once('../../templates/parts/header_page.php'); ?>

<div class="col-lg-12 row">

    <div id="content" class="container col-lg-9">

        <h1>Post ajouté</h1>
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $title ?></h5>
                    <p class="card-text"><b>Chapo</b> : <?= $chapo ?></p>
                    <p class="card-text"><b>Contenu</b> : <?= strip_tags($content); ?></p>
                    <p class="card-text"><b>Auteur</b> : <?= $user_surname ?></p>
                    <p class="card-text"><b>Publié</b> : <?= $is_published === 1 ? 'Oui' : 'Non' ?></p>
                </div>
            </div>

            <br>
            <a class="btn btn-secondary btn-sm" href="../admin_posts_list.php">Revenir aux posts</a>

    </div>
</div>
        