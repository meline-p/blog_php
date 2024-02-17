<?php

namespace App\lib;

class CsrfService
{
    public static function getCsrfToken()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $csrfToken = bin2hex(random_bytes(32));
            $_SESSION['csrf_token'] = $csrfToken;
        }

        return $_SESSION['csrf_token'];
    }

    public static function redirectIfInvalid()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            header('location: /csrf_invalid');
            exit;
        }
    }
}
