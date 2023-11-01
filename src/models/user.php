<?php

require('sql/pdo.php');

function getUsers($db){
    $sqlQuery = 'SELECT * FROM users u
        ORDER BY COALESCE(deleted_at, created_at) DESC';
    $usersStatement = $db->prepare($sqlQuery);
    $usersStatement->execute();
    $users = $usersStatement->fetchAll();

    return $users;
}

function getUserById($db, $userId, $users) {

    foreach ($users as $user) {
        if ($user['id'] == $userId) {
            return $user;
        }
    }
    return null;
}

function login($db, $email, $password){
    $users = getUsers($db);

    $loggedIn = false;
    $loggedUser = [];

    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            $loggedUser = [
                'email' => $user['email'],
                'surname' => $user['surname'],
                'id' => $user['id']
            ];
            $loggedIn = true; 
            break;
        }
    }

    if ($loggedIn) {
        $_SESSION['LOGGED_USER'] = $loggedUser['surname'];
        $_SESSION['USER_ID'] = $loggedUser['id'];
    }

    return $loggedIn;
}

function addUser($db, $role_id, $last_name, $first_name, $surname, $email, $password){
    $currentTime = date('Y-m-d H:i:s');
    $created_at = $currentTime;

    $insertUser = $db->prepare('INSERT INTO users(role_id, last_name, first_name, surname, email, password, created_at)
        VALUES (:role_id, :last_name, :first_name, :surname, :email, :password, :created_at)');
    $insertUser->execute([
        'role_id' => $role_id,
        'last_name' => $last_name,
        'first_name' => $first_name,
        'surname' => $surname,
        'email' => $email,
        'password' => $password,
        'created_at' => $created_at
    ]);

    return $db->lastInsertId();
}

function deleteUser($db, $userId){
    $deleteUser = $db->prepare('UPDATE users 
        SET deleted_at = :deleted_at
        WHERE id = :id');

    $currentTime = date('Y-m-d H:i:s');

    $deleteUser->execute([
        'id' => $userId,
        'deleted_at' => $currentTime,
    ]);
}


function restoreUser($db, $userId){
    $restoreUser = $db->prepare('UPDATE users 
    SET deleted_at = :deleted_at
    WHERE id = :id ');

    $restoreUser->execute([
        'id' => $userId,
        'deleted_at' => null,
    ]);
}
