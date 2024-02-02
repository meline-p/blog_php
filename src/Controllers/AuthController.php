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
        $this->userRepository = new UserRepository($connection);
        $this->postRepository = new PostRepository($connection);
        $this->commentRepository = new CommentRepository($connection);
        $this->roleRepository = new RoleRepository($connection);
        $this->currentTime = date('Y-m-d H:i:s');
    }

    /**
     * Display the administration dashboard.
     *
     * @return void
     */
    public function administration()
    {
        $nbPosts = $this->postRepository->countAllPosts();
        $nbPublishedPosts = $this->postRepository->countPublishedPosts();
        $nbDraftPosts = $this->postRepository->countDraftPosts();

        $nbComments = $this->commentRepository->countAllComments();
        $nbPendingComments = $this->commentRepository->countPendingComments();
        $nbValidComments = $this->commentRepository->countValidComments();

        $nbAllUsers = $this->userRepository->countAllUsers();
        $nbActiveAccounts = $this->userRepository->countActiveAccounts();
        $nbAdmins = $this->userRepository->countAdmins();
        $nbUsers = $this->userRepository->countUsers();

        $admins = $this->userRepository->getAdmins();

        require_once(__DIR__ . '/../../templates/admin/dashboard_page.php');
    }

    /**
     * Display the login page and handle user login.
     *
     * @return void
     */
    public function getLogin()
    {
        $csrfToken = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrfToken;

        if(isset($_SESSION['user'])) {
            header("location: /");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                require_once(__DIR__ . '/../../templates/error_page.php');
                exit;
            }
        }

        $email = "";
        $surname = "";
        $loggedIn = false;
        $errorMessage = "";

        if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
        isset($_POST['password']) && !empty($_POST['password'])) {

            $email = $_POST['email'];
            $enteredPassword = $_POST['password'];

            $user = $this->userRepository->getUserByEmail($email);

            if(!$user || !password_verify($enteredPassword, $user->password)) {
                AlertService::add('danger', 'Les informations envoyées ne permettent pas de vous identifier.');
                header("location: /connexion");
                exit;
            }

            $_SESSION['user'] = $user;

            $redirectBack = isset($_SESSION['redirect_back']) ? $_SESSION['redirect_back'] : '/';

            $url = "http://localhost:8080";

            if ($_SESSION['redirect_back'] == $url.'/inscription' || $_SESSION['redirect_back'] == $url.'/connexion') {
                $redirectBack = '/';
            }

            AlertService::add('success', 'Bienvenue sur le site ' . ($_SESSION['user']->surname ?? "") . ' !');
            header("location: " . $redirectBack);
            exit;

        }

        require_once(__DIR__ . '/../../templates/login_page.php');
    }

    /**
     * Handle user logout.
     *
     * @return void
     */
    public function getLogout()
    {
        session_destroy();

        header('location: /connexion');
        exit;
    }

    /**
     * Display the registration page.
     *
     * @param  mixed $data Optional data to pre-fill the form fields.
     * @return void
     */
    public function getRegister($data = null)
    {
        $csrfToken = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrfToken;

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
        $errorMessage = null;

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            require_once(__DIR__ . '/../../templates/error_page.php');
            exit;
        }

        if($data['password'] != $data['confirm_password']) {
            AlertService::add('danger', "Les mots de passe sont différents");
            $this->getRegister($data);
            exit;
        }

        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        $last_name = mb_strtolower($data["last_name"], 'UTF-8');
        $fist_name = mb_strtolower($data["first_name"], 'UTF-8');

        try {
            $user = new User();
            $user->init(
                2,
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
                header('location: /inscription');
                exit;
            }

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
}
