<?php

namespace App\Model\Entity;

class User
{
    // properties
    private $id;
    private $role_id;
    private $last_name;
    private $first_name;
    private $surname;
    private $email;
    private $password;
    private $created_at;
    private $deleted_at;

    // getters and setters

    // id
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    // role_id
    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    // last_name
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    // first_name
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    // surname
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    // email
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    // password
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    // created_at
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    //deleted_at
    public function setDeletedAt($deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }

    public function getDeletedAt()
    {
        return $this->deleted_at;
    }
}
