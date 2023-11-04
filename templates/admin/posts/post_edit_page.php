<?php $title = "Admin - Post modifié" ?>

<?php ob_start(); ?>

<h1>Post modifié</h1>

<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?= $title ?></h5>
        <p class="card-text"><b>Chapo</b> : <?= $chapo ?></p>
        <p class="card-text"><b>Contenu</b> : <?= strip_tags($content); ?></p>
        <p class="card-text"><b>Auteur</b> : <?= $user_surname ?></p>
        <p class="card-text"><b>Publié</b> : <?= $is_published === 1 ? 'Oui' : 'Non' ?></p>
        <p class="card-text"><b>Mis à jour </b> : <?= $updated_at ?></p>
    </div>
</div>

<br>
<a class="btn btn-secondary btn-sm" href="../admin_posts_list.php">Revenir aux posts</a>

<?php $content = ob_get_clean(); ?>

<?php require('../../templates/admin/parts/admin_layout.php') ?>
