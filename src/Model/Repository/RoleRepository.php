<?php

namespace Repository;

use DatabaseConnection;

class RoleRepository
{
    private \DatabaseConnection $connection;

    public function __construct(\DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }
}
