<?php

namespace App\controllers;

use App\lib\AlertService;
use App\Model\Repository\CommentRepository;
use App\Model\Repository\UserRepository;
use App\Model\Repository\PostRepository;
use App\lib\DatabaseConnection;
use App\Model\Entity\Comment;

/**
 * Class representing comments
 *
 * This class manages comments
 */
class CommentsController
{
    private $commentRepository;
    private $userRepository;
    private $postRepository;
    private $currentTime;

    /**
     * Constructor for initializing the Controller with repositories and current time.
     *
     * @param  DatabaseConnection $connection The database connection object.
     * @return void
     */
    public function __construct(DatabaseConnection $connection)
    {
        // Initialize CommentRepository with the provided database connection
        $this->commentRepository = new CommentRepository($connection);

        // Initialize UserRepository with the provided database connection
        $this->userRepository = new UserRepository($connection);

        // Initialize PostRepository with the provided database connection
        $this->postRepository = new PostRepository($connection);

        // Set the current time for the controller
        $this->currentTime = date('Y-m-d H:i:s');
    }

    /**
     * Retrieve all comments for display in the admin comments list page.
     *
     * This function fetches all comments and requires the admin comments list page template for rendering.
     *
     * @return void
     */
    public function getComments()
    {
        // Retrieve all comments
        $comments = $this->commentRepository->getComments();

        // Require the admin comments list page template for rendering
        require(__DIR__.'/../../templates/admin/admin_comments_list_page.php');
    }

    /**
     * Retrieve all validated comments for a specific post.
     *
     * This function fetches all comments that have been confirmed
     * and associates them with a specific post.
     *
     * @param  mixed $postId
     * @return void
     */
    public function getValidComments($postId)
    {
        // Retrieve all validated comments for the specified post
        $comments = $this->commentRepository->getValidComments($postId);
    }

    /**
     * Handle the addition of a new comment.
     *
     * This function processes the data submitted for adding a comment.
     * It checks if the user is logged in, validates the comment data,
     * and then adds the comment to the repository.
     *
     * @param  mixed $postId The identifier of the post to which the comment is added.
     * @param  mixed $data The data submitted for the new comment.
     * @return void
     */
    public function postAddComment($postId, $data)
    {
        // Check if the user is logged in
        if (!isset($_SESSION['user'])) {
            AlertService::add('danger', 'Vous devez être connecté pour ajouter un commentaire.');
            return;
        }

        // Validate comment data
        if ($data['comment'] == '') {
            AlertService::add('danger', 'Veuillez remplir le champ commentaire.');
            return;
        }

        // Validate post ID
        if (!ctype_digit($postId)) {
            echo "ID non valide.";
            AlertService::add('danger', 'ID non valide');
            return;
        }

        // Create a new Comment instance
        $comment = new Comment();

        // Initialize the comment with user ID, post ID, and comment content
        $comment->init(
            $_SESSION['user']->id,
            intval($postId),
            nl2br(htmlspecialchars($data['comment'])),
            null
        );

        $this->commentRepository->addComment($comment);

        AlertService::add('success', 'Votre commentaire a bien été ajouté.');
        header("location: /publication/".$comment->post_id);
        exit;
    }

    /**
     * Allow an administrator to confirm the validation of a comment.
     *
     * Displays a page allowing the administrator to confirm the validation of a comment.
     *
     * @param mixed $commentId The identifier of the comment to be confirmed for validation.
     * @return void
     */
    public function getConfirmComment($commentId)
    {
        // Retrieve the comment based on the provided identifier
        $comment = $this->commentRepository->getCommentById($commentId);

        // Retrieve all posts and users for additional information
        $posts = $this->postRepository->getAllPosts();
        $users = $this->userRepository->getUsers();

        // Associate user information with the comment
        foreach ($users as $user) {
            if ($user->id == $comment->user_id) {
                $comment->user_surname = $user->surname;
            }
        }

        // Associate post information with the comment
        foreach ($posts as $post) {
            if ($post->id == $comment->post_id) {
                $comment->post_title = $post->title;
                $comment->post_content = $post->content;
            }
        }

        // Require the valid comments page template for rendering
        require(__DIR__.'/../../templates/admin/comments/valid_comments_page.php');
    }

    /**
     * Allow an administrator to confirm the validation of a comment.
     *
     * This function retrieves a comment based on its identifier and proceeds to confirm its validation.
     *
     * @param mixed $commentId The identifier of the comment to be confirmed for validation.
     */
    public function postConfirmComment($commentId)
    {
        // Retrieve the comment based on the provided identifier
        $comment = $this->commentRepository->getCommentById($commentId);

        // Check if the comment exists
        if($comment) {
            // Confirm the validation of the comment
            $comment->confirm($commentId, 1);

            // Update the comment in the repository
            $this->commentRepository->confirmComment($comment);

            // Add a success alert message indicating the successful validation of the comment
            AlertService::add('success', "Le commentaire de ". $comment->user_surname ." a bien été validé.");

            // Redirect to the admin comments page
            header("location: /admin/commentaires");
            exit;

        } else {
            // Display an error message if the comment does not exist
            echo 'Ce commentaire n\'existe pas';
        }
    }


    /**
     * Display the page for deleting a specific comment.
     *
     * This function retrieves a comment based on its identifier and also fetches all posts and users.
     * It associates the user and post information with the comment for display on the deletion page.
     *
     * @param mixed $commentId The identifier of the comment for which the deletion page is displayed.
     */
    public function getDeleteComment($commentId)
    {
        // Retrieve the comment based on the provided identifier
        $comment = $this->commentRepository->getCommentById($commentId);

        // Retrieve all posts and users for additional information
        $posts = $this->postRepository->getAllPosts();
        $users = $this->userRepository->getUsers();

        // Associate user information with the comment
        foreach ($users as $user) {
            if ($user->id == $comment->user_id) {
                $comment->user_surname = $user->surname;
            }
        }

        // Associate post information with the comment
        foreach ($posts as $post) {
            if ($post->id == $comment->post_id) {
                $comment->post_title = $post->title;
                $comment->post_content = $post->content;
            }
        }

        // Require the deletion comments page template for rendering
        require(__DIR__.'/../../templates/admin/comments/delete_comments_page.php');
    }

    /**
    * Delete a comment marked for deletion by an administrator.
    *
    * This function retrieves a comment based on its identifier and proceeds to mark it for deletion.
    *
    * @param mixed $commentId The identifier of the comment to be marked for deletion.
    */
    public function postDeleteComment($commentId)
    {
        // Retrieve the comment based on the provided identifier
        $comment = $this->commentRepository->getCommentById($commentId);

        // Check if the comment exists
        if($comment) {

            // Mark the comment for deletion
            $comment->delete($commentId, 0);

            // Update the comment in the repository
            $this->commentRepository->deleteComment($comment);

            // Add a success alert message indicating the successful deletion of the comment
            AlertService::add('success', "Le commentaire de ". $comment->user_surname ." a bien été suprimé.");

            // Redirect to the admin comments page
            header("location: /admin/commentaires");
            exit;

        } else {
            // Display an error message if the comment does not exist
            echo 'Ce commentaire n\'existe pas';
        }
    }

    /**
     * Display the page for restoring a specific comment.
     *
     * This function retrieves a comment based on its identifier and also fetches all posts and users.
     * It associates the user and post information with the comment for display on the restoration page.
     *
     * @param mixed $commentId The identifier of the comment for which the restoration page is displayed.
     */
    public function getRestoreComment($commentId)
    {
        // Retrieve the comment based on the provided identifier
        $comment = $this->commentRepository->getCommentById($commentId);

        // Retrieve all posts and users for additional information
        $posts = $this->postRepository->getAllPosts();
        $users = $this->userRepository->getUsers();

        // Associate user information with the comment
        foreach ($users as $user) {
            if ($user->id == $comment->user_id) {
                $comment->user_surname = $user->surname;
            }
        }

        // Associate post information with the comment
        foreach ($posts as $post) {
            if ($post->id == $comment->post_id) {
                $comment->post_title = $post->title;
                $comment->post_content = $post->content;
            }
        }

        // Require the restoration comments page template for rendering
        require(__DIR__.'/../../templates/admin/comments/restore_comments_page.php');
    }

    /**
     * Restore a comment marked for restoration by an administrator.
     *
     * This function retrieves a comment based on its identifier and proceeds to confirm its restoration.
     *
     * @param mixed $commentId The identifier of the comment to be restored.
     */
    public function postRestoreComment($commentId)
    {
        // Retrieve the comment based on the provided identifier
        $comment = $this->commentRepository->getCommentById($commentId);

        // Check if the comment exists
        if($comment) {
            // Confirm the restoration of the comment
            $comment->confirm($commentId, 1);

            // Update the comment in the repository
            $this->commentRepository->confirmComment($comment);

            // Add a success alert message indicating the successful restoration of the comment
            AlertService::add('success', "Le commentaire de ". $comment->user_surname ." a bien été restauré.");

            // Redirect to the admin comments page
            header("location: /admin/commentaires");
            exit;

        } else {
            // Display an error message if the comment does not exist
            echo 'Ce commentaire n\'existe pas';
        }
    }


}
