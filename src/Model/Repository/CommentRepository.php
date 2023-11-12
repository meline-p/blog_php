<?php

namespace Repository;

use DatabaseConnection;
use Entity\Comment;

class CommentRepository
{
    private \DatabaseConnection $connection;

    public function __construct(\DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getComments()
    {
        $statement = $this->connection->getConnection()->prepare('SELECT c.*, u.surname AS user_surname
        FROM comments c 
        INNER JOIN posts p ON p.id = c.post_id
        INNER JOIN users u ON u.id = c.user_id');
        $statement->execute();
        $comments = $statement->fetchAll();

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
        $comments = $statement->fetchAll();

        return $comments;
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
        $comment = $statement->fetch();

        return $comment;
    }

    public function addComment(Comment $comment)
    {
        $insertComment = $this->connection->getConnection()->prepare('INSERT INTO comments(user_id, post_id, content, created_at) 
                VALUES (:user_id, :post_id, :content, :created_at, :is_enabled)');

        $insertComment->execute([
            'user_id' => $comment->getAuthor(),
            'post_id' => $comment->getPostId(),
            'content' => $comment->getContent(),
            'created_at' => $comment->getCreatedAt(),
            'is_enabled' => $comment->getIsEnabled()
        ]);
    }

    public function editComment(Comment $comment)
    {
        $confirmComment = $this->connection->getConnection()->prepare('UPDATE comments 
        SET is_enabled = :is_enabled, deleted_at = :deleted_at
        WHERE id = :id ');

        $confirmComment->execute([
            'id' => $comment->getCommentId(),
            'is_enabled' => $comment->getIsEnabled(),
            'deleted_at' => $comment->getDeletedAt(),
        ]);
    }
}
