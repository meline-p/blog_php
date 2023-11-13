<?php

namespace App\Controllers;

use App\Model\Repository\UserRepository;

class LoginController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login()
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
                    $surname = $user['surname'];
                    $_SESSION['LOGGED_USER'] = $surname;

                    // Check if user = admin
                    if (isset($user['role_id']) && $user['role_id'] === 1) {
                        $_SESSION['IS_ADMIN'] = true;
                    }
                } else {
                    $errorMessage = 'Les informations envoyées ne permettent pas de vous identifier.';
                }
            }
        }
        require_once(__DIR__ . '/../../public/templates/login_page.php');
    }
}
