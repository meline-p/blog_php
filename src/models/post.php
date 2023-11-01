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

    function getAllPosts($db){
        $sqlQuery = "SELECT * FROM posts
            ORDER BY created_at DESC";
        $postsStatement = $db->prepare($sqlQuery);
        $postsStatement->execute();
        $posts = $postsStatement->fetchAll();

        return $posts; 
    }
    

    function getPublishedPosts($db){

        $sqlQuery = "SELECT * FROM posts
            WHERE is_published = 1 
            ORDER BY created_at DESC";
        $postsStatement = $db->prepare($sqlQuery);
        $postsStatement->execute();
        $posts = $postsStatement->fetchAll();

        return $posts;
    }

    function getPostById($db, $postId, $posts) {
        $posts = getPublishedPosts($db);

        foreach ($posts as $post) {
            if ($post['id'] == $postId && $post['is_published'] == true) {
                return $post;
            }
        }
        return null;
    }

    function addPost($db,$user_id, $title, $chapo, $content, $is_published){
        $currentTime = date('Y-m-d H:i:s');
        $created_at = $currentTime;

        $insertPost = $db->prepare('INSERT INTO posts(user_id, title, chapo, content, is_published, created_at) 
            VALUES (:user_id, :title, :chapo, :content, :is_published, :created_at)');
    
        $insertPost->execute([
            'user_id' => $user_id,
            'title' => $title,
            'chapo' => $chapo,
            'content' => $content,
            'is_published' => $is_published,
            'created_at' => $created_at,
        ]);
    }

    function editPost($db, $postId, $user_id, $title, $chapo, $content, $is_published){
        $insertPost = $db->prepare('UPDATE posts 
        SET user_id = :user_id, title = :title, chapo = :chapo, content = :content, is_published = :is_published, updated_at = :updated_at
        WHERE id = :id ');

        $currentTime = date('Y-m-d H:i:s');

        $insertPost->execute([
            'id' => $postId,
            'user_id' => $user_id,
            'title' => $title,
            'chapo' => $chapo,
            'content' => $content,
            'is_published' => $is_published,
            'updated_at' => $currentTime
        ]);
    }

    function deletePost($db, $postId){
        $deletePost = $db->prepare('UPDATE posts 
        SET deleted_at = :deleted_at, is_published = :is_published, updated_at = :updated_at
        WHERE id = :id ');
    
        $currentTime = date('Y-m-d H:i:s');
    
        $deletePost->execute([
            'id' => $postId,
            'deleted_at' => $currentTime,
            'is_published' => 0,
            'updated_at' => $currentTime
        ]);
    }

    function restorePost($db, $postId){
        $deletePost = $db->prepare('UPDATE posts 
        SET deleted_at = :deleted_at, updated_at = :updated_at
        WHERE id = :id ');

        $currentTime = date('Y-m-d H:i:s');

        $deletePost->execute([
            'id' => $postId,
            'deleted_at' => null,
            'updated_at' => $currentTime
        ]);
    }