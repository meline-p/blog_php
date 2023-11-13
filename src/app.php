<?php

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\controllers\PostsController;
use App\lib\DatabaseConnection;
use App\Model\Repository\PostRepository;
use App\Model\Repository\UserRepository;

$databaseConnection = new DatabaseConnection();

// Création des instances de UserRepository et PostRepository
$userRepository = new UserRepository($databaseConnection);
$postRepository = new PostRepository($databaseConnection);

$uri = $_SERVER['REQUEST_URI'];

if ($uri === '/') {
    $homeController = new HomeController($userRepository, $postRepository);
    $homeController->home();
} elseif($uri === '/posts') {
    $postsController = new PostsController($databaseConnection);
    $postsController->getPublishedPosts();

} elseif ($uri === '/se-connecter') {
    $loginController = new LoginController($userRepository);
    $loginController->login();
} elseif (1 === preg_match("/^\/post\/(?<id>\d+)$/", $uri, $matches)) {
    $id = $matches['id'];
    var_dump($id);
}
