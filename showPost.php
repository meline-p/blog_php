<?php 

    session_start(); 

    require('sql/pdo.php');
    require('src/models/post.php');
    require('src/models/comment.php');

    $posts = getPublishedPosts($db);

    if (isset($_GET['id'])) {
        $postId = $_GET['id'];
        $post = getPostById($db, $postId, $posts);
        $comments = getValidComments($db, $postId);
        require('templates/show_post_page.php');
    } else {
        echo "ID non défini.";
    }
?>

