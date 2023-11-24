<?php

namespace App\Model\Repository;

use App\lib\DatabaseConnection;
use App\Model\Entity\Post;

class PostRepository
{
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getAllPosts()
    {
        $statement = $this->connection->getConnection()->prepare("SELECT p.*, u.surname AS user_surname
        FROM posts p
        LEFT JOIN users u ON p.user_id = u.id
        ORDER BY 
        CASE
            WHEN p.deleted_at IS NOT NULL THEN 2
            WHEN p.updated_at IS NOT NULL THEN 0
            ELSE 1
        END, 
        COALESCE(p.updated_at, p.deleted_at, p.created_at) DESC");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getPublishedPosts()
    {
        $statement = $this->connection->getConnection()->prepare("SELECT * FROM posts WHERE is_published = 1 ORDER BY created_at DESC");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getPostById($postId)
    {
        $statement = $this->connection->getConnection()->prepare("SELECT * FROM posts WHERE id = :postId AND is_published = 1");
        $statement->execute(['postId' => $postId]);
        $post = $statement->fetch();
        return $post;
    }

    public function addPost(Post $post)
    {
        $insertPost = $this->connection->getConnection()->prepare('INSERT INTO posts(user_id, title, chapo, content, is_published, created_at) 
            VALUES (:user_id, :title, :chapo, :content, :is_published, :created_at)');
        $insertPost->execute([
            'user_id' => $post->getAuthor(),
            'title' => $post->getTitle(),
            'chapo' => $post->getChapo(),
            'content' => $post->getContent(),
            'is_published' => $post->getIsPublished(),
            'created_at' => $post->getCreatedAt(),
        ]);
    }


    public function editPost(Post $post)
    {
        $editPost = $this->connection->getConnection()->prepare('UPDATE posts 
            SET user_id = :user_id, title = :title, chapo = :chapo, content = :content, is_published = :is_published, updated_at = :updated_at
            WHERE id = :id ');
        $editPost->execute([
            'id' => $post->getPostId(),
            'user_id' => $post->getAuthor(),
            'title' => $post->getTitle(),
            'chapo' => $post->getChapo(),
            'content' => $post->getContent(),
            'is_published' => $post->getIsPublished(),
            'updated_at' => $post->getUpdatedAt()
        ]);
    }

    public function deletePost(Post $post)
    {
        $deletePost = $this->connection->getConnection()->prepare('UPDATE posts 
            SET deleted_at = :deleted_at, is_published = 0, updated_at = :updated_at
            WHERE id = :id ');
        $deletePost->execute([
            'id' => $post->getPostId(),
            'deleted_at' => $post->getDeletedAt(),
            'updated_at' => $post->getUpdatedAt()
        ]);
    }

    public function restorePost(Post $post)
    {
        $restorePost = $this->connection->getConnection()->prepare('UPDATE posts 
            SET deleted_at = NULL, updated_at = :updated_at
            WHERE id = :id ');
        $restorePost->execute([
            'id' => $post->getPostId(),
            'updated_at' => $post->getUpdatedAt()
        ]);
    }
}
