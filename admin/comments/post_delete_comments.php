<?php
    session_start();
    include_once('../../php/functions.php');
    include_once('../../sql/pdo.php');

    if (isset($_GET['id'])) {
        $commentId = $_GET['id'];
    } else {
        echo "L'ID n'a pas été transmis dans l'URL.";
        return;
    }

    $commentId = $_GET['id'];

    $deleteComment = $db->prepare('UPDATE comments 
    SET is_enabled = :is_enabled
    WHERE id = :id ');

    $is_enabled = false;

    $deleteComment->execute([
        'id' => $commentId,
        'is_enabled' => $is_enabled,
    ]);

    require('../../templates/admin/comments/post_delete_comments_page.php');



        