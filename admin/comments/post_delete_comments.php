<?php session_start(); ?>
<?php include_once('../../parts/header.php'); ?>

<?php 
    include_once('../../php/functions.php');
    include_once('../../sql/pdo.php');

if (isset($_GET['id'])) {
    $commentId = $_GET['id'];
} else {
    echo "L'ID n'a pas été transmis dans l'URL.";
    return;
}

$commentId = $_GET['id'];

$deleteComment = $db->prepare('UPDATE comments 
SET is_enabled = :is_enabled
WHERE id = :id ');

$is_enabled = false;

$deleteComment->execute([
    'id' => $commentId,
    'is_enabled' => $is_enabled,
]);
?>

<div class="col-lg-12 row">
    <div class="col-lg-3">
        <?php include_once('../parts/sidebar.php'); ?>
    </div>

    <div id="content" class="container col-lg-9">
        <h1>Commentaire effacé</h1>
        <br>
        <a class="btn btn-secondary btn-sm" href="../admin_comments_list.php">Revenir aux commentaires</a>

    </div>
</div>
        