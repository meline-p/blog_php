<?php

namespace App\Model\Repository;

use App\lib\DatabaseConnection;
use App\Model\Entity\Comment;

/**
 * Class representing Comment repository.
 */
class CommentRepository
{
    private DatabaseConnection $connection;
    public $current_time;

    /**
     * Constructor for the class CommentRepository.
     *
     * @param DatabaseConnection $connection The database connection instance.
     * @return void
     */
    public function __construct(DatabaseConnection $connection)
    {
        // Set the provided database connection instance
        $this->connection = $connection;

        // Initialize the current_time property with the current date and time
        $this->current_time = new \DateTime();
    }

    /**
     * Retrieves comments from the database.
     *
     * @return array An array of Comment objects.
     */
    public function getComments()
    {
        // Prepare SQL query to fetch comments along with user and post information
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

        // Execute the query
        $statement->execute();

        // Fetch all rows from the result set
        $rows =  $statement->fetchAll();

        // Map each row to a Comment object
        $comments = array_map(function ($row) {
            $comment = new Comment();
            $comment->fromSql($row);
            return $comment;
        }, $rows);

        // Return the array of Comment objects
        return $comments;
    }

    /**
     * Retrieves valid comments for a specific post from the database.
     *
     * @param  mixed $postId The ID of the post for which to retrieve comments.
     * @return array An array of Comment objects.
     */
    public function getValidComments($postId)
    {
        // Prepare SQL query to fetch valid comments along with user information
        $statement = $this->connection->getConnection()->prepare('SELECT c.*, u.surname AS user_surname
            FROM comments c 
            INNER JOIN posts p ON p.id = c.post_id
            INNER JOIN users u ON u.id = c.user_id
            WHERE is_enabled = 1 
            AND c.post_id = :post_id');

        // Execute the query with the provided post ID as a parameter
        $statement->execute([
            'post_id' => $postId
        ]);

        // Fetch all rows from the result set
        $rows =  $statement->fetchAll();

        // Map each row to a Comment object
        $comments = array_map(function ($row) {
            $comment = new Comment();
            $comment->fromSql($row);
            return $comment;
        }, $rows);

        // Return the array of Comment objects
        return $comments;
    }

    /**
     * Counts the total number of comments in the database.
     *
     * @return int The total number of comments.
     */
    public function countAllComments()
    {
        // Prepare SQL query to count all comments
        $statement = $this->connection->getConnection()->prepare('SELECT COUNT(1) AS nb FROM comments');

        // Execute the query
        $statement->execute();

        // Fetch the result row
        $row = $statement->fetch();

        // Return the total number of comments
        return $row['nb'];
    }

    /**
     * Retrieves a comment by its ID.
     *
     * @param  mixed $commentId The ID of the comment to retrieve.
     * @return Comment|null The comment object if found, or null if not found.
     */
    public function getCommentById($commentId)
    {
        // Prepare SQL query to select a comment by its ID
        $statement = $this->connection->getConnection()->prepare('SELECT c.*, u.surname AS user_surname 
            FROM comments c
            LEFT JOIN users u ON c.user_id = u.id
            WHERE c.id = :commentId');

        // Execute the query with the provided comment ID
        $statement->execute([
            'commentId' => $commentId
        ]);

        // Fetch the result row
        $row = $statement->fetch();

        // Check if a row is found
        if (!$row) {
            return null;
        }

        // Create a new Comment object and populate it with data from the result row
        $comment = new Comment();
        $comment->fromSql($row);

        // Return the Comment object
        return $comment;
    }

    /**
     * Adds a new comment to the database.
     *
     * @param  Comment $comment The comment object to be added.
     * @return void
     */
    public function addComment(Comment $comment)
    {
        // Prepare SQL query to insert a new comment
        $insertComment = $this->connection->getConnection()->prepare('INSERT INTO comments(user_id, post_id, content, created_at, is_enabled) 
                VALUES (:user_id, :post_id, :content, :created_at, :is_enabled)');

        // Initialize the comment properties
        $comment->init(
            $comment->user_id,
            $comment->post_id,
            $comment->content,
            $comment->is_enabled
        );

        // Execute the query with the comment data
        $insertComment->execute([
            'user_id' => $comment->user_id,
            'post_id' => $comment->post_id,
            'content' => $comment->content,
            'created_at' => $this->current_time->format('Y-m-d H:i:s'),
            'is_enabled' => $comment->is_enabled
        ]);
    }

    /**
     * Confirms a comment, setting its 'is_enabled' property to true and 'deleted_at' to null.
     *
     * @param Comment $comment The comment object to be confirmed.
     * @return void
     */
    public function confirmComment(Comment $comment)
    {
        // Prepare SQL query to update a comment, confirming it
        $confirmComment = $this->connection->getConnection()->prepare('UPDATE comments 
        SET is_enabled = :is_enabled, deleted_at = :deleted_at
        WHERE id = :id ');

        // Confirm the comment by setting its properties
        $comment->confirm(
            $comment->id,
            $comment->is_enabled
        );

        // Execute the query with the updated comment data
        $confirmComment->execute([
            'id' => $comment->id,
            'is_enabled' => $comment->is_enabled,
            'deleted_at' => null,
        ]);
    }

    /**
     * Deletes a comment, setting its 'is_enabled' property to false and 'deleted_at' to the current time.
     *
     * @param Comment $comment The comment object to be deleted.
     * @return void
     */
    public function deleteComment(Comment $comment)
    {
        // Prepare SQL query to update a comment, deleting it
        $deleteComment = $this->connection->getConnection()->prepare('UPDATE comments 
        SET is_enabled = :is_enabled, deleted_at = :deleted_at
        WHERE id = :id ');

        // Delete the comment by setting its properties
        $comment->delete(
            $comment->id,
            $comment->is_enabled
        );

        // Execute the query with the updated comment data
        $deleteComment->execute([
            'id' => $comment->id,
            'is_enabled' => $comment->is_enabled,
            'deleted_at' => $this->current_time->format('Y-m-d H:i:s'),
        ]);
    }
}
