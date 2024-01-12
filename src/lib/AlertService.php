<?php

namespace App\lib;

/**
 * Class representing service alert.
 *
 * This class allows to show alert messages
 */
class AlertService
{
    /**
     * Adds a new alert message to the session.
     *
     * @param  mixed $type The type of the alert (e.g., 'success', 'danger').
     * @param  mixed $message The message content of the alert.
     * @return void
     */
    public static function add($type, $message)
    {
        // Ensure the 'alerts' session variable exists
        if(!isset($_SESSION['alerts'])) {
            $_SESSION['alerts'] = [];
        }

        // Add a new alert to the session
        array_push($_SESSION['alerts'], [
            'type' => $type,
            'message' => $message,
        ]);
    }

    /**
     * Retrieves the oldest alert from the session.
     *
     * @return mixed The oldest alert or false if no alerts are present.
     */
    public static function get()
    {
        // Check if 'alerts' session variable exists and is not empty
        if(!isset($_SESSION['alerts']) || empty($_SESSION['alerts'])) {
            return false;
        }

        // Return the oldest alert and remove it from the session
        return array_shift($_SESSION['alerts']);
    }
}
