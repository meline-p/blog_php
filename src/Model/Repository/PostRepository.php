<?php

namespace App\Model\Repository;

use App\lib\DatabaseConnection;
use App\Model\Entity\Post;

/**
 * Class representing Post repository.
 */
class PostRepository
{
    private DatabaseConnection $connection;
    public $current_time;

    /**
     * Constructor for the PostRepository class.
     *
     * @param  DatabaseConnection $connection The database connection object.
     * @return void
     */
    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
        $this->current_time = new \DateTime();
    }

    /**
     * Private helper method to get a simple SELECT query for posts.
     *
     * This method constructs a SQL SELECT query to retrieve post data along with the surname of the user who created the post.
     * It includes a LEFT JOIN with the users table.
     *
     * @return string The constructed SELECT query.
     */
    private function getSimpleSelect()
    {
        return "SELECT p.*, u.surname AS user_surname
                FROM posts p
                LEFT JOIN users u ON p.user_id = u.id";
    }

    /**
     * Get all posts with user surnames.
     *
     * This method retrieves all posts from the database along with the surname of the user who created each post.
     * It uses the getSimpleSelect method to construct the base SELECT query and adds additional ordering conditions.
     *
     * @return array An array of Post objects representing the retrieved posts.
     */
    public function getAllPosts()
    {
        $statement = $this->connection->getConnection()->prepare($this->getSimpleSelect()."
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

    /**
     * Count all posts in the database that have not been deleted.
     *
     * This method prepares and executes a SQL query to count the number of posts in the "posts" table.
     *
     * @return int The total number of posts in the database.
     */
    public function countAllPosts()
    {
        $statement = $this->connection->getConnection()->prepare('SELECT COUNT(1) AS nb FROM posts WHERE deleted_at IS NULL');
        $statement->execute();

        $row = $statement->fetch();

        return $row['nb'];
    }

    /**
     * Count published posts in the database.
     *
     * This method prepares and executes a SQL query to count the number of published posts in the "posts" table.
     *
     * @return int The total number of published posts in the database.
     */
    public function countPublishedPosts()
    {
        $statement = $this->connection->getConnection()->prepare('SELECT COUNT(1) AS nb FROM posts WHERE is_published = 1');
        $statement->execute();

        $row = $statement->fetch();

        return $row['nb'];
    }

    /**
     * Count draft posts in the database.
     *
     * This method prepares and executes a SQL query to count the number of draft posts in the "posts" table.
     *
     * @return int The total number of draft posts in the database.
     */
    public function countDraftPosts()
    {
        $statement = $this->connection->getConnection()->prepare('SELECT COUNT(1) AS nb FROM posts WHERE is_published = 0 AND deleted_at IS NULL');
        $statement->execute();

        $row = $statement->fetch();

        return $row['nb'];
    }

    /**
     * Get all published posts from the database.
     *
     * This method prepares and executes a SQL query to retrieve all published posts from the "posts" table.
     *
     * @return array An array of Post objects representing the published posts.
     */
    public function getPublishedPosts()
    {
        $statement = $this->connection->getConnection()->prepare($this->getSimpleSelect()."
            WHERE p.is_published = 1 ORDER BY created_at DESC");
        $statement->execute();

        $rows =  $statement->fetchAll();
        $posts = array_map(function ($row) {
            $post = new Post();
            $post->fromSql($row);
            return $post;
        }, $rows);

        return $posts;
    }

    /**
     * Get a post by its ID from the database.
     *
     * This method prepares and executes a SQL query to retrieve a post by its ID from the "posts" table.
     *
     * @param  mixed $postId The ID of the post to retrieve.
     * @return Post|null A Post object representing the retrieved post, or null if the post is not found.
     */
    public function getPostById($postId)
    {
        $statement = $this->connection->getConnection()->prepare($this->getSimpleSelect()." WHERE p.id = :postId");
        $statement->execute(['postId' => $postId]);

        $row = $statement->fetch();
        $post = ($row !== false) ? new Post() : null;

        if ($post !== null) {
            $post->fromSql($row);
        }

        return $post;
    }

    /**
     * Add a new post to the database.
     *
     * This method prepares and executes a SQL query to insert a new post into the "posts" table.
     *
     * @param  Post $post  The Post object representing the post to be added.
     * @return void
     */
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


    /**
     * Edit an existing post in the database.
     *
     * This method prepares and executes a SQL query to update an existing post in the "posts" table.
     *
     * @param  Post $post The Post object representing the post to be edited.
     * @return void
     */
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

    /**
     * Delete a post from the database.
     *
     * This method prepares and executes a SQL query to mark a post as deleted in the "posts" table.
     *
     * @param  Post $post The Post object representing the post to be deleted.
     * @return void
     */
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

    /**
     * Restore a deleted post in the database.
     *
     * This method prepares and executes a SQL query to restore a deleted post in the "posts" table.
     *
     * @param Post $post The Post object representing the post to be restored.
     * @return void
     */
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
