<?php

namespace Repository;

use DatabaseConnection;

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

}
