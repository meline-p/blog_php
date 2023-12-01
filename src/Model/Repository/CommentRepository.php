<?php

namespace App\Model\Repository;

use App\lib\DatabaseConnection;
use App\Model\Entity\Comment;

class CommentRepository
{
    private DatabaseConnection $connection;
    public $current_time;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
        $this->current_time = new \DateTime();
    }

    public function getComments()
    {
        $statement = $this->connection->getConnection()->prepare("SELECT c.*, u.surname AS user_surname, p.title AS post_title
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
        END DESC");
        $statement->execute();
        $rows =  $statement->fetchAll();
        $comments = array_map(function ($row) {
            $comment = new Comment();
            $comment->fromSql($row);
            return $comment;
        }, $rows);
        return $comments;
    }

    public function getValidComments($postId)
    {
        $statement = $this->connection->getConnection()->prepare('SELECT c.*, u.surname AS user_surname
            FROM comments c 
            INNER JOIN posts p ON p.id = c.post_id
            INNER JOIN users u ON u.id = c.user_id
            WHERE is_enabled = 1 
            AND c.post_id = :post_id');
        $statement->execute([
            'post_id' => $postId
        ]);
        $rows =  $statement->fetchAll();
        $comments = array_map(function ($row) {
            $comment = new Comment();
            $comment->fromSql($row);
            return $comment;
        }, $rows);
        return $comments;
    }

    public function countAllComments()
    {
        $statement = $this->connection->getConnection()->prepare('SELECT COUNT(1) AS nb FROM comments');
        $statement->execute();
        $row = $statement->fetch();
        return $row['nb'];
    }

    public function getCommentById($commentId)
    {
        $statement = $this->connection->getConnection()->prepare('SELECT c.*, u.surname AS user_surname 
            FROM comments c
            LEFT JOIN users u ON c.user_id = u.id
            WHERE c.id = :commentId');
        $statement->execute([
            'commentId' => $commentId
        ]);
        $row = $statement->fetch();
        $comment = new Comment();
        $comment->fromSql($row);
        return $comment;
    }

    public function addComment(Comment $comment)
    {
        $insertComment = $this->connection->getConnection()->prepare('INSERT INTO comments(user_id, post_id, content, created_at) 
                VALUES (:user_id, :post_id, :content, :created_at, :is_enabled)');

        $comment->init(
            $comment->user_id,
            $comment->post_id,
            $comment->content,
            $comment->is_enabled
        );

        $insertComment->execute([
            'user_id' => $comment->user_id,
            'post_id' => $comment->post_id,
            'content' => $comment->content,
            'created_at' => $this->current_time,
            'is_enabled' => $comment->is_enabled
        ]);
    }

    public function confirmComment(Comment $comment)
    {
        $confirmComment = $this->connection->getConnection()->prepare('UPDATE comments 
        SET is_enabled = :is_enabled, deleted_at = :deleted_at
        WHERE id = :id ');

        $comment->confirm(
            $comment->id,
            $comment->is_enabled
        );

        $confirmComment->execute([
            'id' => $comment->id,
            'is_enabled' => $comment->is_enabled,
            'deleted_at' => null,
        ]);
    }

    public function deleteComment(Comment $comment)
    {
        $confirmComment = $this->connection->getConnection()->prepare('UPDATE comments 
        SET is_enabled = :is_enabled, deleted_at = :deleted_at
        WHERE id = :id ');

        $comment->delete(
            $comment->id,
            $comment->is_enabled
        );

        $confirmComment->execute([
            'id' => $comment->id,
            'is_enabled' => $comment->is_enabled,
            'deleted_at' => $this->current_time,
        ]);
    }
}
