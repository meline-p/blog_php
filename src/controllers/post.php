<?php 

    require('sql/pdo.php');
    require_once('src/models/post.php');
    require_once('src/models/comment.php');

    function post($db, $id){
        $posts = getAllPosts($db);
        $id = ($_GET['id']);

        if (isset($_GET['id'])) {
            $postId = $_GET['id'];
            $post = getPostById($db, $postId, $posts);
            $comments = getValidComments($db, $postId);
            require('templates/show_post_page.php');
        } else {
            echo "ID non défini.";
        }
    }

    function getPostsList($db){

        $posts = getPublishedPosts($db);
    
        require('templates/posts_list_page.php');
    }

    

