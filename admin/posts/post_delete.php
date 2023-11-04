<?php 
    session_start(); 
    require('../../sql/pdo.php');
    require('../../src/models/post.php');

    if (isset($_GET['id'])) {
        $postId = $_GET['id'];

        if (ctype_digit($postId)) {
            $postId = intval($postId); 

            deletePost($db, $postId);
        }
    }

    require('../../templates/admin/posts/post_delete_page.php');

