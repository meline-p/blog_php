<?php

namespace App\controllers;

class ErrorController
{
    /**
    * Display the error page.
    *
    * @return void
    */
    public function errorPage()
    {
        require_once(__DIR__ . '/../../templates/error_page.php');
    }
}
