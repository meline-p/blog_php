<?php

namespace App\lib;

use Dotenv\Dotenv;

/**
 * Class representing database connection.
 *
 * This class allows to establish a database connection
 * and retrieves user data from the database
 */
class DatabaseConnection
{
    /**
     * PDO instance for database connection.
     *
     * @var \PDO|null
     */
    public ?\PDO $db = null;

    /**
     * Establishes a database connection and returns the PDO instance.
     *
     * @return \PDO The PDO instance.
     */
    public function getConnection(): \PDO
    {
        // Check if the PDO instance is not already created
        if ($this->db === null) {
            // Load environment variables from .env
            $dotenv = Dotenv::createImmutable(__DIR__.'/../../');
            $dotenv->load();

            // Database connection details from .env
            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $dbname = $_ENV['DB_NAME'] ?? 'blog_php';
            $charset = 'utf8';
            $username = $_ENV['DB_USERNAME'] ?? 'root';
            $password = $_ENV['DB_PASSWORD'] ?? 'root';
            $unix_socket = $_ENV['DB_UNIX_SOCKET'] ?? '';

            // Create a new PDO instance
            $this->db = new \PDO(
                "mysql:host=$host;dbname=$dbname;charset=$charset;unix_socket=$unix_socket",
                $username,
                $password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"
                ],
            );
        }

        // Return the PDO instance
        return $this->db;
    }
}
