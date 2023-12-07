<?php

namespace App\lib;

class AlertService
{
    public static function add($type, $message)
    {
        if(!isset($_SESSION['alerts'])) {
            $_SESSION['alerts'] = [];
        }

        array_push($_SESSION['alerts'], [
            'type' => $type,
            'message' => $message,
        ]);
    }

    public static function get()
    {
        if(!isset($_SESSION['alerts']) || empty($_SESSION['alerts'])) {
            return false;
        }

        return array_shift($_SESSION['alerts']);
    }
}
