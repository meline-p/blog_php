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

    /**
     * Constructor for the User class.
     *
     * @param  DatabaseConnection $connection The database connection instance.
     * @return void
     */
    public function __construct(DatabaseConnection $connection)
    {
        $this->userRepository = new UserRepository($connection);
        $this->postRepository = new PostRepository($connection);
        $this->commentRepository = new CommentRepository($connection);
        $this->roleRepository = new RoleRepository($connection);
        $this->currentTime = date('Y-m-d H:i:s');
    }

    /**
     * Retrieve and display a list of all users in the admin users list page.
     *
     * @return void
     */
    public function getUsers()
    {
        $users = $this->userRepository->getUsers();
        require_once(__DIR__ . '/../../templates/admin/admin_users_list_page.php');
    }

    /**
     * Retrieve a list of administrators.
     *
     * @return mixed The list of administrators
     */
    public function getAdmins()
    {
        $admins = $this->userRepository->getAdmins();
    }

    /**
     * Retrieve a user by their ID.
     *
     * @param  mixed $userId The ID of the user to retrieve.
     * @return User|null The user object if found, or null if not found.
     */
    public function getUserById($userId)
    {
        $this->userRepository->getUserById($userId);
    }

    /**
     * Retrieve a user by their email address
     *
     * @param  mixed $userEmail The email address of the user to retrieve.
     * @return User|null The user object if found, or null if not found.
     */
    public function getUserByEmail($userEmail)
    {
        $this->userRepository->getUserByEmail($userEmail);
    }

    /**
     * Display the page for adding a new user.
     *
     * @param  mixed $data Optional data to pre-fill the form fields.
     * @return void
     */
    public function getAddUser($data = null)
    {
        $roles = $this->roleRepository->getRoles();
        require(__DIR__.'/../../templates/admin/users/add_user_page.php');
    }

    /**
     * Process the form submission for adding a new user.
     *
     * @param  mixed $data The data submitted via the form.
     * @return void
     */
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

        $messages = $this->userRepository->exists($user);

        if(!empty($messages)) {
            foreach($messages as $message) {
                AlertService::add('danger', $message);
            }
            $this->getAddUser($data);
            exit;
        }

        $this->userRepository->addUser($user);

        AlertService::add('success', "L'utilisateur " . $user->surname . " a bien été ajouté.");
        header("location: /admin/utilisateurs");
        exit;
    }

    /**
     * Display the page for editing a user.
     *
     * @param  mixed $userId The ID of the user to edit.
     * @return void
     */
    public function getEditUser($userId)
    {
        $user = $this->userRepository->getUserById($userId);
        $roles = $this->roleRepository->getRoles();

        if(!$user) {
            AlertService::add('danger', "Cet utilisateur n'existe pas.");
            header("location: /admin/utilisateurs");
            exit;
        } else {
            require(__DIR__.'/../../templates/admin/users/edit_user_page.php');
        }
    }

    /**
     * Process the edit user form submission.
     *
     * @param  mixed $userId The ID of the user to edit.
     * @param  mixed $data The data submitted via the form.
     * @return void
     */
    public function postEditUser($userId, $data)
    {
        if (empty($data["last_name"]) || empty($data["first_name"]) || empty($data["surname"]) || empty($data["email"])) {
            AlertService::add('danger', "Veuillez fournir toutes les informations nécessaires.");
            header("location: /admin/utilisateur/modifier/$userId");
            exit;
        }

        $user = $this->userRepository->getUserById($userId);

        if(!$user) {
            AlertService::add('danger', "Cet utilisateur n'existe pas.");
            header("location: /admin/utilisateurs");
            exit;
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

    /**
    * Display the user deletion confirmation page.
    *
    * @param  mixed $userId The ID of the user to delete.
    * @return void
    */
    public function getDeleteUser($userId)
    {
        $user = $this->userRepository->getUserById($userId);
        $roles = $this->roleRepository->getRoles();

        if(!$user) {
            AlertService::add('danger', "Cet utilisateur n'existe pas.");
            header("location: /admin/utilisateurs");
            exit;
        }

        foreach ($roles as $role) {
            if ($role->id == $user->role_id) {
                $user->role_name = $role->name;
            }
        }

        require(__DIR__.'/../../templates/admin/users/delete_users_page.php');
    }

    /**
     * Process the deletion of a user.
     *
     * @param  mixed $userId The ID of the user to delete.
     * @return void
     */
    public function postDeleteUser($userId)
    {
        $user = $this->userRepository->getUserById($userId);

        if(!$user) {
            AlertService::add('danger', "Cet utilisateur n'existe pas.");
            header("location: /admin/utilisateurs");
            exit;
        }

        $user->delete($userId);

        $this->userRepository->deleteUser($user);

        AlertService::add('success', "L'utilisateur ". $user->surname ." a bien été désactivé.");
        header("location: /admin/utilisateurs");
        exit;
    }

    /**
     * Display the restoration page for a deleted user.
     *
     * @param  mixed $userId The ID of the user to restore.
     * @return void
     */
    public function getRestoreUser($userId)
    {
        $user = $this->userRepository->getUserById($userId);
        $roles = $this->roleRepository->getRoles();

        if(!$user) {
            AlertService::add('danger', "Cet utilisateur n'existe pas.");
            header("location: /admin/utilisateurs");
            exit;
        }

        foreach ($roles as $role) {
            if ($role->id == $user->role_id) {
                $user->role_name = $role->name;
            }
        }

        require(__DIR__.'/../../templates/admin/users/restore_users_page.php');
    }

    /**
     * Restore a previously deleted user.
     *
     * @param  mixed $userId The ID of the user to restore.
     * @return void
     */
    public function postRestoreUser($userId)
    {
        $user = $this->userRepository->getUserById($userId);

        if(!$user) {
            AlertService::add('danger', "Cet utilisateur n'existe pas.");
            header("location: /admin/utilisateurs");
            exit;
        }

        $user->restore($userId);

        $this->userRepository->restoreUser($user);

        AlertService::add('success', "L'utilisateur ". $user->surname ." a bien été restauré.");
        header("location: /admin/utilisateurs");
        exit;
    }
}
