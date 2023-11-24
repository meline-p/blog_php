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
        session_start();
        $posts = $this->postRepository->getAllPosts();
        $comments = $this->commentRepository->getComments();
        $users = $this->userRepository->getUsers();

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
        session_start();
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
                    $surname = $user['surname'];
                    $_SESSION['LOGGED_USER'] = $surname;

                    // Check if user = admin
                    if (isset($user['role_id']) && $user['role_id'] === 1) {
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
        session_start();
        session_destroy();
        require_once(__DIR__ . '/../../templates/login_page.php');
    }


    public function postLogin($email, $password)
    {
        session_start();
        $this->userRepository->login($email, $password);
        require_once(__DIR__ . '/../../templates/homepage_page.php');
    }

    public function getRegister()
    {
        session_start();
        require_once(__DIR__ . '/../../templates/register_page.php');
    }

    public function postRegister($role_id, $last_name, $first_name, $surname, $email, $password)
    {
        session_start();
        $user = new User();
        $user->setRoleId($role_id);
        $user->setLastName($last_name);
        $user->setFirstName($first_name);
        $user->setSurname($surname);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setCreatedAt($this->currentTime);

        $this->userRepository->addUser($user);

        require('templates/homepage_page.php');
    }

    public function getDeleteUser($userId)
    {
        $user = $this->userRepository->getUserById($userId);
        require('templates/admin/users/delete_user_page.php');
    }

    public function postDeleteUser($userId)
    {
        $user = $this->userRepository->getUserById($userId);

        if($user) {
            $user->setDeletedAt($this->currentTime);

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

    public function postRestoreUser($userId)
    {
        $user = $this->userRepository->getUserById($userId);

        if($user) {
            $user->setDeletedAt(null);

            $this->userRepository->restoreUser($user);

            require('templates/admin/admin_users_list_page.php');

        } else {
            echo 'Cet utilisateur n\'existe pas';
        }
    }
}
