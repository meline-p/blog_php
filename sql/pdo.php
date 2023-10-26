<?php 
try{
    $db = new PDO(
        'mysql:host=localhost;dbname=blog_php;charset=utf8', 
    'root', 
    'root',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
);
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}


// USERS
$sqlQuery = 'SELECT * FROM users';
$usersStatement = $db->prepare($sqlQuery);
$usersStatement->execute();
$users = $usersStatement->fetchAll();

// ADMIN
$sqlQuery = 'SELECT * FROM users WHERE role_id = :role_id';
$adminStatement = $db->prepare($sqlQuery);
$adminStatement->execute([
    'role_id' => 1,
]);
$admins = $adminStatement->fetchAll();


// TOUS LES POSTS
$sqlQuery = 'SELECT * FROM posts';
$allPostsStatement = $db->prepare($sqlQuery);
$allPostsStatement->execute();
$allPosts = $allPostsStatement->fetchAll();

// POSTS PUBLIES
$sqlQuery = 'SELECT * FROM posts WHERE is_published = :is_published';
$postsStatement = $db->prepare($sqlQuery);
$postsStatement->execute([
    'is_published' => true,
]);
$posts = $postsStatement->fetchAll();


// TOUS LES COMMENTAIRES
$sqlQuery = 'SELECT * FROM comments';
$allCommentsStatement = $db->prepare($sqlQuery);
$allCommentsStatement->execute();
$allComments = $allCommentsStatement->fetchAll();


// COMMENTAIRES VALIDES
$sqlQuery = 'SELECT * FROM comments WHERE is_enabled = :is_enabled';
$commentsStatement = $db->prepare($sqlQuery);
$commentsStatement->execute([
    'is_enabled' => true,
]);
$comments = $commentsStatement->fetchAll();