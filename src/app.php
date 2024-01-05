<?php

use App\Controllers\HomeController;
use App\Controllers\UsersController;
use App\controllers\PostsController;
use App\controllers\CommentsController;
use App\Controllers\AuthController;
use App\lib\AlertService;
use App\lib\DatabaseConnection;
use App\Model\Repository\PostRepository;
use App\Model\Repository\UserRepository;
use App\Model\Repository\CommentRepository;

session_start();

$databaseConnection = new DatabaseConnection();

// Création des instances de UserRepository et PostRepository
$userRepository = new UserRepository($databaseConnection);
$postRepository = new PostRepository($databaseConnection);
$commentRepository = new CommentRepository($databaseConnection);

$uri = $_SERVER['REQUEST_URI'];

// ----------------- HOMEPAGE ----------------
if ($uri === '/') {
    $homeController = new HomeController($userRepository, $postRepository);
    $homeController->home();

} elseif($uri === '/message-envoye') {
    $homeController = new HomeController($userRepository, $postRepository);
    $homeController->sendMessage();


// ----------------- POSTS ----------------
} elseif($uri === '/publications') {
    $postsController = new PostsController($databaseConnection);
    $postsController->getPublishedPosts();

} elseif (1 === preg_match("/^\/publication\/(?<id>\d+)$/", $uri, $matches)) {
    $id = $matches['id'];
    $postsController = new PostsController($databaseConnection);
    $postsController->getPostById($id);

} elseif ((1 === preg_match("/^\/publication\/(?<id>\d+)\/commenter$/", $uri, $matches)) &&
    $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $matches['id'];
    if(isset($_SESSION['user']) && isset($_POST['comment'])) {
        $commentsController = new CommentsController($databaseConnection);
        $commentsController->postAddComment($id, $_POST);
    }


// ----------------- LOGIN / LOGOUT / REGISTER ----------------
} elseif ($uri === '/connexion') {
    $authController = new AuthController($databaseConnection);
    $authController->getLogin();

} elseif ($uri === '/deconnexion') {
    $authController = new AuthController($databaseConnection);
    $authController->getLogout();

} elseif ($uri === '/inscription') {
    $authController = new AuthController($databaseConnection);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['surname']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password'])) {
            $authController->postRegister($_POST);
        }
    } else {
        $authController->getRegister();
    }



// ------------------------------- ADMIN -------------------------------
} elseif (1 === preg_match('~^/admin~', $uri) && !($_SESSION['user'] && $_SESSION['user']->role_name === 'Administrateur')) {
    AlertService::add('danger', 'Veuillez vous connecter');

    header('location: /connexion');
    exit;


} elseif ($uri === '/admin/dashboard') {
    $authController = new AuthController($databaseConnection);
    $authController->administration();



// ----------------- USERS ----------------
} elseif ($uri === '/admin/utilisateurs') {
    $userController = new UsersController($databaseConnection);
    $userController->getUsers();

// ---- USER ADD ----
} elseif ($uri === '/admin/utilisateur/ajouter') {
    $userController = new UsersController($databaseConnection);
    $userController->getAddUser($_POST);

} elseif ($uri === '/admin/utilisateur/ajouter/confirmation') {
    $userController = new UsersController($databaseConnection);
    $userController->postAddUser($_POST);

// ---- USER EDIT ----
} elseif (1 === preg_match("~^/admin/utilisateur/modifier/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $userController = new UsersController($databaseConnection);
    $userController->getEditUser($id);

} elseif (1 === preg_match("~^/admin/utilisateur/modifier/confirmation/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $userController = new UsersController($databaseConnection);
    $userController->postEditUser($id, $_POST);

// ---- USER DELETE ----
} elseif (1 === preg_match("~^/admin/utilisateur/supprimer/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $userController = new UsersController($databaseConnection);
    $userController->getDeleteUser($id);

} elseif (1 === preg_match("~^/admin/utilisateur/supprimer/confirmation/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $userController = new UsersController($databaseConnection);
    $userController->postDeleteUser($id);

// ---- USER RESTORE ----
} elseif (1 === preg_match("~^/admin/utilisateur/restaurer/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $userController = new UsersController($databaseConnection);
    $userController->getRestoreUser($id);

} elseif (1 === preg_match("~^/admin/utilisateur/restaurer/confirmation/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $userController = new UsersController($databaseConnection);
    $userController->postRestoreUser($id);



// ------------------ POSTS ---------------
} elseif ($uri === '/admin/publications') {
    $postController = new PostsController($databaseConnection);
    $postController->getPosts();

// ---- POST ADD ----
} elseif ($uri === '/admin/publication/ajouter') {
    $postController = new PostsController($databaseConnection);
    $postController->getAddPost();

} elseif ($uri === '/admin/publication/ajouter/confirmation') {
    $postController = new PostsController($databaseConnection);
    $postController->postAddPost($_POST);

// ---- POST EDIT ----
} elseif (1 === preg_match("~^/admin/publication/modifier/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $postController = new PostsController($databaseConnection);
    $postController->getEditPost($id);

} elseif (1 === preg_match("~^/admin/publication/modifier/confirmation/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $postController = new PostsController($databaseConnection);
    $postController->postEditPost($id, $_POST);

// ---- POST DELETE -----
} elseif (1 === preg_match("~^/admin/publication/supprimer/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $postController = new PostsController($databaseConnection);
    $postController->getDeletedPost($id);

} elseif (1 === preg_match("~^/admin/publication/supprimer/confirmation/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $postController = new PostsController($databaseConnection);
    $postController->postDeletePost($id);

// ----- POST RESTORE -----
} elseif (1 === preg_match("~^/admin/publication/restaurer/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $postController = new PostsController($databaseConnection);
    $postController->getRestorePost($id);

} elseif (1 === preg_match("~^/admin/publication/restaurer/confirmation/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $postController = new PostsController($databaseConnection);
    $postController->postRestorePost($id);



// --------------------- COMMENTS -------------------
} elseif ($uri === '/admin/commentaires') {
    $commentController = new CommentsController($databaseConnection);
    $commentController->getComments();

// ----- COMMENT CONFIRM -----
} elseif (1 === preg_match("~^/admin/commentaire/valider/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $commentController = new CommentsController($databaseConnection);
    $commentController->getConfirmComment($id);

} elseif (1 === preg_match("~^/admin/commentaire/valider/confirmation/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $commentController = new CommentsController($databaseConnection);
    $commentController->postConfirmComment($id);

// ----- COMMENT DELETE -----
} elseif (1 === preg_match("~^/admin/commentaire/supprimer/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $commentController = new CommentsController($databaseConnection);
    $commentController->getDeleteComment($id);

} elseif (1 === preg_match("~^/admin/commentaire/supprimer/confirmation/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $commentController = new CommentsController($databaseConnection);
    $commentController->postDeleteComment($id);

// ----- COMMENT RESTORE -----
} elseif (1 === preg_match("~^/admin/commentaire/restaurer/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $commentController = new CommentsController($databaseConnection);
    $commentController->getRestoreComment($id);

} elseif (1 === preg_match("~^/admin/commentaire/restaurer/confirmation/(?<id>\d+)$~", $uri, $matches)) {
    $id = $matches['id'];
    $commentController = new CommentsController($databaseConnection);
    $commentController->postRestoreComment($id);
}
