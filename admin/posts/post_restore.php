<?php session_start(); ?>
<?php include_once('../../parts/header.php'); ?>

<?php 
    include_once('../../php/functions.php');
    include_once('../../sql/pdo.php');

if (isset($_GET['id'])) {
    $postId = $_GET['id'];

    if (ctype_digit($postId)) {
        $postId = intval($postId); 

        $query = $db->prepare('SELECT * FROM posts WHERE id = :postId');
        $query->execute(['postId' => $postId]);

        if ($query->rowCount() > 0) {
            $allPost = $query->fetch();
        } else {
            echo "Le post avec l'ID $postId n'a pas été trouvé.";
        }
    } else {
        echo "ID non valide.";
    }
}

$postId = $_GET['id'];

$deletePost = $db->prepare('UPDATE posts 
SET deleted_at = :deleted_at, updated_at = :updated_at
WHERE id = :id ');

$currentTime = date('Y-m-d H:i:s');

$deletePost->execute([
    'id' => $postId,
    'deleted_at' => null,
    'updated_at' => $currentTime
]);
?>

<div class="col-lg-12 row">
    <div class="col-lg-3">
        <?php include_once('../parts/sidebar.php'); ?>
    </div>

    <div id="content" class="container col-lg-9">
        <h1>Post restauré</h1>
        <br>
        <a class="btn btn-secondary btn-sm" href="../admin_posts_list.php">Revenir aux posts</a>

    </div>
</div>
        