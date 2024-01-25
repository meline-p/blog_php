<?php $title = "Admin - Commentaire validé" ?>

<?php ob_start(); ?>

<h1>Commentaire validé</h1>
<br>
<a class="btn btn-secondary btn-sm" href="../admin_comments_list.php">Revenir aux commentaires</a>


<?php $content = ob_get_clean(); ?>

<?php require('../../templates/admin/parts/admin_layout.php') ?>