<?php 
    session_start(); 
    include_once('../../php/functions.php');
    include_once('../../sql/pdo.php');

    if (
        !isset($_POST['title']) || empty($_POST['title']) ||
        !isset($_POST['content']) || empty($_POST['content'])
    ) {
        echo "Veuillez remplir les champs Titre et Contenu.";
        return;
    }

    $title = $_POST['title'];
    $chapo = $_POST['chapo'];
    $content = $_POST['content'];
    $user_id = $_POST['author'];
    $is_published = isset($_POST['is_published']) ? 1 : 0;

    $insertPost = $db->prepare('INSERT INTO posts(user_id, title, chapo, content, is_published) 
        VALUES (:user_id, :title, :chapo, :content, :is_published)');

    $insertPost->execute([
        'user_id' => $user_id,
        'title' => $title,
        'chapo' => $chapo,
        'content' => $content,
        'is_published' => $is_published
    ]);

    require('../../templates/admin/posts/post_add_page.php');
?>
