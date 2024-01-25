<?php
    session_start(); 

    require('sql/pdo.php');
    require('src/models/user.php');

    if (
        !isset($_POST['surname']) || empty($_POST['surname']) ||
        !isset($_POST['email']) || empty($_POST['email']) ||
        !isset($_POST['password']) || empty($_POST['password']) ||
        !isset($_POST['first_name']) || empty($_POST['first_name']) ||
        !isset($_POST['last_name']) || empty($_POST['last_name'])
    ) {
        echo "Veuillez remplir tous les champs.";
        return;

    } elseif (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $email = $_POST['email'];
        $surname = $_POST['surname'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $password = $_POST['password'];
        $role_id = 2;
        $currentTime = date('Y-m-d H:i:s');
        $created_at = $currentTime;

        $userId = addUser($db, $role_id, $last_name, $first_name, $surname, $email, $password);

        $loggedIn = true;
        $_SESSION['LOGGED_USER'] = $surname;
        $_SESSION['USER_ID'] = $db->lastInsertId();
    }

    require('templates/post_add_users_page.php');
?>
 