<?php

namespace App\controllers;

class ErrorController
{
    public function errorPage()
    {
        require_once(__DIR__ . '/../../templates/error_page.php');
    }
}
