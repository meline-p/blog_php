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

    $title = $_POST['title'];
    $chapo = $_POST['chapo'];
    $content = $_POST['content'];
    $user_id = $_POST['author'];
    $is_published = isset($_POST['is_published']) ? 1 : 0;

    $post_id = addPost($db, $user_id, $title, $chapo, $content, $is_published);

    require('../../templates/admin/posts/post_add_page.php');
?>
