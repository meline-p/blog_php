<?php

namespace App\controllers;

use App\Model\Repository\PostRepository;
use App\lib\DatabaseConnection;
use App\Model\Entity\Post;

class PostsController
{
    private $postRepository;
    private $currentTime;

    public function __construct(DatabaseConnection $connection)
    {
        $this->postRepository = new PostRepository($connection);
        $this->currentTime = date('Y-m-d H:i:s');
    }


    public function getPosts()
    {
        $this->postRepository->getAllPosts();
        require(__DIR__.'/../../public/templates/admin/admin_posts_list_page.php');
    }

    public function getPublishedPosts()
    {
        $posts = $this->postRepository->getPublishedPosts();
        require(__DIR__.'/../../public/templates/post_list_page.php');
    }

    public function getPostById($postId)
    {
        $this->postRepository->getPostById($postId);
    }

    public function getAddPost()
    {
        require(__DIR__.'/../../public/templates/admin/posts/add_post_page.php');
    }

    public function postAddPost($user_id, $title, $chapo, $content, $is_published)
    {
        $post = new Post();
        $post->setTitle($title);
        $post->setChapo($chapo);
        $post->setContent($content);
        $post->setAuthor($user_id);
        $post->setIsPublished($is_published);
        $post->setCreatedAt($this->currentTime);
        $post->setUpdatedAt($this->currentTime);

        $this->postRepository->addPost($post);

        require('templates/admin/admin_posts_list_page.php');
    }

    public function getEditPost($postId)
    {
        $post = $this->postRepository->getPostById($postId);
        require('templates/admin/posts/edit_post_page.php');
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

            require('templates/admin/admin_posts_list_page.php');
        } else {
            echo 'Ce post n\'existe pas';
        }
    }

    public function getDeletedPost($postId)
    {
        $post = $this->postRepository->getPostById($postId);
        require('templates/admin/posts/delete_post_page.php');
    }

    public function postDeletePost($postId)
    {
        $post = $this->postRepository->getPostById($postId);

        if($post) {
            $post->setIsPublished(0);
            $post->setUpdatedAt($this->currentTime);
            $post->setDeletedAt($this->currentTime);

            $this->postRepository->deletePost($post);

            require('templates/admin/admin_posts_list_page.php');

        } else {
            echo 'Ce post n\'existe pas';
        }
    }

    public function getRestorePost($postId)
    {
        $post = $this->postRepository->getPostById($postId);
        require('templates/admin/posts/restore_post_page.php');
    }

    public function restorePost($postId)
    {
        $post = $this->postRepository->getPostById($postId);

        if($post) {
            $post->setDeletedAt(null);
            $post->setUpdatedAt($this->currentTime);

            $this->postRepository->restorePost($post);

            require('templates/admin/admin_posts_list_page.php');
        } else {
            echo 'Ce post n\'existe pas';
        }
    }

}
