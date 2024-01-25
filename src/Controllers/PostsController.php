<?php

namespace App\controllers;

use App\lib\AlertService;
use App\Model\Repository\PostRepository;
use App\Model\Repository\CommentRepository;
use App\Model\Repository\UserRepository;
use App\lib\DatabaseConnection;
use App\Model\Entity\Post;

class PostsController
{
    private $postRepository;
    private $commentRepository;
    private $userRepository;
    private $currentTime;

    public function __construct(DatabaseConnection $connection)
    {
        $this->postRepository = new PostRepository($connection);
        $this->commentRepository = new CommentRepository($connection);
        $this->userRepository = new UserRepository($connection);
        $this->currentTime = date('Y-m-d H:i:s');
    }


    public function getPosts()
    {
        $posts = $this->postRepository->getAllPosts();
        require_once(__DIR__.'/../../templates/admin/admin_posts_list_page.php');
    }

    public function getPublishedPosts()
    {

        $posts = $this->postRepository->getPublishedPosts();
        require(__DIR__.'/../../templates/posts_list_page.php');
    }

    public function getPostById($postId)
    {
        $post = $this->postRepository->getPostById($postId);
        $comments = $this->commentRepository->getValidComments($post->id);
        require(__DIR__.'/../../templates/show_post_page.php');
    }

    public function getAddPost()
    {
        $admins = $this->userRepository->getAdmins();
        require(__DIR__.'/../../templates/admin/posts/add_post_page.php');
    }

    public function postAddPost($data)
    {
        $user = $this->userRepository->getUserById($data["user_id"]);

        $post = new Post();
        $post->init(
            $data["title"],
            $data["chapo"],
            $data["content"],
            intval($data["user_id"]),
            isset($data["is_published"]) ? 1 : 0
        );

        $this->postRepository->addPost($post);

        AlertService::add('success', "La publication " . $post->title . " a bien été ajoutée.");

        header("location: /admin/publications");
        exit;
    }

    public function getEditPost($postId)
    {
        $post = $this->postRepository->getPostById($postId);
        $admins = $this->userRepository->getAdmins();
        require(__DIR__.'/../../templates/admin/posts/edit_post_page.php');
    }

    public function postEditPost($id, $data)
    {
        if (!isset($id) || empty($data["user_id"]) || empty($data["title"]) || empty($data["content"])) {
            AlertService::add('danger', "Veuillez fournir toutes les informations nécessaires.");

            header("location: /admin/publication/modifier/$id");
            exit;
        }

        $post = $this->postRepository->getPostById($id);

        if(!$post) {
            echo 'Ce post n\'existe pas';
            return;
        }

        $post->update(
            $data["title"],
            $data["chapo"],
            $data["content"],
            $data["user_id"],
            isset($data["is_published"]) ? 1 : 0
        );

        $this->postRepository->editPost($post);

        AlertService::add('success', "La publication ". $data["title"] ." a bien été modifiée.");

        header("location: /admin/publications");
        exit;

    }

    public function getDeletedPost($postId)
    {
        $post = $this->postRepository->getPostById($postId);
        $admins = $this->userRepository->getAdmins();

        foreach ($admins as $admin) {
            if ($admin->id == $post->user_id) {
                $post->user_surname = $admin->surname;
            }
        }

        require(__DIR__.'/../../templates/admin/posts/delete_post_page.php');
    }


    public function postDeletePost($id)
    {
        if (!isset($id)) {
            echo "Veuillez fournir l'identifiant du post.";
            return;
        }

        $post = $this->postRepository->getPostById($id);

        if($post) {
            $post->delete($id, 0);

            $this->postRepository->deletePost($post);

            AlertService::add('success', "La publication ". $post->title ." a bien été supprimée.");

            header("location: /admin/publications");
            exit;

        } else {
            echo 'Ce post n\'existe pas';
        }
    }

    public function getRestorePost($postId)
    {
        $post = $this->postRepository->getPostById($postId);
        $admins = $this->userRepository->getAdmins();

        foreach ($admins as $admin) {
            if ($admin->id == $post->user_id) {
                $post->user_surname = $admin->surname;
            }
        }
        require(__DIR__.'/../../templates/admin/posts/restore_post_page.php');
    }

    public function postRestorePost($id)
    {
        $post = $this->postRepository->getPostById($id);

        if($post) {
            $post->restore($id);

            $this->postRepository->restorePost($post);

            AlertService::add('success', "La publication ". $post->title ." a bien été restaurée.");

            header("location: /admin/publications");
            exit;
        } else {
            echo 'Ce post n\'existe pas';
        }
    }

}
