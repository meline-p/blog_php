<?php 
    session_start(); 
    include_once('php/functions.php');
    include_once('sql/pdo.php');
    include_once('parts/navbar.php');

    $email = "";
    $surname = "";
    $loggedIn = false;

    if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
    isset($_POST['password']) && !empty($_POST['password'])) 
    {
        $loggedIn = false;
        foreach ($users as $user) {
            if ($user['email'] === $_POST['email'] && $user['password'] === $_POST['password']) {
                $loggedUser = [
                    'email' => $user['email'],
                    'surname' => $user['surname'],
                    'id' => $user['id']
                ];
                $loggedIn = true; 
                $_SESSION['LOGGED_USER'] = $user['surname'];
                $_SESSION['USER_ID'] = $user['id'];
                break;
            }
        }

        if ($loggedIn) {
            $email = $loggedUser['email'];
            $surname = $loggedUser['surname'];
            $id = $loggedUser['id'];
        }
    }

    require('templates/homepage.php');
?>
