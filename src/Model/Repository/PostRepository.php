<?php

namespace Repository;

use DatabaseConnection;

class PostRepository
{
    private \DatabaseConnection $connection;

    public function __construct(\DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getAllPosts()
    {
        $statement = $this->connection->getConnection()->prepare("SELECT * FROM posts ORDER BY created_at DESC");
        $statement->execute();
        $posts = $statement->fetchAll();

        return $posts;
    }

    public function getPublishedPosts()
    {
        $statement = $this->connection->getConnection()->prepare("SELECT * FROM posts WHERE is_published = 1 ORDER BY created_at DESC");
        $statement->execute();
        $posts = $statement->fetchAll();
        return $posts;
    }

    public function getPostById($postId)
    {
        $statement = $this->connection->getConnection()->prepare("SELECT * FROM posts WHERE id = :postId AND is_published = 1");
        $statement->execute(['postId' => $postId]);
        $post = $statement->fetch();
        return $post;
    }

    public function addPost($user_id, $title, $chapo, $content, $is_published)
    {
        $currentTime = date('Y-m-d H:i:s');
        $insertPost = $this->connection->getConnection()->prepare('INSERT INTO posts(user_id, title, chapo, content, is_published, created_at) 
            VALUES (:user_id, :title, :chapo, :content, :is_published, :created_at)');
        $insertPost->execute([
            'user_id' => $user_id,
            'title' => $title,
            'chapo' => $chapo,
            'content' => $content,
            'is_published' => $is_published,
            'created_at' => $currentTime,
        ]);
    }

    public function editPost($postId, $user_id, $title, $chapo, $content, $is_published)
    {
        $currentTime = date('Y-m-d H:i:s');
        $insertPost = $this->connection->getConnection()->prepare('UPDATE posts 
            SET user_id = :user_id, title = :title, chapo = :chapo, content = :content, is_published = :is_published, updated_at = :updated_at
            WHERE id = :id ');
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

    public function deletePost($postId)
    {
        $currentTime = date('Y-m-d H:i:s');
        $deletePost = $this->connection->getConnection()->prepare('UPDATE posts 
            SET deleted_at = :deleted_at, is_published = 0, updated_at = :updated_at
            WHERE id = :id ');
        $deletePost->execute([
            'id' => $postId,
            'deleted_at' => $currentTime,
            'updated_at' => $currentTime
        ]);
    }

    public function restorePost($postId)
    {
        $currentTime = date('Y-m-d H:i:s');
        $deletePost = $this->connection->getConnection()->prepare('UPDATE posts 
            SET deleted_at = NULL, updated_at = :updated_at
            WHERE id = :id ');
        $deletePost->execute([
            'id' => $postId,
            'updated_at' => $currentTime
        ]);
    }
}
