<?php include_once('../../templates/parts/header_page.php'); ?>

<div class="col-lg-12 row">

    <div id="content" class="container col-lg-9">
    <h1>Effacer le commentaire</h1>

    <form action="post_delete_comments.php?id=<?= $allComment['id']; ?>" method="post">
        <label>Voulez-vous effacer le commentaire suivant ?</label>
        <br><br>

        <div class="col-lg-12 row">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Commentaire</h5>
                    <p class="card-text"><b>Contenu</b> : <?= $allComment['content'] ?></p>
                    <p class="card-text"><b>Auteur du commentaire</b> : <?= $allComment['user_id'] ?></p>
                    <p class="card-text"><b>Post</b> : <?= $allComment['post_id'] ?></p>
                </div>
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-danger btn-sm">Effacer le commentaire</button>
        <a class="btn btn-secondary btn-sm" href="../admin_comments_list.php">Annuler</a>

    </form>
</div>
