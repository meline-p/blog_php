<?php 
    session_start();

    require('../../sql/pdo.php');
    require('src/models/user.php');

    if (isset($_GET['id'])) {
        $userId = $_GET['id'];

        if (ctype_digit($userId)) {
            $userId = intval($userId); 
    
            $user = getUserById($db, $userId, $users);
    
            if ($user) {
                require('../../templates/admin/users/restore_users_page.php');
            } else {
                echo "L'utilisateur avec l'ID $userId n'a pas été trouvé.";
            }
        } else {
            echo "ID non valide.";
        }
    } else {
        echo "L'ID n'a pas été transmis dans l'URL.";
}

    
?>
