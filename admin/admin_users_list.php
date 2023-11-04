<?php 
    session_start();
    include_once('../php/functions.php');
    include_once('../sql/pdo.php');

    $sqlQuery = "SELECT u.*, r.name AS role_name
            FROM users u
            LEFT JOIN roles r ON u.role_id = r.id
            ORDER BY COALESCE(u.deleted_at, u.created_at) ASC";
    $rolesStatement = $db->prepare($sqlQuery);
    $rolesStatement->execute();
    $users = $rolesStatement->fetchAll();

    require('../templates/admin/admin_users_list_page.php');

