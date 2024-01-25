<?php 
    session_start();
    include_once('../php/functions.php');
    include_once('../sql/pdo.php');

    $sqlQuery = "SELECT c.*, u.surname AS user_surname, p.title AS post_title
        FROM comments c
        INNER JOIN users u ON u.id = c.user_id
        INNER JOIN posts p ON p.id = c.post_id
        ORDER BY 
        CASE
            WHEN c.deleted_at IS NOT NULL THEN 3
            WHEN c.is_enabled = 0 THEN 2
            ELSE 1
        END,
        CASE
            WHEN c.deleted_at IS NOT NULL THEN c.deleted_at
            ELSE c.created_at
        END DESC";
    $commentsStatement = $db->prepare($sqlQuery);
    $commentsStatement->execute();
    $allComments = $commentsStatement->fetchAll();

    require('../templates/admin/admin_comments_list_page.php');

