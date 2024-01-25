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
