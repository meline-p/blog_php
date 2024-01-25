
<?php $title = "Admin - Post restauré" ?>

<?php ob_start(); ?>

<h1>Post restauré</h1>
<br>
<a class="btn btn-secondary btn-sm" href="../admin_posts_list.php">Revenir aux posts</a>

<?php $content = ob_get_clean(); ?>

<?php require('../../templates/admin/parts/admin_layout.php') ?>