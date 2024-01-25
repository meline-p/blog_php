<?php $title = "Restaurer le commentaire" ?>

<?php ob_start(); ?>

<form action="/admin/commentaire/restaurer/confirmation/<?= $comment->id; ?>" method="post">
    <label>Voulez-vous restaurer le commentaire suivant ?</label>
    <br><br>

    <div class="col-lg-12 row">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Commentaire</h5>
                <p class="card-text"><b>Contenu</b> : <?= $comment->content ?></p>
                <p class="card-text"><b>Auteur du commentaire</b> : <?= $comment->user_surname ?? ''; ?></p>
                <p class="card-text"><b>Titre du Post</b> : <?= $comment->post_title ?? '' ?></p>
                <p class="card-text"><b>Contenu du Post</b>
                    <?php if(strlen($comment->post_content) > 400): ?>
					<?= $comment->post_content = substr($comment->post_content, 0, 400) . '...'; ?>
					<?php else: ?>
					<?= $comment->post_content ?>
					<?php  endif;?>
                </p>
            </div>
        </div>
    </div>

    <br>
    <button type="submit" class="btn btn-success btn-sm">Restaurer le commentaire</button>
    <a class="btn btn-secondary btn-sm" href="admin/commentaires">Annuler</a>

</form>

<?php $content = ob_get_clean(); ?>

<?php require('../templates/admin/parts/admin_layout.php') ?>