<?php

namespace App\controllers;

use App\lib\AlertService;
use App\Model\Repository\PostRepository;
use App\Model\Repository\CommentRepository;
use App\Model\Repository\UserRepository;
use App\lib\DatabaseConnection;
use App\Model\Entity\Post;

/**
 * Class representing posts
 *
 * This class manages posts
 */
class PostsController
{
    private $postRepository;
    private $commentRepository;
    private $userRepository;
    private $currentTime;

    /**
     * Constructor for initializing the Controller with repositories and current time.
     *
     * @param  DatabaseConnection $connection The database connection object.
     * @return void
     */
    public function __construct(DatabaseConnection $connection)
    {
        // Initialize PostRepository with the provided database connection
        $this->postRepository = new PostRepository($connection);

        // Initialize CommentRepository with the provided database connection
        $this->commentRepository = new CommentRepository($connection);

        // Initialize UserRepository with the provided database connection
        $this->userRepository = new UserRepository($connection);

        // Set the current time for the controller
        $this->currentTime = date('Y-m-d H:i:s');
    }


    /**
     * Display the list of all posts for administration
     *
     * @return void
     */
    public function getPosts()
    {
        // Retrieve all posts
        $posts = $this->postRepository->getAllPosts();

        // Require the admin posts list page template for rendering
        require_once(__DIR__.'/../../templates/admin/admin_posts_list_page.php');
    }

    /**
     * Display the list of published posts.
     *
     * @return void
     */
    public function getPublishedPosts()
    {
        // Retrieve published posts
        $posts = $this->postRepository->getPublishedPosts();

        // Require the posts list page template for rendering
        require(__DIR__.'/../../templates/posts_list_page.php');
    }

    /**
     * Display a single post and its valid comments by post ID.
     *
     * @param  mixed $postId The ID of the post to display
     * @return void
     */
    public function getPostById($postId)
    {
        // Retrieve the post by its ID
        $post = $this->postRepository->getPostById($postId);

        // Retrieve valid comments for the post
        $comments = $this->commentRepository->getValidComments($post->id);

        // Require the show post page template for rendering
        require(__DIR__.'/../../templates/show_post_page.php');
    }

    /**
     * Display the add post page for administrators.
     *
     * @return void
     */
    public function getAddPost()
    {
        // Retrieve a list of administrators
        $admins = $this->userRepository->getAdmins();

        // Require the add post page template for rendering
        require(__DIR__.'/../../templates/admin/posts/add_post_page.php');
    }

    /**
     * Process the addition of a new post based on the submitted data.
     *
     * @param mixed $data The data submitted for adding a new post.
     * @return void
     */
    public function postAddPost($data)
    {
        // Retrieve the user by ID from the submitted data
        $user = $this->userRepository->getUserById($data["user_id"]);

        // Create a new Post instance and initialize it with the submitted data
        $post = new Post();
        $post->init(
            $data["title"],
            $data["chapo"],
            $data["content"],
            intval($data["user_id"]),
            isset($data["is_published"]) ? 1 : 0
        );

        // Add the new post to the repository
        $this->postRepository->addPost($post);

        // Display a success message
        AlertService::add('success', "La publication " . $post->title . " a bien été ajoutée.");

        // Redirect to the admin publications page
        header("location: /admin/publications");
        exit;
    }

    /**
     * Display the edit post page for administrators.
     *
     * @param  mixed $postId The ID of the post to be edited.
     * @return void
     */
    public function getEditPost($postId)
    {
        // Retrieve the post by its ID
        $post = $this->postRepository->getPostById($postId);

        // Retrieve a list of administrators
        $admins = $this->userRepository->getAdmins();

        // Require the edit post page template for rendering
        require(__DIR__.'/../../templates/admin/posts/edit_post_page.php');
    }

    /**
     * Process the editing of a post based on the submitted data.
     *
     * @param  mixed $postId The ID of the post to be edited.
     * @param  mixed $data The data submitted for editing the post.
     * @return void
     */
    public function postEditPost($postId, $data)
    {
        // Check if the necessary information is provided
        if (!isset($postId) || empty($data["user_id"]) || empty($data["title"]) || empty($data["content"])) {
            // Display an error message and redirect back to the edit post page
            AlertService::add('danger', "Veuillez fournir toutes les informations nécessaires.");
            header("location: /admin/publication/modifier/$postId");
            exit;
        }

        // Retrieve the post by its ID
        $post = $this->postRepository->getPostById($postId);

        // Check if the post exists
        if(!$post) {
            echo 'Ce post n\'existe pas';
            return;
        }

        // Update the post with the submitted data
        $post->update(
            $data["title"],
            $data["chapo"],
            $data["content"],
            $data["user_id"],
            isset($data["is_published"]) ? 1 : 0
        );

        // Edit the post in the repository
        $this->postRepository->editPost($post);

        // Display a success message
        AlertService::add('success', "La publication ". $data["title"] ." a bien été modifiée.");

        // Redirect to the admin publications page
        header("location: /admin/publications");
        exit;
    }

    /**
     * Display the delete post page for administrators.
     *
     * @param  mixed $postId The ID of the post to be deleted.
     * @return void
     */
    public function getDeletedPost($postId)
    {
        // Retrieve the post by its ID
        $post = $this->postRepository->getPostById($postId);

        // Retrieve a list of administrators
        $admins = $this->userRepository->getAdmins();

        // Update the post with the user's surname from the administrators
        foreach ($admins as $admin) {
            if ($admin->id == $post->user_id) {
                $post->user_surname = $admin->surname;
            }
        }

        // Require the delete post page template for rendering
        require(__DIR__.'/../../templates/admin/posts/delete_post_page.php');
    }


    /**
     * Process the deletion of a post based on the submitted ID.
     *
     * @param  mixed $postId The ID of the post to be deleted.
     * @return void
     */
    public function postDeletePost($postId)
    {
        // Check if the post ID is provided
        if (!isset($postId)) {
            echo "Veuillez fournir l'identifiant du post.";
            return;
        }

        // Retrieve the post by its ID
        $post = $this->postRepository->getPostById($postId);

        // Check if the post exists
        if($post) {
            // Mark the post as deleted (soft delete)
            $post->delete($postId, 0);

            // Delete the post from the repository
            $this->postRepository->deletePost($post);

            // Display a success message
            AlertService::add('success', "La publication ". $post->title ." a bien été supprimée.");

            // Redirect to the admin publications page
            header("location: /admin/publications");
            exit;

        } else {
            // Display a message if the post doesn't exist
            echo 'Ce post n\'existe pas';
        }
    }

    /**
     * Display the restore post page for administrators.
     *
     * @param  mixed $postId The ID of the post to be restored.
     * @return void
     */
    public function getRestorePost($postId)
    {
        // Retrieve the post by its ID
        $post = $this->postRepository->getPostById($postId);

        // Retrieve a list of administrators
        $admins = $this->userRepository->getAdmins();

        // Update the post with the user's surname from the administrators
        foreach ($admins as $admin) {
            if ($admin->id == $post->user_id) {
                $post->user_surname = $admin->surname;
            }
        }

        // Require the restore post page template for rendering
        require(__DIR__.'/../../templates/admin/posts/restore_post_page.php');
    }

    /**
     * Process the restoration of a post based on the submitted ID.
     *
     * @param  mixed $postId The ID of the post to be restored.
     * @return void
     */
    public function postRestorePost($postId)
    {
        // Retrieve the post by its ID
        $post = $this->postRepository->getPostById($postId);

        // Check if the post exists
        if($post) {
            // Restore the post
            $post->restore($postId);

            // Restore the post in the repository
            $this->postRepository->restorePost($post);

            // Display a success message
            AlertService::add('success', "La publication ". $post->title ." a bien été restaurée.");

            // Redirect to the admin publications page
            header("location: /admin/publications");
            exit;
        } else {
            // Display a message if the post doesn't exist
            echo 'Ce post n\'existe pas';
        }
    }

}
