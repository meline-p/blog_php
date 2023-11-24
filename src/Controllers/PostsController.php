<?php

namespace App\controllers;

use App\Model\Repository\PostRepository;
use App\Model\Repository\UserRepository;
use App\lib\DatabaseConnection;
use App\Model\Entity\Post;

class PostsController
{
    private $postRepository;
    private $userRepository;
    private $currentTime;

    public function __construct(DatabaseConnection $connection)
    {
        $this->postRepository = new PostRepository($connection);
        $this->userRepository = new UserRepository($connection);
        $this->currentTime = date('Y-m-d H:i:s');
    }


    public function getPosts()
    {
        $allPosts = $this->postRepository->getAllPosts();
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
        require(__DIR__.'/../../templates/show_post_page.php');
    }

    public function getAddPost()
    {
        $admins = $this->userRepository->getAdmins();
        require(__DIR__.'/../../templates/admin/posts/add_post_page.php');
    }

    public function postAddPost($user_id, $title, $chapo, $content, $is_published)
    {
        var_dump($title, $content);
        if (!isset($title) || !isset($content)) {
            echo "Veuillez remplir les champs Titre et Contenu.";
            return;
        }

        $user = $this->userRepository->getUserById($user_id);
        $user_surname = $user['surname'];

        $post = new Post();
        $post->setTitle($title);
        $post->setChapo($chapo);
        $post->setContent($content);
        $post->setAuthor($user_id);
        $post->setIsPublished($is_published);
        $post->setCreatedAt($this->currentTime);
        $post->setUpdatedAt($this->currentTime);

        $this->postRepository->addPost($post);

        require(__DIR__.'/../../templates/admin/posts/post_add_page.php');
    }


    public function getEditPost($postId)
    {
        $post = $this->postRepository->getPostById($postId);
        require(__DIR__.'/../../templates/admin/posts/edit_post_page.php');
    }

    public function postEditPost($postId, $user_id, $title, $chapo, $content, $is_published)
    {
        $post = $this->postRepository->getPostById($postId);

        if($post) {
            $post->setTitle($title);
            $post->setChapo($chapo);
            $post->setContent($content);
            $post->setAuthor($user_id);
            $post->setIsPublished($is_published);
            $post->setUpdatedAt($this->currentTime);

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

    public function postDeletePost($postId)
    {
        $post = $this->postRepository->getPostById($postId);

        if($post) {
            $post->setIsPublished(0);
            $post->setUpdatedAt($this->currentTime);
            $post->setDeletedAt($this->currentTime);

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

    public function postRestorePost($postId)
    {
        $post = $this->postRepository->getPostById($postId);

        if($post) {
            $post->setDeletedAt(null);
            $post->setUpdatedAt($this->currentTime);

            $this->postRepository->restorePost($post);

            require(__DIR__.'/../../templates/admin/admin_posts_list_page.php');
        } else {
            echo 'Ce post n\'existe pas';
        }
    }

}
