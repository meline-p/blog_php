<?php 
    session_start(); 
    include_once('../sql/pdo.php');
    include_once('../php/variables.php');
    include_once('../php/functions.php');

    $email = "";
    $surname = "";
    $loggedIn = false;

    if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
    isset($_POST['password']) && !empty($_POST['password'])) 
    {
        $loggedIn = false;
        foreach ($admins as $admin) {
            if ($admin['email'] === $_POST['email'] && $admin['password'] === $_POST['password']) {
                $loggedUser = [
                    'email' => $admin['email'],
                    'surname' => $admin['surname'],
                ];
                $loggedIn = true; 
                $_SESSION['LOGGED_ADMIN'] = $admin['surname'];
                break;
            }
        }

        if ($loggedIn) {
            $email = $loggedUser['email'];
            $surname = $loggedUser['surname'];
        }
    }

    require('../templates/admin/dashboard_page.php');
?>
