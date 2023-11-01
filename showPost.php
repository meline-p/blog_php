<?php 
    session_start();  
    include_once('php/functions.php');
    include_once('sql/pdo.php');
    include_once('parts/navbar.php');

    if (isset($_GET['id'])) {
        $postId = $_GET['id'];
        $post = getPostById($postId, $posts);
    } else {
        echo "ID non défini.";
    }

    $sqlQuery = 'SELECT c.*, u.surname AS user_surname
        FROM comments c 
        INNER JOIN posts p ON p.id = c.post_id
        INNER JOIN users u ON u.id = c.user_id
        WHERE is_enabled = :is_enabled 
        AND c.post_id = :post_id';
    $commentsStatement = $db->prepare($sqlQuery);
    $commentsStatement->execute([
        'is_enabled' => true,
        'post_id' => $post['id']
    ]);
    $comments = $commentsStatement->fetchAll(); 

    require('templates/show_post_page.php');
?>

