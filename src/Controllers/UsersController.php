<?php

namespace App\controllers;

use App\lib\AlertService;
use App\Model\Repository\UserRepository;
use App\Model\Repository\PostRepository;
use App\Model\Repository\CommentRepository;
use App\Model\Repository\RoleRepository;
use App\lib\DatabaseConnection;
use App\Model\Entity\User;

class UsersController
{
    private $userRepository;
    private $postRepository;
    private $commentRepository;
    private $roleRepository;
    private $currentTime;

    public function __construct(DatabaseConnection $connection)
    {
        $this->userRepository = new UserRepository($connection);
        $this->postRepository = new PostRepository($connection);
        $this->commentRepository = new CommentRepository($connection);
        $this->roleRepository = new RoleRepository($connection);
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

    public function getUserByEmail($userEmail)
    {
        $this->userRepository->getUserById($userEmail);
    }

    public function administration()
    {
        $nbPosts = $this->postRepository->countAllPosts();
        $nbComments = $this->commentRepository->countAllComments();
        $nbUsers = $this->userRepository->countAllUsers();

        $admins = $this->userRepository->getAdmins();

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
            $enteredPassword = $_POST['password'];

            $user = $this->userRepository->getUserByEmail($email);

            $storedHashedPassword = $user->password;

            if(!$user || !password_verify($enteredPassword, $storedHashedPassword)) {
                AlertService::add('danger', 'Les informations envoyées ne permettent pas de vous identifier.');
                header("location: /connexion");
                exit;
            }

            $_SESSION['user'] = $user;
            $redirectBack = isset($_SESSION['redirect_back']) ? $_SESSION['redirect_back'] : '/';


            AlertService::add('success', 'Bienvenue sur le site ' . ($_SESSION['user']->surname ?? "") . ' !');
            header("location: " . $redirectBack);
            exit;

        }
        require_once(__DIR__ . '/../../templates/login_page.php');
    }

    /*
    $_SESSION['USER_ID'];
    $_SESSION['LOGGED_USER'] = $surname;
    $_SESSION['IS_ADMIN'] = true;
    $_SESSION['LOGGED_ADMIN'] = $surname;
     */

    public function getLogout()
    {
        session_destroy();
        header('location: /connexion');
        exit;
    }

    public function getRegister()
    {
        require_once(__DIR__ . '/../../templates/register_page.php');
    }

    public function postRegister($data)
    {
        $errorMessage = null;

        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        try {
            $user = new User();
            $user->init(
                2,
                $data['last_name'],
                $data['first_name'],
                $data['surname'],
                $data['email'],
                $hashedPassword
            );

            $this->userRepository->addUser($user);
            $user = $this->userRepository->getUserByEmail($data['email']);

            $_SESSION['user'] = $user;

            AlertService::add('success', 'Bienvenue sur le site ' . ($_SESSION['user']->surname ?? "") . ' !');
            header('location: /');
            exit;

        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), "Duplicate entry")) {
                $errorMessage = 'Erreur : ce surnom est déjà utilisé.';
                AlertService::add('danger', $errorMessage);
            } else {
                $errorMessage = 'Une erreur est survenue lors de l\'inscription : ' . $e->getMessage();
                AlertService::add('danger', $errorMessage);
            }
            require_once(__DIR__ . '/../../templates/register_page.php');
        }
    }

    public function getDeleteUser($userId)
    {
        $user = $this->userRepository->getUserById($userId);
        $roles = $this->roleRepository->getRoles();
        foreach ($roles as $role) {
            if ($role->id == $user->role_id) {
                $user->role_name = $role->name;
            }
        }
        require(__DIR__.'/../../templates/admin/users/delete_users_page.php');
    }

    public function postDeleteUser($id)
    {
        $user = $this->userRepository->getUserById($id);

        if($user) {
            $user->delete($id);

            $this->userRepository->deleteUser($user);

            AlertService::add('success', "L'utilisateur ". $user->surname ." a bien été désactivé.");

            header("location: /admin/utilisateurs");
            exit;

        } else {
            echo 'Cet utilisateur n\'existe pas';
        }
    }

    public function getRestoreUser($userId)
    {
        $user = $this->userRepository->getUserById($userId);
        $roles = $this->roleRepository->getRoles();
        foreach ($roles as $role) {
            if ($role->id == $user->role_id) {
                $user->role_name = $role->name;
            }
        }
        require(__DIR__.'/../../templates/admin/users/restore_users_page.php');
    }

    public function postRestoreUser($id)
    {
        $user = $this->userRepository->getUserById($id);

        if($user) {
            $user->restore($id);

            $this->userRepository->restoreUser($user);

            AlertService::add('success', "L'utilisateur ". $user->surname ." a bien été restauré.");

            header("location: /admin/utilisateurs");
            exit;

        } else {
            echo 'Cet utilisateur n\'existe pas';
        }
    }
}
