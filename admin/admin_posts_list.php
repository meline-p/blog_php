<?php 
    session_start();
    include_once('../php/functions.php');
    include_once('../sql/pdo.php');

    $sqlQuery = "SELECT p.*, u.surname AS user_surname
            FROM posts p
            LEFT JOIN users u ON p.user_id = u.id
            ORDER BY 
            CASE
                WHEN p.deleted_at IS NOT NULL THEN 2
                WHEN p.updated_at IS NOT NULL THEN 0
                ELSE 1
            END, 
            COALESCE(p.updated_at, p.deleted_at, p.created_at) DESC";
    $statement = $db->prepare($sqlQuery);
    $statement->execute();
    $allPosts = $statement->fetchAll(); 

    require('../templates/admin/admin_posts_list_page.php');
?>
