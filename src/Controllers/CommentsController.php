<?php

namespace App\controllers;

use App\lib\AlertService;
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

        var_dump(empty($data['content']));

        if (!isset($_SESSION['user'])) {
            AlertService::add('danger', 'Vous devez être connecté pour ajouter un commentaire.');
            return;
        }

        if ($data['content'] == '') {
            AlertService::add('danger', 'Veuillez remplir le champ commentaire.');
            return;
        }

        if (!ctype_digit($data["post_id"])) {
            echo "ID non valide.";
            AlertService::add('danger', 'ID non valide');
            return;
        }

        $comment = new Comment();

        $comment->init(
            $_SESSION['user']->id,
            intval($data['post_id']),
            nl2br(htmlspecialchars($data['content'])),
            null
        );

        $this->commentRepository->addComment($comment);

        echo "Votre commentaire a bien été ajouté.";

        AlertService::add('success', 'Votre commentaire a bien été ajouté.');
        header("location: /publication/".$comment->post_id);
        exit;
    }

    // Confirm
    public function getConfirmComment($commentId)
    {
        $comment = $this->commentRepository->getCommentById($commentId);
        $posts = $this->postRepository->getAllPosts();
        $users = $this->userRepository->getUsers();

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
        require(__DIR__.'/../../templates/admin/comments/valid_comments_page.php');
    }

    public function postConfirmComment($id)
    {
        $comment = $this->commentRepository->getCommentById($id);

        if($comment) {

            $comment->confirm($id, 1);

            $this->commentRepository->confirmComment($comment);

            AlertService::add('success', "Le commentaire de ". $comment->user_surname ." a bien été validé.");

            header("location: /admin/commentaires");
            exit;

        } else {
            echo 'Ce commentaire n\'existe pas';
        }
    }

    // Delete
    public function getDeleteComment($commentId)
    {
        $comment = $this->commentRepository->getCommentById($commentId);
        $posts = $this->postRepository->getAllPosts();
        $users = $this->userRepository->getUsers();

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

        require(__DIR__.'/../../templates/admin/comments/delete_comments_page.php');
    }

    public function postDeleteComment($id)
    {
        $comment = $this->commentRepository->getCommentById($id);

        if($comment) {

            $comment->delete($id, 0);

            $this->commentRepository->deleteComment($comment);

            AlertService::add('success', "Le commentaire de ". $comment->user_surname ." a bien été suprimé.");

            header("location: /admin/commentaires");
            exit;

        } else {
            echo 'Ce commentaire n\'existe pas';
        }
    }

    // Restore
    public function getRestoreComment($commentId)
    {
        $comment = $this->commentRepository->getCommentById($commentId);
        $posts = $this->postRepository->getAllPosts();
        $users = $this->userRepository->getUsers();

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
        require(__DIR__.'/../../templates/admin/comments/restore_comments_page.php');
    }

    public function postRestoreComment($id)
    {
        $comment = $this->commentRepository->getCommentById($id);

        if($comment) {
            $comment->confirm($id, 1);

            $this->commentRepository->confirmComment($comment);

            AlertService::add('success', "Le commentaire de ". $comment->user_surname ." a bien été restauré.");

            header("location: /admin/commentaires");
            exit;

        } else {
            echo 'Ce commentaire n\'existe pas';
        }
    }


}
