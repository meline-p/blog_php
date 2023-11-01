<?php 
    session_start();
    require('../../sql/pdo.php');
    require('../../src/models/post.php');

    if (
        !isset($_POST['title']) || empty($_POST['title']) ||
        !isset($_POST['content']) || empty($_POST['content'])
    ) {
        echo "Veuillez remplir les champs Titre et Contenu.";
        return;
    }

    if (isset($_GET['id'])) {
        $postId = $_GET['id'];

        if (ctype_digit($postId)) {
            $postId = intval($postId); 

            $title = $_POST['title'];
            $chapo = $_POST['chapo'];
            $content = $_POST['content'];
            $user_id = $_POST['author'];
            $is_published = isset($_POST['is_published']) ? 1 : 0;
        
            $post_id = editPost($db, $postId, $user_id, $title, $chapo, $content, $is_published);
    
            $updated_at = $currentTime;
        }
    }

  
    require('../../templates/admin/posts/post_edit_page.php');
?>
        