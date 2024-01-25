<?php

namespace App\controllers;

use App\lib\AlertService;
use App\Model\Repository\UserRepository;
use App\Model\Repository\PostRepository;

/**
 * Class representing the homepage
 *
 * This class manages homepage
 */
class HomeController
{
    private UserRepository $userRepository;
    private PostRepository $postRepository;

    /**
     * Constructor for initializing the Controller with UserRepository and PostRepository dependencies.
     *
     * @param  UserRepository $userRepository The UserRepository instance.
     * @param  PostRepository $postRepository The PostRepository instance.
     * @return void
     */
    public function __construct(UserRepository $userRepository, PostRepository $postRepository)
    {
        // Set the UserRepository instance
        $this->userRepository = $userRepository;

        // Set the PostRepository instance
        $this->postRepository = $postRepository;
    }

    /**
     * Display the home page with all posts.
     *
     * @return void
     */
    public function home()
    {
        // Retrieve all posts
        $posts = $this->postRepository->getAllPosts();

        // Require the homepage template for rendering
        require_once(__DIR__ . '/../../templates/homepage.php');
    }

    /**
     * Process and send a contact form message.
     *
     * @return void
     */
    public function sendMessage()
    {
        // Check if required fields are provided in the POST request
        if(
            (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            || (!isset($_POST['message']) || empty($_POST['message']) || empty($_POST['name']))
        ) {
            // Display an error message and redirect to the home page if fields are missing
            AlertService::add('danger', 'Veuillez remplir tous les champs');
            header('location: /');
            exit;
        }

        // Sanitize and retrieve values from the POST request
        $email = htmlspecialchars($_POST['email']);
        $name = htmlspecialchars($_POST['name']);

        // Sanitize and process the message content
        $message = nl2br($_POST['message']);
        $message = strip_tags($message, '<p><br><b><i><u>');
        $message = str_replace(['<', '>'], ['&lt;', '&gt;'], $message);

        // Set recipient email, subject, and headers for the email
        $to      = 'meline.pischedda@gmail.com';
        $subject = 'Formulaire de contact : Nouveau message de '. $name;
        $subject = "=?UTF-8?B?".base64_encode($subject)."?=";
        $message = 'Nom : '.$name . "\r\n" . 'Mail : '. $email. "\r\n\n" . "Message : \r\n" .$message;
        $headers = 'From: ' . $email . "\r\n" .
                'Reply-To: '  . $email . "\r\n" .
                'X-Mailer: PHP/' . phpversion(). "\r\n" .
                "Content-Type: text/plain; charset=UTF-8\n";

        // Send the email
        mail($to, $subject, $message, $headers);

        // Display a success message for the user
        AlertService::add('success', 'Votre message a bien été envoyé');

        // Redirect to the home page after sending the message
        header('location: /');
        exit;
    }
}
