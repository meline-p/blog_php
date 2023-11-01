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

    $postId = $_GET['id'];

    $deletePost = $db->prepare('UPDATE posts 
    SET deleted_at = :deleted_at, is_published = :is_published, updated_at = :updated_at
    WHERE id = :id ');

    $currentTime = date('Y-m-d H:i:s');

    $deletePost->execute([
        'id' => $postId,
        'deleted_at' => $currentTime,
        'is_published' => 0,
        'updated_at' => $currentTime
    ]);

    require('../../templates/admin/posts/post_delete_page.php');
?>
