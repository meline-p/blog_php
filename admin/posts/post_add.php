<?php 
    session_start(); 
    require('../../sql/pdo.php');
    require('../../src/models/post.php');
    require('../../src/models/user.php');

    $users = getUsers($db);

    $sqlQuery = "SELECT p.*, u.surname AS user_surname
            FROM posts p
            LEFT JOIN users u ON p.user_id = u.id";
    $statement = $db->prepare($sqlQuery);
    $statement->execute();
    $allPosts = $statement->fetchAll(); 


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
    $is_published = isset($_POST['is_published']) ? 1 : 0;

    $user_id = $_POST['user_id'];
    $user = getUserById($db, $user_id, $users);
    $user_surname = $user['surname'];

    $post_id = addPost($db, $user_id, $title, $chapo, $content, $is_published);

    require('../../templates/admin/posts/post_add_page.php');

