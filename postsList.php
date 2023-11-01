<?php 

    session_start(); 

    require('sql/pdo.php');
    require('src/models/post.php');

    $db = new PDO(
        'mysql:host=localhost;dbname=blog_php;charset=utf8', 
        'root', 
        'root',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $posts = getPublishedPosts($db);

    require('templates/posts_list_page.php');
?>

