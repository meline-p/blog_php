<?php 
    session_start(); 
    include_once('php/functions.php');
    include_once('sql/pdo.php');
    include_once('parts/navbar.php');

    $sqlQuery = "SELECT * FROM posts
    WHERE is_published = 1 
    ORDER BY created_at DESC";
    $postsStatement = $db->prepare($sqlQuery);
    $postsStatement->execute();
    $posts = $postsStatement->fetchAll();

    require('templates/posts_list_page.php');
?>

