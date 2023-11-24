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
        $allComments = $this->commentRepository->getComments();
        require(__DIR__.'/../../templates/admin/admin_comments_list_page.php');
    }

    public function getValidComments($postId)
    {
        $comments = $this->commentRepository->getValidComments($postId);
    }


    public function postAddComment($commentContent, $postId)
    {
        if (!isset($_SESSION['LOGGED_USER'])) {
            echo "Vous devez être connecté pour ajouter un commentaire.";
            return;
        }

        if (empty($commentContent)) {
            echo "Veuillez remplir le champ commentaire.";
            return;
        }

        if (!ctype_digit($postId)) {
            echo "ID non valide.";
            return;
        }

        $comment = new Comment();
        $comment->setAuthor($_SESSION['USER_ID']);
        $comment->setPostId(intval($postId));
        $comment->setContent(nl2br(htmlspecialchars($commentContent)));
        $comment->setCreatedAt($this->currentTime);
        $comment->setIsEnabled(null);

        $this->commentRepository->addComment($comment);

        echo "Votre commentaire a bien été ajouté.";
    }

    // Confirm
    public function getConfirmComment($commentId)
    {
        $comment = $this->commentRepository->getCommentById($commentId);
        require(__DIR__.'/../../templates/admin/comments/valid_comment_page.php');
    }

    public function postConfirmComment($commentId)
    {
        $comment = $this->commentRepository->getCommentById($commentId);

        if($comment) {
            $comment->setIsEnabled(1);
            $comment->setDeletedAt(null);

            $this->commentRepository->editComment($comment);

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

    public function postDeleteComment($commentId)
    {
        $comment = $this->commentRepository->getCommentById($commentId);

        if($comment) {
            $comment->setIsEnabled(0);
            $comment->setDeletedAt($this->currentTime);

            $this->commentRepository->editComment($comment);

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

    public function postRestoreComment($commentId)
    {
        $comment = $this->commentRepository->getCommentById($commentId);

        if($comment) {
            $comment->setIsEnabled(1);
            $comment->setDeletedAt(null);

            $this->commentRepository->editComment($comment);

            require(__DIR__.'/../../templates/admin/admin_comments_list_page.php');

        } else {
            echo 'Ce commentaire n\'existe pas';
        }
    }


}
