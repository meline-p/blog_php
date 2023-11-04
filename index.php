<?php 
    session_start(); 

    require('sql/pdo.php');
    require('src/models/user.php');

    $users = getUsers($db);

    $surname = "";
    $loggedIn = false;

    if (isset($_SESSION['USER_ID'])) {
        $userId = $_SESSION['USER_ID'];
        $user = getUserById($db, $userId, $users);
        if ($user) {
            $surname = $user['surname'];
            $_SESSION['LOGGED_USER'] = $surname;
            $loggedIn = true;
        } else {
            $errorMessage = 'Les informations envoyées ne permettent pas de vous identifier.';
        }
    }

    require('templates/homepage.php');

