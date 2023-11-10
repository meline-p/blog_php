<?php

namespace App\controllers;

use Repository\UserRepository;
use Repository\PostRepository;

class HomeController
{
    private UserRepository $userRepository;
    private PostRepository $postRepository;

    public function __construct(UserRepository $userRepository, PostRepository $postRepository)
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
    }

    public function home()
    {
        $surname = "";
        $loggedIn = false;

        if (isset($_SESSION['USER_ID'])) {
            $userId = $_SESSION['USER_ID'];
            $user = $this->userRepository->getUserById($userId);
            if ($user) {
                $surname = $user['surname'];
                $_SESSION['LOGGED_USER'] = $surname;

                // check if user = admin
                if (isset($user['role_id']) && $user['role_id'] === 1) {
                    $_SESSION['IS_ADMIN'] = true;
                }
            } else {
                $errorMessage = 'Les informations envoyées ne permettent pas de vous identifier.';
            }
        }

        $allPosts = $this->postRepository->getAllPosts();

        require_once(__DIR__ . '/../../public/templates/homepage.php');
    }
}
