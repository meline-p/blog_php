<?php 

    require('sql/pdo.php');
    require_once('src/models/user.php');

    function homepage($db, $users){
        $surname = "";
        $loggedIn = false;

        if (isset($_SESSION['USER_ID'])) {
            $userId = $_SESSION['USER_ID'];
            $user = getUserById($db, $userId, $users);
            if ($user) {
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

        require('templates/homepage.php');
    }
