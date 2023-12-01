<?php

namespace App\controllers;

use App\Model\Repository\CommentRepository;
use App\Model\Repository\UserRepository;
use App\Model\Repository\PostRepository;
use App\lib\DatabaseConnection;
use App\Model\Entity\Comment;

class CommentsController
{
    private $commentRepository;
    private $userRepository;
    private $postRepository;
    private $currentTime;

    public function __construct(DatabaseConnection $connection)
    {
        $this->commentRepository = new CommentRepository($connection);
        $this->userRepository = new UserRepository($connection);
        $this->postRepository = new PostRepository($connection);
        $this->currentTime = date('Y-m-d H:i:s');
    }

    public function getComments()
    {
        $comments = $this->commentRepository->getComments();
        require(__DIR__.'/../../templates/admin/admin_comments_list_page.php');
    }

    public function getValidComments($postId)
    {
        $comments = $this->commentRepository->getValidComments($postId);
    }

    public function postAddComment($data)
    {
        if (!isset($_SESSION['LOGGED_USER'])) {
            echo "Vous devez être connecté pour ajouter un commentaire.";
            return;
        }

        if (empty($commentContent)) {
            echo "Veuillez remplir le champ commentaire.";
            return;
        }

        if (!ctype_digit($data["post_id"])) {
            echo "ID non valide.";
            return;
        }

        $comment = new Comment();

        $comment->init(
            $_SESSION['USER_ID'],
            intval($data['post_id']),
            nl2br(htmlspecialchars($data['content'])),
            null
        );

        $this->commentRepository->addComment($comment);

        echo "Votre commentaire a bien été ajouté.";
    }

    // Confirm
    public function getConfirmComment($commentId)
    {
        $comment = $this->commentRepository->getCommentById($commentId);
        require(__DIR__.'/../../templates/admin/comments/valid_comment_page.php');
    }

    public function postConfirmComment($data)
    {
        $comment = $this->commentRepository->getCommentById($data["id"]);

        if($comment) {

            $comment->confirm($data["id"], 1);

            $this->commentRepository->confirmComment($comment);

            require(__DIR__.'/../../templates/admin/admin_comments_list_page.php');

        } else {
            echo 'Ce commentaire n\'existe pas';
        }
    }

    // Delete
    public function getDeleteComment($commentId)
    {

        $comment = $this->commentRepository->getCommentById($commentId);
        require(__DIR__.'/../../templates/admin/comments/delete_comment_page.php');
    }

    public function postDeleteComment($data)
    {
        $comment = $this->commentRepository->getCommentById($data["id"]);

        if($comment) {

            $comment->delete($data["id"], 0);

            $this->commentRepository->deleteComment($comment);

            require(__DIR__.'/../../templates/admin/admin_comments_list_page.php');

        } else {
            echo 'Ce commentaire n\'existe pas';
        }
    }

    // Restore
    public function getRestoreComment($commentId)
    {
        $comment = $this->commentRepository->getCommentById($commentId);
        require(__DIR__.'/../../templates/admin/comments/restore_comment_page.php');
    }

    public function postRestoreComment($data)
    {
        $comment = $this->commentRepository->getCommentById($data["id"]);

        if($comment) {
            $comment->confirm($data["id"], 1);

            $this->commentRepository->confirmComment($comment);

            require(__DIR__.'/../../templates/admin/admin_comments_list_page.php');

        } else {
            echo 'Ce commentaire n\'existe pas';
        }
    }


}
