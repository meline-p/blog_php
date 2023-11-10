<?php

require_once('lib/database.php');
require_once('Model/Repository/UserRepository.php');
require_once('Model/Repository/PostRepository.php');

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use Repository\UserRepository;
use Repository\PostRepository;

$databaseConnection = new \DatabaseConnection();

// Création des instances de UserRepository et PostRepository
$userRepository = new UserRepository($databaseConnection);
$postRepository = new PostRepository($databaseConnection);

$uri = $_SERVER['REQUEST_URI'];

if ($uri === '/') {
    $homeController = new HomeController($userRepository, $postRepository);
    $homeController->home();
} elseif ($uri === '/se-connecter') {
    $loginController = new LoginController($userRepository);
    $loginController->login();
} elseif ($uri === '/posts') {
    echo 'post';
} elseif (1 === preg_match("/^\/posts\/(?<id>\d+)$/", $uri, $matches)) {
    $id = $matches['id'];
    var_dump($id);
}
