<?php

namespace App\lib;

class DatabaseConnection
{
    public ?\PDO $db = null;

    public function getConnection(): \PDO
    {
        if ($this->db === null) {
            $host = 'localhost';
            $dbname = 'blog_php';
            $charset = 'utf8';
            $username = 'root';
            $password = 'root';

            $this->db = new \PDO(
                "mysql:host=$host;dbname=$dbname;charset=$charset",
                $username,
                $password,
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION],
            );
        }

        return $this->db;
    }

    public function getUserDataFromDatabase(int $userId): array
    {
        // Query to retrieve serialized user data from the database
        $stmt = $this->getConnection()->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);

        // Fetch the serialized data
        $serializedUserData = $stmt->fetchColumn();

        // Initialize session data
        $sessionData = [];

        // Check if data is found in the database
        if ($serializedUserData !== false) {
            // Unserialize the data
            $sessionData = unserialize($serializedUserData);

            // Ensure it is an array
            if (!is_array($sessionData)) {
                $sessionData = [];
            }
        }

        return $sessionData;
    }
}
