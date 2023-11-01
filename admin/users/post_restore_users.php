<?php 
    session_start(); 
    include_once('../../php/functions.php');
    include_once('../../sql/pdo.php');

    if (isset($_GET['id'])) {
        $userId = $_GET['id'];
    } else {
        echo "L'ID n'a pas été transmis dans l'URL.";
        return;
    }

    $userId = $_GET['id'];

    $restoreUser = $db->prepare('UPDATE users 
    SET deleted_at = :deleted_at
    WHERE id = :id ');

    $restoreUser->execute([
        'id' => $userId,
        'deleted_at' => null,
    ]);
    
    require('../../templates/admin/users/post_restore_users_page.php');
?>

        