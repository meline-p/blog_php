<?php

namespace App\lib;

/**
 * Class representing CSRF Token.
 */
class CsrfService
{
    /**
     * Generates and returns a CSRF token.
     * If the request method is GET, generates a new token and stores it in the session.
     * Returns the current CSRF token, which can be used in forms.
     *
     * @return string The CSRF token.
     */
    public static function getCsrfToken()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $csrfToken = bin2hex(random_bytes(32));
            $_SESSION['csrf_token'] = $csrfToken;
        }

        return $_SESSION['csrf_token'];
    }

    /**
     * Redirects to an error page if the CSRF token is invalid.
     * If the request method is GET, the function does nothing.
     * If the request method is POST, it checks the presence and validity of the CSRF token.
     * If the token is invalid, the user is redirected to a CSRF error page.
     *
     * @return null
     */
    public static function redirectIfInvalid()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return null;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            header('location: /csrf_invalid');
            exit;
        }

        return null;
    }
}
