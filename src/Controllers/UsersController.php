<?php

namespace App\controllers;

use App\Model\Repository\UserRepository;
use App\lib\DatabaseConnection;
use App\Model\Entity\User;

class UsersController
{
    private $userRepository;
    private $currentTime;

    public function __construct(DatabaseConnection $connection)
    {
        $this->userRepository = new UserRepository($connection);
        $this->currentTime = date('Y-m-d H:i:s');
    }


    public function getUsers()
    {
        $this->userRepository->getUsers();
        require('templates/admin/admin_posts_list_page.php');
    }

    public function getAdmins()
    {
        $this->userRepository->getAdmins();
    }

    public function getUserById($userId)
    {
        $this->userRepository->getUserById($userId);
    }

    public function getLogin()
    {
        require('templates/login_page.php');
    }

    public function postLogin($email, $password)
    {
        $this->userRepository->login($email, $password);
        require('templates/homepage_page.php');
    }

    public function getRegister()
    {
        require('templates/register_page.php');
    }

    public function postRegister($role_id, $last_name, $first_name, $surname, $email, $password)
    {
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
