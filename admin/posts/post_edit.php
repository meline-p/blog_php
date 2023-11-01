<?php 
    session_start();
    include_once('../../php/functions.php');
    include_once('../../sql/pdo.php');

    if (isset($_GET['id'])) {
        $postId = $_GET['id'];
    } else {
        echo "L'ID n'a pas été transmis dans l'URL.";
        return;
    }

    if (
        !isset($_POST['title']) || empty($_POST['title']) ||
        !isset($_POST['content']) || empty($_POST['content'])
    ) {
        echo "Veuillez remplir les champs Titre et Contenu.";
        return;
    }

    $postId = $_GET['id'];
    $title = $_POST['title'];
    $chapo = $_POST['chapo'];
    $content = $_POST['content'];
    $user_id = $_POST['author'];
    $is_published = isset($_POST['is_published']) ? 1 : 0;

    $insertPost = $db->prepare('UPDATE posts 
    SET user_id = :user_id, title = :title, chapo = :chapo, content = :content, is_published = :is_published, updated_at = :updated_at
    WHERE id = :id ');

    $currentTime = date('Y-m-d H:i:s');

    $insertPost->execute([
        'id' => $postId,
        'user_id' => $user_id,
        'title' => $title,
        'chapo' => $chapo,
        'content' => $content,
        'is_published' => $is_published,
        'updated_at' => $currentTime
    ]);
    $updated_at = $currentTime;

    require('../../templates/admin/posts/post_edit_page.php');
?>
        