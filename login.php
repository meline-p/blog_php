<?php 

    session_start(); 

    require('sql/pdo.php');
    require('src/models/user.php');

    $users = getUsers($db);

    $email = "";
    $surname = "";
    $loggedIn = false;
    $errorMessage = "";

    if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
    isset($_POST['password']) && !empty($_POST['password'])) 
    {
        $email= $_POST['email'];
        $password = $_POST['password'];

        $loggedIn = login($db, $email, $password);

        if ($loggedIn) {
            $userId = $_SESSION['USER_ID'];
            $user = getUserById($db, $userId, $users);

            if($user){
                $surname = $user['surname'];
                $_SESSION['LOGGED_USER'] = $surname;

                // Vérifie si l'utilisateur est un administrateur
                if (isset($user['role_id']) && $user['role_id'] === 1) {
                    $_SESSION['IS_ADMIN'] = true;
                }
            } else {
            $errorMessage = 'Les informations envoyées ne permettent pas de vous identifier.';
            }
        } 
    }

    require('templates/login_page.php');
