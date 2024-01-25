<?php

namespace App\controllers;

use App\lib\AlertService;
use App\Model\Repository\UserRepository;
use App\Model\Repository\PostRepository;
use App\Model\Repository\CommentRepository;
use App\Model\Repository\RoleRepository;
use App\lib\DatabaseConnection;
use App\Model\Entity\User;

/**
 * Class representing user authentication.
 *
 * This class allows for performing checks to authenticate a user.
 */
class AuthController
{
    private $userRepository;
    private $postRepository;
    private $commentRepository;
    private $roleRepository;
    private $currentTime;

    /**
     *  Constructor for initializing the Controller with repositories and current time.
     *
     * @param  DatabaseConnection $connection The database connection object.
     * @return void
     */
    public function __construct(DatabaseConnection $connection)
    {
        // Initialize UserRepository with the provided database connection
        $this->userRepository = new UserRepository($connection);

        // Initialize PostRepository with the provided database connection
        $this->postRepository = new PostRepository($connection);

        // Initialize CommentRepository with the provided database connection
        $this->commentRepository = new CommentRepository($connection);

        // Initialize RoleRepository with the provided database connection
        $this->roleRepository = new RoleRepository($connection);

        // Set the current time for the controller
        $this->currentTime = date('Y-m-d H:i:s');
    }

    /**
     * Display the administration dashboard.
     *
     * @return void
     */
    public function administration()
    {
        // Retrieve the counts for posts, comments, and users
        $nbPosts = $this->postRepository->countAllPosts();
        $nbComments = $this->commentRepository->countAllComments();
        $nbUsers = $this->userRepository->countAllUsers();

        // Retrieve administrators
        $admins = $this->userRepository->getAdmins();

        // Require the administration dashboard page template for rendering
        require_once(__DIR__ . '/../../templates/admin/dashboard_page.php');
    }

    /**
     * Display the login page and handle user login.
     *
     * @return void
     */
    public function getLogin()
    {
        // If the user is already logged in, redirect to the home page
        if(isset($_SESSION['user'])) {
            header("location: /");
            exit;
        }

        // Initialize variables
        $email = "";
        $surname = "";
        $loggedIn = false;
        $errorMessage = "";

        // Check if form is submitted and validate email and password
        if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
        isset($_POST['password']) && !empty($_POST['password'])) {

            $email = $_POST['email'];
            $enteredPassword = $_POST['password'];

            // Retrieve user by email
            $user = $this->userRepository->getUserByEmail($email);

            // Check if user exists and verify password
            if(!$user || !password_verify($enteredPassword, $user->password)) {
                // Display error message and redirect to login page
                AlertService::add('danger', 'Les informations envoyées ne permettent pas de vous identifier.');
                header("location: /connexion");
                exit;
            }

            // Set the user session
            $_SESSION['user'] = $user;

            // Get the redirect back URL, if available
            $redirectBack = isset($_SESSION['redirect_back']) ? $_SESSION['redirect_back'] : '/';

            // Display success message and redirect to the specified page or home page
            AlertService::add('success', 'Bienvenue sur le site ' . ($_SESSION['user']->surname ?? "") . ' !');
            header("location: " . $redirectBack);
            exit;

        }

        // Require the login page template for rendering
        require_once(__DIR__ . '/../../templates/login_page.php');
    }

    /**
     * Handle user logout.
     *
     * @return void
     */
    public function getLogout()
    {
        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header('location: /connexion');
        exit;
    }

    /**
     * Display the registration page.
     *
     * @return void
     */
    public function getRegister()
    {
        // Require the registration page template for rendering
        require_once(__DIR__ . '/../../templates/register_page.php');
    }

    /**
    * Handle the registration of a user.
    *
    * @param mixed $data User data submitted during registration.
    * @return void
    */
    public function postRegister($data)
    {
        // Initialize variables
        $errorMessage = null;

        // Hash the password using bcrypt
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        // Convert last name and first name to lowercase
        $last_name = mb_strtolower($data["last_name"], 'UTF-8');
        $fist_name = mb_strtolower($data["first_name"], 'UTF-8');

        try {
            // Create a new User instance
            $user = new User();
            $user->init(
                2,
                ucfirst($last_name),
                ucfirst($fist_name),
                mb_strtolower($data["surname"], 'UTF-8'),
                mb_strtolower($data["email"], 'UTF-8'),
                $hashedPassword
            );

            // Check if the user already exists
            $messages = $this->userRepository->exists($user);

            // If user already exists, display error messages and redirect to registration page
            if(!empty($messages)) {
                foreach($messages as $message) {
                    AlertService::add('danger', $message);
                }
                header('location: /inscription');
                exit;
            }

            // Add the user to the repository
            $this->userRepository->addUser($user);

            // Retrieve the user by email
            $user = $this->userRepository->getUserByEmail($data['email']);

            // Set the user session
            $_SESSION['user'] = $user;

            // Display success message and redirect to home page
            AlertService::add('success', 'Bienvenue sur le site ' . ($_SESSION['user']->surname ?? "") . ' !');
            header('location: /');
            exit;

        } catch (\Exception $e) {
            // Handle exceptions during registration
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
}
