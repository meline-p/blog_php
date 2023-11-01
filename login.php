<?php 

    session_start(); 

    require('sql/pdo.php');
    require('src/models/user.php');

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
            } else {
            $errorMessage = 'Les informations envoyées ne permettent pas de vous identifier.';
            }
        } 
    }

    require('templates/login_page.php');
?>

