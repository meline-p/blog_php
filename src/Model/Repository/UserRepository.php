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

    private function getSimpleSelect()
    {
        return "SELECT u.*, r.name AS role_name
        FROM users u
        LEFT JOIN roles r ON u.role_id = r.id";
    }

    public function getUsers()
    {
        $statement = $this->connection->getConnection()->prepare($this->getSimpleSelect()."
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
        $statement = $this->connection->getConnection()->prepare($this->getSimpleSelect()."
            WHERE role_id = :role_id");
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
        $statement = $this->connection->getConnection()->prepare($this->getSimpleSelect()." WHERE u.id = :userId");
        $statement->execute(['userId' => $userId]);
        $row = $statement->fetch();
        $user = new User();
        $user->fromSql($row);
        return $user;
    }

    public function getUserByEmail($userEmail)
    {
        $statement = $this->connection->getConnection()->prepare($this->getSimpleSelect()." WHERE email = :userEmail");
        $statement->execute(['userEmail' => $userEmail]);
        $row = $statement->fetch();
        $user = new User();
        $user->fromSql($row);
        return $user;
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
            'created_at' => $this->current_time->format('Y-m-d H:i:s')
        ]);

        return $this->connection->getConnection()->lastInsertId();
    }

    public function editUser(User $user)
    {
        $editUser = $this->connection->getConnection()->prepare('UPDATE users u
            SET role_id = :role_id, last_name = :last_name, first_name = :first_name, surname = :surname, email = :email
            WHERE u.id = :id ');

        $user->update(
            $user->role_id,
            $user->last_name,
            $user->first_name,
            $user->surname,
            $user->email,
        );

        $editUser->execute([
            'id' => $user->id,
            'role_id' => $user->role_id,
            'last_name' => $user->last_name,
            'first_name' => $user->first_name,
            'surname' => $user->surname,
            'email' => $user->email,
        ]);
    }

    public function deleteUser(User $user)
    {
        $deleteUser = $this->connection->getConnection()->prepare('UPDATE users 
            SET deleted_at = :deleted_at
            WHERE id = :id');

        $user->delete($user->id);

        $deleteUser->execute([
            'id' => $user->id,
            'deleted_at' => $this->current_time->format('Y-m-d H:i:s'),
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
