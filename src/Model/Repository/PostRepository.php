<?php

namespace App\Model\Repository;

use App\lib\DatabaseConnection;
use App\Model\Entity\Post;

class PostRepository
{
    private DatabaseConnection $connection;
    public $current_time;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
        $this->current_time = new \DateTime();
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
        COALESCE(p.updated_at, p.deleted_at) DESC");
        $statement->execute();
        $rows =  $statement->fetchAll();
        $posts = array_map(function ($row) {
            $post = new Post();
            $post->fromSql($row);
            return $post;
        }, $rows);
        return $posts;
    }

    public function countAllPosts()
    {
        $statement = $this->connection->getConnection()->prepare('SELECT COUNT(1) AS nb FROM posts');
        $statement->execute();
        $row = $statement->fetch();
        return $row['nb'];
    }

    public function getPublishedPosts()
    {
        $statement = $this->connection->getConnection()->prepare("SELECT * FROM posts WHERE is_published = 1 ORDER BY created_at DESC");
        $statement->execute();
        $rows =  $statement->fetchAll();
        $posts = array_map(function ($row) {
            $post = new Post();
            $post->fromSql($row);
            return $post;
        }, $rows);
        return $posts;
    }

    public function getPostById($postId)
    {
        $statement = $this->connection->getConnection()->prepare("SELECT * FROM posts WHERE id = :postId");
        $statement->execute(['postId' => $postId]);
        $row = $statement->fetch();
        $post = new Post();
        $post->fromSql($row);
        return $post;
    }

    public function addPost(Post $post)
    {
        $insertPost = $this->connection->getConnection()->prepare('INSERT INTO posts(user_id, title, chapo, content, is_published, created_at, updated_at) 
            VALUES (:user_id, :title, :chapo, :content, :is_published, :created_at, :updated_at)');

        $post->init(
            $post->title,
            $post->chapo,
            $post->content,
            intval($post->user_id),
            $post->is_published
        );

        $insertPost->execute([
            'user_id' => $post->user_id,
            'title' => $post->title,
            'chapo' => $post->chapo,
            'content' => $post->content,
            'is_published' => $post->is_published,
            'created_at' => $this->current_time->format('Y-m-d H:i:s'),
            'updated_at' => $this->current_time->format('Y-m-d H:i:s'),
        ]);
    }


    public function editPost(Post $post)
    {
        $editPost = $this->connection->getConnection()->prepare('UPDATE posts 
            SET user_id = :user_id, title = :title, chapo = :chapo, content = :content, is_published = :is_published, updated_at = :updated_at
            WHERE id = :id ');

        $post->update(
            $post->title,
            $post->chapo,
            $post->content,
            $post->user_id,
            $post->is_published,
        );

        $editPost->execute([
            'id' => $post->id,
            'user_id' => $post->user_id,
            'title' => $post->title,
            'chapo' => $post->chapo,
            'content' => $post->content,
            'is_published' => $post->is_published,
            'updated_at' => $this->current_time->format('Y-m-d H:i:s')
        ]);
    }

    public function deletePost(Post $post)
    {
        $deletePost = $this->connection->getConnection()->prepare('UPDATE posts 
            SET deleted_at = :deleted_at, is_published = 0, updated_at = :updated_at
            WHERE id = :id ');

        $post->delete(
            $post->id,
            $post->is_published,
        );

        $deletePost->execute([
            'id' => $post->id,
            'deleted_at' => $this->current_time->format('Y-m-d H:i:s'),
            'updated_at' => $this->current_time->format('Y-m-d H:i:s')
        ]);
    }

    public function restorePost(Post $post)
    {
        $restorePost = $this->connection->getConnection()->prepare('UPDATE posts 
            SET deleted_at = NULL, updated_at = :updated_at
            WHERE id = :id ');

        $post->restore(
            $post->id,
        );

        $restorePost->execute([
            'id' => $post->id,
            'updated_at' => $this->current_time->format('Y-m-d H:i:s')
        ]);
    }
}
