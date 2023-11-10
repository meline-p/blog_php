<?php

namespace App\controllers;

use Repository\PostRepository;
use DatabaseConnection;

require_once('src/lib/database.php');
require_once('src/Model/post.php');
require_once('src/Model/comment.php');

class PostsListController
{
    public function getPosts()
    {
        $connection = new \DatabaseConnection();

        $postRepository = new PostRepository($connection);
        $posts = $postRepository->getAllPosts();

        require('templates/posts_list_page.php');
    }
}
