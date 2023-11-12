<?php

namespace Repository;

use DatabaseConnection;
use Entity\User;

class UserRepository
{
    private \DatabaseConnection $connection;

    public function __construct(\DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getUsers()
    {
        $statement = $this->connection->getConnection()->prepare('SELECT * FROM users 
            ORDER BY COALESCE(deleted_at, created_at) DESC');
        $statement->execute();
        $users = $statement->fetchAll();
        return $users;
    }

    public function getAdmins()
    {
        $statement = $this->connection->getConnection()->prepare('SELECT id, first_name, last_name, surname 
            FROM users 
            WHERE role_id = :role_id');
        $statement->execute(['role_id' => 1]);
        $admins = $statement->fetchAll();
        return $admins;
    }

    public function getUserById($userId)
    {
        $statement = $this->connection->getConnection()->prepare('SELECT * FROM users WHERE id = :userId');
        $statement->execute(['userId' => $userId]);
        $user = $statement->fetch();
        return $user;
    }

    public function login($email, $password)
    {
        $statement = $this->connection->getConnection()->prepare('SELECT * FROM users WHERE email = :email AND password = :password');
        $statement->execute(['email' => $email, 'password' => $password]);
        $user = $statement->fetch();

        if ($user) {
            $_SESSION['LOGGED_USER'] = $user['surname'];
            $_SESSION['USER_ID'] = $user['id'];
            return true;
        }

        return false;
    }

    public function addUser(User $user)
    {
        $currentTime = date('Y-m-d H:i:s');
        $insertUser = $this->connection->getConnection()->prepare('INSERT INTO users(role_id, last_name, first_name, surname, email, password, created_at)
            VALUES (:role_id, :last_name, :first_name, :surname, :email, :password, :created_at)');
        $insertUser->execute([
            'role_id' => $user->getRoleId(),
            'last_name' => $user->getLastName(),
            'first_name' => $user->getFirstName(),
            'surname' => $user->getSurname(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'created_at' => $currentTime
        ]);

        return $this->connection->getConnection()->lastInsertId();
    }

    public function deleteUser($userId)
    {
        $currentTime = date('Y-m-d H:i:s');
        $deleteUser = $this->connection->getConnection()->prepare('UPDATE users 
            SET deleted_at = :deleted_at
            WHERE id = :id');
        $deleteUser->execute([
            'id' => $userId,
            'deleted_at' => $currentTime,
        ]);
    }


    public function restoreUser($userId)
    {
        $restoreUser = $this->connection->getConnection()->prepare('UPDATE users 
            SET deleted_at = :deleted_at
            WHERE id = :id ');
        $restoreUser->execute([
            'id' => $userId,
            'deleted_at' => null,
        ]);
    }
}
