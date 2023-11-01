<?php 
    session_start(); 
    include_once('php/functions.php');
    include_once('sql/pdo.php');
    include_once('parts/navbar.php');

    $sqlQuery = 'SELECT * FROM users u
        ORDER BY COALESCE(deleted_at, created_at) DESC';
    $usersStatement = $db->prepare($sqlQuery);
    $usersStatement->execute();
    $users = $usersStatement->fetchAll();

    // Validation du formulaire
    if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
    isset($_POST['password']) && !empty($_POST['password'])) 
    {
        $loggedIn = false;
        foreach ($users as $user) {
            if ($user['email'] === $_POST['email'] && $user['password'] === $_POST['password']) {
                $loggedUser = [
                    'email' => $user['email'],
                    'surname' => $user['surname'],
                ];
                if (isset($user['id'])) {
                    $loggedUser['id'] = $user['id'];
                    $_SESSION['USER_ID'] = $user['id'];
                }
                $loggedIn = true;
                $_SESSION['LOGGED_USER'] = $user['surname'];
                break;
            }
        }
        if (!$loggedIn) {
            $errorMessage = 'Les informations envoyées ne permettent pas de vous identifier.';
        }
    }

    require('templates/login_page.php');
?>

