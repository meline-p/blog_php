<?php 
    session_start();

    require('../../sql/pdo.php');
    require('../../src/models/user.php');

    if (isset($_GET['id'])) {
        $userId = $_GET['id'];

        if (ctype_digit($userId)) {
            $userId = intval($userId); 

            $sqlQuery = "SELECT u.*, r.name AS role_name
                FROM users u
                LEFT JOIN roles r ON u.role_id = r.id";
            $statement = $db->prepare($sqlQuery);
            $statement->execute();
            $users = $statement->fetchAll();

            $user = getUserById($db, $userId, $users);

            if ($user) {
                $userRoleName = $user['role_name'];

                require('../../templates/admin/users/delete_users_page.php');
            } else {
                echo "L'utilisateur avec l'ID $userId n'a pas été trouvé.";
            }
        } else {
            echo "ID non valide.";
        }
    } else {
        echo "L'ID n'a pas été transmis dans l'URL.";
    }

