<?php

namespace App\controllers;

use App\lib\AlertService;
use App\Model\Repository\UserRepository;
use App\Model\Repository\PostRepository;

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
        $posts = $this->postRepository->getAllPosts();

        require_once(__DIR__ . '/../../templates/homepage.php');
    }

    public function sendMessage()
    {
        if(
            (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            || (!isset($_POST['message']) || empty($_POST['message']))
        ) {
            AlertService::add('danger', 'Veuillez remplir tous les champs');
            header('location: /');
            exit;
        }

        AlertService::add('success', 'Votre message a bien été envoyé');

        $email = htmlspecialchars($_POST['email']);
        $message =  nl2br(htmlspecialchars($_POST['message']));

        header('location: /');
        exit;
    }
}
