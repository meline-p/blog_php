<?php

class DatabaseConnection
{
    public ?PDO $db = null;

    public function getConnection(): PDO
    {
        if ($this->db === null) {
            $host = 'localhost';
            $dbname = 'blog_php';
            $charset = 'utf8';
            $username = 'root';
            $password = 'root';

            $this->db = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=$charset",
                $username,
                $password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
            );
        }

        return $this->db;
    }
}
