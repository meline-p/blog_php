<?php

namespace App\Model\Entity;

/**
 * Class representing Role entity.
 */
class Role
{
    // properties
    public $id;
    public $name;

    /**
     * Populate the Role object from a database row.
     *
     * @param  mixed $row Database row representing a role
     * @return void
     */
    public function fromSql($row)
    {
        $this->id = $row['id'];
        $this->name = $row['name'];
    }
}
