<?php

namespace App\Model\Repository;

use App\lib\DatabaseConnection;
use App\Model\Entity\Role;

/**
 * Class representing Role repository.
 */
class RoleRepository
{
    private DatabaseConnection $connection;

    /**
     * Constructor for the RoleRepository class.
     *
     * @param DatabaseConnection $connection The DatabaseConnection object to be used by the class.
     */
    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Retrieves all roles from the database.
     *
     * @return array An array of Role objects representing the roles.
     */
    public function getRoles()
    {
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
