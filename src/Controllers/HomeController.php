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
            || (!isset($_POST['message']) || empty($_POST['message']) || empty($_POST['name']))
        ) {
            AlertService::add('danger', 'Veuillez remplir tous les champs');
            header('location: /');
            exit;
        }

        AlertService::add('success', 'Votre message a bien été envoyé');

        $email = htmlspecialchars($_POST['email']);
        $name = htmlspecialchars($_POST['name']);

        $message = nl2br($_POST['message']);
        $message = strip_tags($message, '<p><br><b><i><u>');
        $message = str_replace(['<', '>'], ['&lt;', '&gt;'], $message);
        $message = mb_convert_encoding($message, 'UTF-8');

        $to      = 'meline.pischedda@gmail.com';
        $subject = 'Formulaire de contact : Nouveau message de '. $name;
        $message = 'Nom : '.$name . "\r\n" . 'Mail : '. $email. "\r\n\n" . "Message : \r\n" .$message;
        $headers = 'From: ' . $email . "\r\n" .
                'Reply-To: '  . $email . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);

        header('location: /');
        exit;
    }
}
