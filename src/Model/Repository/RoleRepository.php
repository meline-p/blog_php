<?php

namespace App\Model\Repository;

use App\lib\DatabaseConnection;

class RoleRepository
{
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }
}
