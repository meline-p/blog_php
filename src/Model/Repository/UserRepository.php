<?php

namespace App\Model\Repository;

use App\lib\DatabaseConnection;
use App\Model\Entity\User;

class UserRepository
{
    private DatabaseConnection $connection;
    public $current_time;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
        $this->current_time = new \DateTime();
    }

    public function getUsers()
    {
        $statement = $this->connection->getConnection()->prepare("SELECT u.*, r.name AS role_name
        FROM users u
        LEFT JOIN roles r ON u.role_id = r.id
        ORDER BY COALESCE(u.deleted_at, u.created_at) ASC");
        $statement->execute();
        $rows =  $statement->fetchAll();
        $users = array_map(function ($row) {
            $user = new User();
            $user->fromSql($row);
            return $user;
        }, $rows);
        return $users;
    }

    public function getAdmins()
    {
        $statement = $this->connection->getConnection()->prepare('SELECT id, first_name, last_name, surname 
            FROM users 
            WHERE role_id = :role_id');
        $statement->execute(['role_id' => 1]);
        $rows =  $statement->fetchAll();
        $admins = array_map(function ($row) {
            $admin = new User();
            $admin->fromSql($row);
            return $admin;
        }, $rows);
        return $admins;
    }

    public function countAllUsers()
    {
        $statement = $this->connection->getConnection()->prepare('SELECT COUNT(1) AS nb FROM users');
        $statement->execute();
        $row = $statement->fetch();
        return $row['nb'];
    }

    public function getUserById($userId)
    {
        $statement = $this->connection->getConnection()->prepare('SELECT * FROM users WHERE id = :userId');
        $statement->execute(['userId' => $userId]);
        $row = $statement->fetch();
        $user = new User();
        $user->fromSql($row);
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
        $insertUser = $this->connection->getConnection()->prepare('INSERT INTO users(role_id, last_name, first_name, surname, email, password, created_at)
            VALUES (:role_id, :last_name, :first_name, :surname, :email, :password, :created_at)');

        $user->init(
            $user->role_id,
            $user->last_name,
            $user->first_name,
            $user->surname,
            $user->email,
            $user->password
        );

        $insertUser->execute([
            'role_id' => $user->role_id,
            'last_name' => $user->last_name,
            'first_name' => $user->first_name,
            'surname' => $user->surname,
            'email' => $user->email,
            'password' => $user->password,
            'created_at' => $this->current_time
        ]);

        return $this->connection->getConnection()->lastInsertId();
    }

    public function deleteUser(User $user)
    {
        $deleteUser = $this->connection->getConnection()->prepare('UPDATE users 
            SET deleted_at = :deleted_at
            WHERE id = :id');

        $user->delete($user->id);

        $deleteUser->execute([
            'id' => $user->id,
            'deleted_at' => $this->current_time,
        ]);
    }


    public function restoreUser(User $user)
    {
        $restoreUser = $this->connection->getConnection()->prepare('UPDATE users 
            SET deleted_at = :deleted_at
            WHERE id = :id ');

        $user->restore($user->id);

        $restoreUser->execute([
            'id' => $user->id,
            'deleted_at' => null,
        ]);
    }
}
