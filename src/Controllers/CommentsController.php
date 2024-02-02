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
        $this->commentRepository = new CommentRepository($connection);
        $this->userRepository = new UserRepository($connection);
        $this->postRepository = new PostRepository($connection);
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
        $comments = $this->commentRepository->getComments();
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
        if (!isset($_SESSION['user'])) {
            AlertService::add('danger', 'Vous devez être connecté pour ajouter un commentaire.');
            return;
        }

        if ($data['comment'] == '') {
            AlertService::add('danger', 'Veuillez remplir le champ commentaire.');
            return;
        }

        if (!ctype_digit($postId)) {
            AlertService::add('danger', 'ID non valide');
            return;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            require_once(__DIR__ . '/../../templates/error_page.php');
            exit;
        }

        $comment = new Comment();

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
     * Get comment details by ID and associate user and post information.
     *
     * @param int $commentId The ID of the comment.
     * @return Comment|null The comment object with associated user and post details, or null if the comment does not exist.
     */
    private function getCommentDetails($commentId)
    {
        $comment = $this->commentRepository->getCommentById($commentId);

        $posts = $this->postRepository->getAllPosts();
        $users = $this->userRepository->getUsers();

        if (!$comment) {
            AlertService::add('danger', "Ce commentaire n'existe pas.");
            header("location: /admin/commentaires");
            exit;
        }

        foreach ($users as $user) {
            if ($user->id == $comment->user_id) {
                $comment->user_surname = $user->surname;
            }
        }

        foreach ($posts as $post) {
            if ($post->id == $comment->post_id) {
                $comment->post_title = $post->title;
                $comment->post_content = $post->content;
            }
        }

        return $comment;
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
        $comment = $this->getCommentDetails($commentId);
        require(__DIR__.'/../../templates/admin/comments/valid_comments_page.php');
    }

    /**
     * Allow an administrator to confirm the validation of a comment.
     *
     * This function retrieves a comment based on its identifier and proceeds to confirm its validation.
     *
     * @param mixed $commentId The identifier of the comment to be confirmed for validation.
     * @return void
     */
    public function postConfirmComment($commentId)
    {
        $comment = $this->commentRepository->getCommentById($commentId);

        if(!$comment) {
            AlertService::add('danger', "Ce commentaire n'existe pas.");
            header("location: /admin/commentaires");
            exit;
        }

        $comment->confirm($commentId, 1);

        $this->commentRepository->confirmComment($comment);

        AlertService::add('success', "Le commentaire de ". $comment->user_surname ." a bien été validé.");
        header("location: /admin/commentaires");
        exit;
    }


    /**
     * Display the page for deleting a specific comment.
     *
     * This function retrieves a comment based on its identifier and also fetches all posts and users.
     * It associates the user and post information with the comment for display on the deletion page.
     *
     * @param mixed $commentId The identifier of the comment for which the deletion page is displayed.
     * @return void
     */
    public function getDeleteComment($commentId)
    {
        $comment = $this->getCommentDetails($commentId);
        require(__DIR__.'/../../templates/admin/comments/delete_comments_page.php');
    }

    /**
    * Delete a comment marked for deletion by an administrator.
    *
    * This function retrieves a comment based on its identifier and proceeds to mark it for deletion.
    *
    * @param mixed $commentId The identifier of the comment to be marked for deletion.
    * @return void
    */
    public function postDeleteComment($commentId)
    {
        $comment = $this->commentRepository->getCommentById($commentId);

        if(!$comment) {
            AlertService::add('danger', "Ce commentaire n'existe pas.");
            header("location: /admin/commentaires");
            exit;
        }

        $comment->delete($commentId, 0);

        $this->commentRepository->deleteComment($comment);

        AlertService::add('success', "Le commentaire de ". $comment->user_surname ." a bien été suprimé.");
        header("location: /admin/commentaires");
        exit;

    }

    /**
     * Display the page for restoring a specific comment.
     *
     * This function retrieves a comment based on its identifier and also fetches all posts and users.
     * It associates the user and post information with the comment for display on the restoration page.
     *
     * @param mixed $commentId The identifier of the comment for which the restoration page is displayed.
     * @return void
     */
    public function getRestoreComment($commentId)
    {
        $comment = $this->getCommentDetails($commentId);
        require(__DIR__.'/../../templates/admin/comments/restore_comments_page.php');
    }

    /**
     * Restore a comment marked for restoration by an administrator.
     *
     * This function retrieves a comment based on its identifier and proceeds to confirm its restoration.
     *
     * @param mixed $commentId The identifier of the comment to be restored.
     * @return void
     */
    public function postRestoreComment($commentId)
    {
        $comment = $this->commentRepository->getCommentById($commentId);

        if(!$comment) {
            AlertService::add('danger', "Ce commentaire n'existe pas.");
            header("location: /admin/commentaires");
            exit;
        }

        $comment->confirm($commentId, 1);

        $this->commentRepository->confirmComment($comment);

        AlertService::add('success', "Le commentaire de ". $comment->user_surname ." a bien été restauré.");
        header("location: /admin/commentaires");
        exit;
    }
}
