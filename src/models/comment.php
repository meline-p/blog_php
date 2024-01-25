<?php

function getAllComments ($db){
    $sqlQuery = 'SELECT c.*, u.surname AS user_surname
        FROM comments c 
        INNER JOIN posts p ON p.id = c.post_id
        INNER JOIN users u ON u.id = c.user_id';
    $commentsStatement = $db->prepare($sqlQuery);
    $commentsStatement->execute();
    $comments = $commentsStatement->fetchAll(); 

    return $comments;
}

function getValidComments($db, $postId){

$sqlQuery = 'SELECT c.*, u.surname AS user_surname
    FROM comments c 
    INNER JOIN posts p ON p.id = c.post_id
    INNER JOIN users u ON u.id = c.user_id
    WHERE is_enabled = :is_enabled 
    AND c.post_id = :post_id';
$commentsStatement = $db->prepare($sqlQuery);
$commentsStatement->execute([
    'is_enabled' => true,
    'post_id' => $postId
]);
$comments = $commentsStatement->fetchAll(); 

return $comments;
}
