<?php $title = "Admin - Restaurer le commentaire ?" ?>

<?php ob_start(); ?>

<h1>Restaurer le commentaire</h1>

<form action="post_valid_comments.php?id=<?= $allComment['id']; ?>" method="post">
    <label>Voulez-vous restaurer le commentaire suivant ?</label>
    <br><br>

    <div class="col-lg-12 row">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Commentaire</h5>
                <p class="card-text"><b>Contenu</b> : <?= $allComment['content'] ?></p>
                <p class="card-text"><b>Auteur du commentaire</b> : <?= $user_surname ?></p>
                <p class="card-text"><b>Titre du Post</b> : <?= $post_title?></p>
            </div>
        </div>
    </div>

    <br>
    <button type="submit" class="btn btn-success btn-sm">Restaurer le commentaire</button>
    <a class="btn btn-secondary btn-sm" href="../admin_comments_list.php">Annuler</a>

</form>

<?php $content = ob_get_clean(); ?>

<?php require('../../templates/admin/parts/admin_layout.php') ?>