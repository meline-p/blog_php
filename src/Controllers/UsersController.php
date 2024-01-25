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
        // Initialize repositories with the provided database connection
        $this->userRepository = new UserRepository($connection);
        $this->postRepository = new PostRepository($connection);
        $this->commentRepository = new CommentRepository($connection);
        $this->roleRepository = new RoleRepository($connection);

        // Set the current time for the class instance
        $this->currentTime = date('Y-m-d H:i:s');
    }

    /**
     * Retrieve and display a list of all users in the admin users list page.
     *
     * @return void
     */
    public function getUsers()
    {
        // Retrieve the list of users from the UserRepository
        $users = $this->userRepository->getUsers();

        // Require the admin users list page template for rendering
        require_once(__DIR__ . '/../../templates/admin/admin_users_list_page.php');
    }

    /**
     * Retrieve a list of administrators.
     *
     * @return mixed The list of administrators
     */
    public function getAdmins()
    {
        // Retrieve the list of administrators
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
        // Retrieve the user by their ID
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
        // Retrieve the user by their email address
        $this->userRepository->getUserById($userEmail);
    }

    /**
     * Display the page for adding a new user.
     *
     * @param  mixed $data Optional data to pre-fill the form fields.
     * @return void
     */
    public function getAddUser($data = null)
    {
        // Retrieve the list of roles from the RoleRepository
        $roles = $this->roleRepository->getRoles();

        // Require the add user page template for rendering
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
        // Check if passwords match
        if($data['password'] != $data['confirm_password']) {
            // Display an error message and redirect to the add user page
            AlertService::add('danger', "Les mots de passe sont différents");
            $this->getAddUser($data);
            exit;
        }

        // Hash the password
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        // Convert names to lowercase
        $last_name = mb_strtolower($data["last_name"], 'UTF-8');
        $fist_name = mb_strtolower($data["first_name"], 'UTF-8');

        // Create a new User instance and initialize it with the form data
        $user = new User();
        $user->init(
            $data["role_id"],
            ucfirst($last_name),
            ucfirst($fist_name),
            mb_strtolower($data["surname"], 'UTF-8'),
            mb_strtolower($data["email"], 'UTF-8'),
            $hashedPassword
        );

        // Check if the user already exists
        $messages = $this->userRepository->exists($user);

        // Display error messages and redirect to the add user page if necessary
        if(!empty($messages)) {
            foreach($messages as $message) {
                AlertService::add('danger', $message);
            }
            $this->getAddUser($data);
            exit;
        }

        // Add the user to the repository
        $this->userRepository->addUser($user);

        // Display success message and redirect to the admin users page
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
        // Get the user by ID
        $user = $this->userRepository->getUserById($userId);

        // Get the list of roles
        $roles = $this->roleRepository->getRoles();

        // Require the edit user page template for rendering
        require(__DIR__.'/../../templates/admin/users/edit_user_page.php');
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
        // Check if required information is provided
        if (!isset($userId) || empty($data["last_name"]) || empty($data["first_name"]) || empty($data["surname"]) || empty($data["email"])) {
            // If not, add an error message and redirect back to the edit user page
            AlertService::add('danger', "Veuillez fournir toutes les informations nécessaires.");
            header("location: /admin/utilisateur/modifier/$userId");
            exit;
        }

        // Get the user by ID
        $user = $this->userRepository->getUserById($userId);

        // Check if the user exists
        if(!$user) {
            echo 'Cet utilisateur n\'existe pas';
            return;
        }

        // Process the user update
        $last_name = mb_strtolower($data["last_name"], 'UTF-8');
        $fist_name = mb_strtolower($data["first_name"], 'UTF-8');

        $user->update(
            $data["role_id"],
            ucfirst($last_name),
            ucfirst($fist_name),
            mb_strtolower($data["surname"], 'UTF-8'),
            mb_strtolower($data["email"], 'UTF-8'),
        );

        // Save the updated user
        $this->userRepository->editUser($user);

        // Add a success message and redirect to the users list page
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
        // Get the user by ID
        $user = $this->userRepository->getUserById($userId);

        // Get the list of roles
        $roles = $this->roleRepository->getRoles();

        // Find the role name for the user
        foreach ($roles as $role) {
            if ($role->id == $user->role_id) {
                $user->role_name = $role->name;
            }
        }

        // Require the delete user confirmation page for rendering
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
        // Get the user by ID
        $user = $this->userRepository->getUserById($userId);

        if($user) {
            // Mark the user as deleted
            $user->delete($userId);

            // Perform the actual deletion in the repository
            $this->userRepository->deleteUser($user);

            // Display a success message
            AlertService::add('success', "L'utilisateur ". $user->surname ." a bien été désactivé.");

            // Redirect to the user management page
            header("location: /admin/utilisateurs");
            exit;

        } else {
            // Display an error message if the user doesn't exist
            echo 'Cet utilisateur n\'existe pas';
        }
    }

    /**
     * Display the restoration page for a deleted user.
     *
     * @param  mixed $userId The ID of the user to restore.
     * @return void
     */
    public function getRestoreUser($userId)
    {
        // Get the user by ID
        $user = $this->userRepository->getUserById($userId);

        // Get roles for display purposes
        $roles = $this->roleRepository->getRoles();

        // Find and assign the role name to the user for display
        foreach ($roles as $role) {
            if ($role->id == $user->role_id) {
                $user->role_name = $role->name;
            }
        }

        // Require the restore users page template for rendering
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
        // Get the user by ID
        $user = $this->userRepository->getUserById($userId);

        if($user) {
            // Call the restore method to mark the user as active
            $user->restore($userId);

            // Update the user status in the repository
            $this->userRepository->restoreUser($user);

            // Display success message
            AlertService::add('success', "L'utilisateur ". $user->surname ." a bien été restauré.");

            // Redirect to the users administration page
            header("location: /admin/utilisateurs");
            exit;

        } else {
            // If the user doesn't exist, display an error message
            echo 'Cet utilisateur n\'existe pas';
        }
    }
}
