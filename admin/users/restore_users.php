<?php 
    session_start();
    include_once('../../php/functions.php');
    include_once('../../sql/pdo.php');

    if (isset($_GET['id'])) {
        $userId = $_GET['id'];

        if (ctype_digit($userId)) {
            $userId = intval($userId); 
    
            $query = $db->prepare('SELECT * FROM users WHERE id = :userId');
            $query->execute(['userId' => $userId]);
    
            if ($query->rowCount() > 0) {
                $user = $query->fetch();
            } else {
                echo "L'utilisateur avec l'ID $userId n'a pas été trouvé.";
            }
        } else {
            echo "ID non valide.";
        }
    }

    require('../../templates/admin/users/restore_users_page.php');
?>
