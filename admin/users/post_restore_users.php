<?php 
    session_start(); 

    require('../../sql/pdo.php');
    require('../../src/models/user.php');

    if (isset($_GET['id'])) {
        $userId = $_GET['id'];

        if (ctype_digit($userId)) {
            $userId = intval($userId); 

            restoreUser($db, $userId);
        }
    }

    
    require('../../templates/admin/users/post_restore_users_page.php');


        