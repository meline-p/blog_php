<?php $title = "Admin - Utilisateur désactivé" ?>

<?php ob_start(); ?>

<h1>Utilisateur désactivé</h1>
<br>
<a class="btn btn-secondary btn-sm" href="../admin_users_list.php">Revenir aux utilisateurs</a>

<?php $content = ob_get_clean(); ?>

<?php require('../../templates/admin/parts/admin_layout.php') ?>