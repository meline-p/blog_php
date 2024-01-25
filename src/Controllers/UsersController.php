<?php

namespace App\controllers;

use App\Model\Repository\UserRepository;
use App\Model\Repository\PostRepository;
use App\Model\Repository\CommentRepository;
use App\lib\DatabaseConnection;
use App\Model\Entity\User;

class UsersController
{
    private $userRepository;
    private $postRepository;
    private $commentRepository;
    private $currentTime;

    public function __construct(DatabaseConnection $connection)
    {
        $this->userRepository = new UserRepository($connection);
        $this->postRepository = new PostRepository($connection);
        $this->commentRepository = new CommentRepository($connection);
        $this->currentTime = date('Y-m-d H:i:s');
    }


    public function getUsers()
    {
        $users = $this->userRepository->getUsers();
        require_once(__DIR__ . '/../../templates/admin/admin_users_list_page.php');
    }

    public function getAdmins()
    {
        $admins = $this->userRepository->getAdmins();
    }

    public function getUserById($userId)
    {
        $this->userRepository->getUserById($userId);
    }

    public function administration()
    {

        $nbPosts = $this->postRepository->countAllPosts();
        $nbComments = $this->commentRepository->countAllComments();
        $nbUsers = $this->userRepository->countAllUsers();

        $email = "";
        $surname = "";
        $loggedIn = false;
        $loggedUser = [];
        $admins = $this->userRepository->getAdmins();

        if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
        isset($_POST['password']) && !empty($_POST['password'])) {
            $loggedIn = false;
            foreach ($admins as $admin) {
                if ($admin['email'] === $_POST['email'] && $admin['password'] === $_POST['password']) {
                    $loggedUser = [
                        'email' => $admin['email'],
                        'surname' => $admin['surname'],
                    ];
                    $loggedIn = true;
                    $_SESSION['LOGGED_ADMIN'] = $admin['surname'];
                    break;
                }
            }

            if ($loggedIn) {
                $email = $loggedUser['email'];
                $surname = $loggedUser['surname'];
            }
        }

        require_once(__DIR__ . '/../../templates/admin/dashboard_page.php');
    }

    public function getLogin()
    {

        $email = "";
        $surname = "";
        $loggedIn = false;
        $errorMessage = "";

        if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
        isset($_POST['password']) && !empty($_POST['password'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $loggedIn = $this->userRepository->login($email, $password);

            if ($loggedIn) {
                $userId = $_SESSION['USER_ID'];
                $user = $this->userRepository->getUserById($userId);

                if($user) {
                    $surname = $user->surname;
                    $_SESSION['LOGGED_USER'] = $surname;

                    // Check if user = admin
                    if (isset($user->role_id) && $user->role_id === 1) {
                        $_SESSION['IS_ADMIN'] = true;
                        $_SESSION['LOGGED_ADMIN'] = $surname;
                    }
                } else {
                    $errorMessage = 'Les informations envoyées ne permettent pas de vous identifier.';
                }
            }
        }
        require_once(__DIR__ . '/../../templates/login_page.php');
    }

    public function getLogout()
    {

        session_destroy();
        require_once(__DIR__ . '/../../templates/login_page.php');
    }


    public function postLogin($email, $password)
    {

        $this->userRepository->login($email, $password);
        require_once(__DIR__ . '/../../templates/homepage_page.php');
    }

    public function getRegister()
    {

        require_once(__DIR__ . '/../../templates/register_page.php');
    }

    public function postRegister($data)
    {
        $user = new User();
        $user->init(
            $data['role_id'],
            $data['last_name'],
            $data['first_name'],
            $data['surname'],
            $data['email'],
            $data['password']
        );

        $this->userRepository->addUser($user);

        require('templates/homepage_page.php');
    }

    public function getDeleteUser($userId)
    {
        $user = $this->userRepository->getUserById($userId);
        require('templates/admin/users/delete_user_page.php');
    }

    public function postDeleteUser($data)
    {
        $user = $this->userRepository->getUserById($data['id']);

        if($user) {
            $user->delete($data['id']);

            $this->userRepository->deleteUser($user);

            require('templates/admin/admin_users_list_page.php');

        } else {
            echo 'Cet utilisateur n\'existe pas';
        }
    }

    public function getRestoreUser($userId)
    {
        $user = $this->userRepository->getUserById($userId);
        require('templates/admin/users/restore_user_page.php');
    }

    public function postRestoreUser($data)
    {
        $user = $this->userRepository->getUserById($data['id']);

        if($user) {
            $user->restore($data['id']);

            $this->userRepository->restoreUser($user);

            require('templates/admin/admin_users_list_page.php');

        } else {
            echo 'Cet utilisateur n\'existe pas';
        }
    }
}
