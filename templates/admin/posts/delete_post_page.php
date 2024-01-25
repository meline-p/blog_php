<?php include_once('../../templates/parts/header_page.php'); ?>

<div class="col-lg-12 row">

    <div id="content" class="container col-lg-9">
    <h1>Supprimer le post</h1>

    <form action="post_delete.php?id=<?= $post['id']; ?>" method="post">
        <label>Voulez-vous vraiment supprimer le post suivant ?</label>
        <br><br>

        <div class="col-lg-12 row">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $post['title'] ?></h5>
                    <p class="card-text"><b>Chapo</b> : <?= $post['chapo'] ?></p>
                    <p class="card-text"><b>Contenu</b> : <?= strip_tags($post['content']); ?></p>
                    <p class="card-text"><b>Auteur</b> : <?= $user_surname ?></p>
                </div>
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-danger btn-sm">Supprimer le post</button>
        <a class="btn btn-secondary btn-sm" href="../admin_posts_list.php">Annuler</a>

    </form>
</div>
