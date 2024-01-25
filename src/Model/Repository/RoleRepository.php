<?php

namespace App\Model\Repository;

use App\lib\DatabaseConnection;
use App\Model\Entity\Role;

class RoleRepository
{
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getRoles(){
        $statement = $this->connection->getConnection()->prepare("SELECT * FROM roles");
        $statement->execute();
        $rows =  $statement->fetchAll();
        $roles = array_map(function ($row) {
            $role = new Role();
            $role->fromSql($row);
            return $role;
        }, $rows);

        return $roles;

    }
}