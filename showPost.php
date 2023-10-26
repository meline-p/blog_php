<?php session_start(); ?>
<?php include_once('parts/header.php'); ?>
<?php include_once('parts/navbar.php'); ?>

<div id="content" class="container">

    <?php 
    include_once('php/functions.php');
    include_once('sql/pdo.php');

    if (isset($_GET['id'])) {
        $postId = $_GET['id'];
        $post = getPostById($postId, $posts);

        if($post) {
    ?>
        <div>
            <h3><?= $post['title']; ?></h3>
            <p><i>publié le <?= $post['created_at']; ?></i></p>
            <p><?= $post['content']; ?></p>
            <a class="btn btn-dark" href="postsList.php">Retour à la liste des posts</a>
        </div>

    <?php
        } else { 
            echo "Aucun post trouvé pour cet ID.";
        }

    } else {
        echo "ID non défini.";
    }
    ?>

</div>

<?php include_once('parts/footer.php'); ?>