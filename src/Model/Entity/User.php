<?php

namespace App\Model\Entity;

use DateTime;

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

    // getters and setters
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

    public function init($role_id, $last_name, $first_name, $surname, $email, $password)
    {
        $this->role_id = $role_id;
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = new \DateTime();
    }

    public function delete($id)
    {
        $this->id = $id;
        $this->deleted_at = new \DateTime();
    }

    public function restore($id)
    {
        $this->id = $id;
        $this->deleted_at = null;
    }
}
