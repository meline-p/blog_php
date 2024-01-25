<?php

namespace App\controllers;

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
        if (!isset($data["title"]) || !isset($data["content"])) {
            echo "Veuillez remplir les champs Titre et Contenu.";
            return;
        }


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

        require(__DIR__.'/../../templates/admin/posts/post_add_page.php');
    }


    public function getEditPost($postId)
    {
        $post = $this->postRepository->getPostById($postId);
        $admins = $this->userRepository->getAdmins();
        require(__DIR__.'/../../templates/admin/posts/edit_post_page.php');
    }

    public function postEditPost($data)
    {

        if (!isset($data["post_id"]) || !isset($data["user_id"]) || !isset($data["title"]) || !isset($data["content"])) {
            echo "Veuillez fournir toutes les informations nécessaires.";
            return;
        }

        $post = $this->postRepository->getPostById($data["post_id"]);

        if ($post) {
            $post->update(
                $data["title"],
                $data["chapo"],
                $data["content"],
                $data["user_id"],
                isset($data["is_published"]) ? 1 : 0
            );

            $this->postRepository->editPost($post);

            require(__DIR__.'/../../templates/admin/admin_posts_list_page.php');
        } else {
            echo 'Ce post n\'existe pas';
        }
    }

    public function getDeletedPost($postId)
    {
        $post = $this->postRepository->getPostById($postId);
        require(__DIR__.'/../../templates/admin/posts/delete_post_page.php');
    }

    public function postDeletePost($data)
    {
        if (!isset($data["post_id"])) {
            echo "Veuillez fournir l'identifiant du post.";
            return;
        }

        $post = $this->postRepository->getPostById($data["post_id"]);

        if($post) {
            $post->delete($data["post_id"], 0);

            $this->postRepository->deletePost($post);

            require(__DIR__.'/../../templates/admin/admin_posts_list_page.php');

        } else {
            echo 'Ce post n\'existe pas';
        }
    }

    public function getRestorePost($postId)
    {
        $post = $this->postRepository->getPostById($postId);
        require(__DIR__.'/../../templates/admin/posts/restore_post_page.php');
    }

    public function postRestorePost($data)
    {
        $post = $this->postRepository->getPostById($data["post_id"]);

        if($post) {
            $post->restore($data["post_id"]);

            $this->postRepository->restorePost($post);

            require(__DIR__.'/../../templates/admin/admin_posts_list_page.php');
        } else {
            echo 'Ce post n\'existe pas';
        }
    }

}
