<?php 
    session_start();
    include('../../sql/pdo.php');
    require('../../src/models/post.php');

    if (isset($_GET['id'])) {
        $postId = $_GET['id'];

        if (ctype_digit($postId)) {
            $postId = intval($postId); 
    
            $posts = getAllPosts($db);
            $post = getPostById($db, $postId, $posts);
    
            if ($post) {
                require('../../templates/admin/posts/restore_post_page.php');
            } else {
                echo "Le post avec l'ID $postId n'a pas été trouvé.";
            }
        } else {
            echo "ID non valide.";
        }

    }  else {
        echo "L'ID n'a pas été transmis dans l'URL.";
    }
   
