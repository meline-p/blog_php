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
        $this->postRepository = new PostRepository($connection);
        $this->commentRepository = new CommentRepository($connection);
        $this->userRepository = new UserRepository($connection);
        $this->currentTime = date('Y-m-d H:i:s');
    }


    /**
     * Display the list of all posts for administration
     *
     * @return void
     */
    public function getPosts()
    {
        $posts = $this->postRepository->getAllPosts();
        require_once(__DIR__.'/../../templates/admin/admin_posts_list_page.php');
    }

    /**
     * Display the list of published posts.
     *
     * @return void
     */
    public function getPublishedPosts()
    {
        $posts = $this->postRepository->getPublishedPosts();
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
        $post = $this->postRepository->getPostById($postId);
        $user = $this->userRepository->getUserById($post->user_id);
        $comments = $this->commentRepository->getValidComments($post->id);

        if(!$post) {
            require_once(__DIR__ . '/../../templates/error_page.php');
        } else {
            require(__DIR__.'/../../templates/show_post_page.php');
        }
    }

    /**
     * Display the add post page for administrators.
     *
     * @return void
     */
    public function getAddPost()
    {
        $admins = $this->userRepository->getAdmins();
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

    /**
     * Display the edit post page for administrators.
     *
     * @param  mixed $postId The ID of the post to be edited.
     * @return void
     */
    public function getEditPost($postId)
    {
        $post = $this->postRepository->getPostById($postId);
        $admins = $this->userRepository->getAdmins();

        if(!$post) {
            AlertService::add('danger', "Cette publication n'existe pas.");
            header("location: /admin/publications");
            exit;
        }

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
        if (empty($data["user_id"]) || empty($data["title"]) || empty($data["content"])) {
            AlertService::add('danger', "Veuillez fournir toutes les informations nécessaires.");
            header("location: /admin/publication/modifier/$postId");
            exit;
        }

        $post = $this->postRepository->getPostById($postId);

        if(!$post) {
            AlertService::add('danger', "Cette publication n'existe pas.");
            header("location: /admin/publications");
            exit;
        }

        $post->update(
            $data["title"],
            $data["chapo"],
            $data["content"],
            $data["user_id"],
            isset($data["is_published"]) ? 1 : 0
        );

        $this->postRepository->editPost($post);

        AlertService::add('success', "La publication ". $post->title ." a bien été modifiée.");
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
        $post = $this->postRepository->getPostById($postId);
        $admins = $this->userRepository->getAdmins();

        if(!$post) {
            AlertService::add('danger', "Cette publication n'existe pas.");
            header("location: /admin/publications");
            exit;
        }

        foreach ($admins as $admin) {
            if ($admin->id == $post->user_id) {
                $post->user_surname = $admin->surname;
            }
        }

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
        $post = $this->postRepository->getPostById($postId);

        if(!$post) {
            AlertService::add('danger', "Cette publication n'existe pas.");
            header("location: /admin/publications");
            exit;
        }

        $post->delete($postId, 0);
        $this->postRepository->deletePost($post);

        AlertService::add('success', "La publication ". $post->title ." a bien été supprimée.");
        header("location: /admin/publications");
        exit;
    }

    /**
     * Display the restore post page for administrators.
     *
     * @param  mixed $postId The ID of the post to be restored.
     * @return void
     */
    public function getRestorePost($postId)
    {
        $post = $this->postRepository->getPostById($postId);
        $admins = $this->userRepository->getAdmins();

        if(!$post) {
            AlertService::add('danger', "Cette publication n'existe pas.");
            header("location: /admin/publications");
            exit;
        }

        foreach ($admins as $admin) {
            if ($admin->id == $post->user_id) {
                $post->user_surname = $admin->surname;
            }
        }

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
        $post = $this->postRepository->getPostById($postId);

        if(!$post) {
            AlertService::add('danger', "Cette publication n'existe pas.");
            header("location: /admin/publications");
            exit;
        }

        $post->restore($postId);
        $this->postRepository->restorePost($post);

        AlertService::add('success', "La publication ". $post->title ." a bien été restaurée.");
        header("location: /admin/publications");
        exit;
    }

}
