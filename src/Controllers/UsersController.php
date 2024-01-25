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

    public function getAddUser($data = null)
    {
        $roles = $this->roleRepository->getRoles();
        require(__DIR__.'/../../templates/admin/users/add_user_page.php');
    }

    public function postAddUser($data)
    {
        if($data['password'] != $data['confirm_password']) {
            AlertService::add('danger', "Les mots de passe sont différents");
            $this->getAddUser($data);
            exit;
        }

        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $last_name = mb_strtolower($data["last_name"], 'UTF-8');
        $fist_name = mb_strtolower($data["first_name"], 'UTF-8');

        $user = new User();
        $user->init(
            $data["role_id"],
            ucfirst($last_name),
            ucfirst($fist_name),
            mb_strtolower($data["surname"], 'UTF-8'),
            mb_strtolower($data["email"], 'UTF-8'),
            $hashedPassword
        );

        $this->userRepository->addUser($user);

        AlertService::add('success', "L'utilisateur' " . $user->surname . " a bien été ajouté.");

        header("location: /admin/utilisateurs");
        exit;
    }

    public function getEditUser($userId)
    {
        $user = $this->userRepository->getUserById($userId);
        $roles = $this->roleRepository->getRoles();
        require(__DIR__.'/../../templates/admin/users/edit_user_page.php');
    }

    public function postEditUser($id, $data)
    {
        if (!isset($id) || empty($data["last_name"]) || empty($data["first_name"]) || empty($data["surname"]) || empty($data["email"])) {
            AlertService::add('danger', "Veuillez fournir toutes les informations nécessaires.");

            header("location: /admin/utilisateur/modifier/$id");
            exit;
        }

        $user = $this->userRepository->getUserById($id);

        if(!$user) {
            echo 'Cet utilisateur n\'existe pas';
            return;
        }

        $last_name = mb_strtolower($data["last_name"], 'UTF-8');
        $fist_name = mb_strtolower($data["first_name"], 'UTF-8');

        $user->update(
            $data["role_id"],
            ucfirst($last_name),
            ucfirst($fist_name),
            mb_strtolower($data["surname"], 'UTF-8'),
            mb_strtolower($data["email"], 'UTF-8'),
        );

        $this->userRepository->editUser($user);

        AlertService::add('success', "L'utilisateur ". $user->surname ." a bien été modifié.");

        header("location: /admin/utilisateurs");
        exit;

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
