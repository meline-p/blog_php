<?php 
    session_start();
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

    require('../../templates/admin/posts/delete_post_page.php');
?>