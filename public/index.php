<?php

spl_autoload_register(function ($class) {

    // Convertit les barres obliques inverses en barres obliques
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    // Ajoutez le chemin racine de votre application
    $file = __DIR__ . '/../src/' . $class . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

require_once('../src/Model/Entity/User.php');
if(isset($_SESSION['user'])) {
    $_SESSION['user_data'] = serialize($_SESSION['user']);
    $user = unserialize($_SESSION['user_data'], ['allowed_classes' => ['App\Model\Entity\User']]);
};

session_start();
require_once("../vendor/autoload.php");
require_once("../src/app.php");
