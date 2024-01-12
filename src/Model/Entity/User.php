<?php

namespace App\Model\Entity;

use App\lib\Utility;
use DateTime;

/**
 * Class representing User entity.
 */
class User
{
    // properties
    public $id;
    public $role_id;
    public $last_name;
    public $first_name;
    public $surname;
    public $email;
    public $password;
    public $created_at;
    public $deleted_at;

    public $role_name;

    /**
     * Populate the User object from a database row.
     *
     * @param  mixed $row Database row representing a user
     */
    public function fromSql($row)
    {
        $this->id = $row['id'];
        $this->role_id = $row['role_id'];
        $this->last_name = $row['last_name'];
        $this->first_name = $row['first_name'];
        $this->surname = $row['surname'];
        $this->email = $row['email'];
        $this->password = $row['password'];
        $this->created_at = $row['created_at'];
        $this->deleted_at = $row['deleted_at'];

        $this->role_name = $row['role_name'];
    }

    /**
     * Initialize a new user with provided data.
     *
     * @param  mixed $role_id       ID of the user's role
     * @param  mixed $last_name     Last name of the user
     * @param  mixed $first_name    First name of the user
     * @param  mixed $surname       Surname of the user
     * @param  mixed $email         Email address of the user
     * @param  mixed $password      Password of the user
     */
    public function init($role_id, $last_name, $first_name, $surname, $email, $password)
    {
        $this->role_id = $role_id;
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->surname = Utility::removeAccent($surname);
        $this->email = $email;
        $this->password = $password;
        $this->created_at = new \DateTime();
    }

    /**
     * Update the user with new data.
     *
     * @param  mixed $role_id       ID of the user's role
     * @param  mixed $last_name     Last name of the user
     * @param  mixed $first_name    First name of the user
     * @param  mixed $surname       Surname of the user
     * @param  mixed $email         Email address of the user
     */
    public function update($role_id, $last_name, $first_name, $surname, $email)
    {
        $this->role_id = $role_id;
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->surname = Utility::removeAccent($surname);
        $this->email = $email;
    }

    /**
     * Mark the user as deleted.
     *
     * @param  mixed $id User ID
     */
    public function delete($id)
    {
        $this->id = $id;
        $this->deleted_at = new \DateTime();
    }

    /**
     * Restore a deleted user.
     *
     * @param  mixed $id User ID
     */
    public function restore($id)
    {
        $this->id = $id;
        $this->deleted_at = null;
    }
}
