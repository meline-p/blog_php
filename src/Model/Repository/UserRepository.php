<?php

namespace App\Model\Repository;

use App\lib\DatabaseConnection;
use App\Model\Entity\User;

/**
 * Class representing User repository.
 */
class UserRepository
{
    private DatabaseConnection $connection;
    public $current_time;

    /**
     * Constructor for the UserRepository class.
     *
     * @param DatabaseConnection $connection The DatabaseConnection object for database interaction.
     * @return void
     */
    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
        $this->current_time = new \DateTime();
    }

    /**
     * Get the simple SELECT query for retrieving user data with role information.
     *
     * This method returns a string containing a SQL SELECT query for retrieving user data with role information.
     * It uses a LEFT JOIN to include the corresponding role name.
     *
     * @return string The SQL SELECT query.
     */
    private function getSimpleSelect()
    {
        return "SELECT u.*, r.name AS role_name
        FROM users u
        LEFT JOIN roles r ON u.role_id = r.id";
    }

    /**
     * Get all users with their corresponding roles.
     *
     * This method retrieves all users with their corresponding roles using the SQL query generated by getSimpleSelect.
     *
     * @return array An array of User objects representing the users.
     */
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

    /**
     * Get all administrators with their corresponding roles.
     *
     * @return array An array of User objects representing the administrators.
     */
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

    /**
     * Count all users in the system.
     *
     * @return int The total number of users in the system.
     */
    public function countAllUsers()
    {
        $statement = $this->connection->getConnection()->prepare('SELECT COUNT(1) AS nb FROM users');
        $statement->execute();

        $row = $statement->fetch();

        return $row['nb'];
    }

    /**
     * Get a user by their ID.
     *
     * @param  mixed $userId The ID of the user to retrieve.
     * @return User|null The User object representing the user, or null if not found.
     */
    public function getUserById($userId)
    {
        $statement = $this->connection->getConnection()->prepare($this->getSimpleSelect()." WHERE u.id = :userId");
        $statement->execute(['userId' => $userId]);

        $row = $statement->fetch();

        if (!$row) {
            return null;
        }

        $user = new User();
        $user->fromSql($row);

        return $user;
    }

    /**
     * Get a user by their email address.
     *
     * @param string $userEmail The email address of the user to retrieve.
     * @return User|null The User object representing the user, or null if not found.
     */
    public function getUserByEmail($userEmail)
    {
        $statement = $this->connection->getConnection()->prepare($this->getSimpleSelect()." WHERE email = :userEmail");
        $statement->execute(['userEmail' => $userEmail]);

        $row = $statement->fetch();

        if (!$row) {
            return null;
        }

        $user = new User();
        $user->fromSql($row);

        return $user;
    }

    /**
     * Add a new user to the database.
     *
     * @param User $user The User object representing the user to be added.
     * @return mixed The ID of the newly added user, or 0 if the addition failed.
     */
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

        return $insertUser->rowCount() > 0 ? $this->connection->getConnection()->lastInsertId() : 0;
    }

    /**
     * Edit an existing user in the database.
     *
     * @param  User $user The User object representing the user to be edited.
     * @return void
     */
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

    /**
     * Delete a user from the database.
     *
     * @param User $user The User object representing the user to be deleted.
     * @return void
     */
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


    /**
     *  Restore a previously deleted user in the database.
     *
     * @param User $user The User object representing the user to be restored.
     * @return void
     */
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

    /**
     * Check if a user with the same email or surname already exists in the database.
     *
     * This method queries the database to check if there are any existing users with the same
     * email or surname as the provided user. It returns an array of error messages indicating
     * which fields (email and/or surname) are already in use.
     *
     * @param User $user The User object representing the user to be checked.
     * @return array An array of error messages, if any. An empty array means no conflicts.
     */
    public function exists(User $user)
    {
        $query = $this->connection->getConnection()->prepare('SELECT email, surname
         FROM users
         WHERE email = :email OR surname = :surname');

        $query->execute([
            'email' => $user->email,
            'surname' => $user->surname,
        ]);

        $result = $query->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(function ($row) use ($user) {
            $messages = [];

            if($user->email === $row['email']) {
                array_push($messages, 'l\'email est déjà utilisé');
            }

            if($user->surname === $row['surname']) {
                array_push($messages, 'le surname est déjà utilisé');
            }

            return ucfirst(join(' et ', $messages));
        }, $result);
    }
}
