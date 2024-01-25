<?php

namespace App\Model\Entity;

class Role
{
    // properties
    public $id;
    public $name;

    // getters and setters
    public function fromSql($row)
    {
        $this->id = $row['id'];
        $this->name = $row['name'];
    }
}
