<?php 
    session_start(); 

    require('sql/pdo.php');
    require_once('src/controllers/homepage.php');
    require_once('src/controllers/post.php');
    require_once('src/models/user.php');

    $routes = array(
        '/' => "src/controllers/homepage.php",
        '/se-connecter'=> ''
    );

    if (isset($_GET['action']) && $_GET['action'] !== '') {
        if ($_GET['action'] === 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $id = $_GET['id'];

                post($db, $id);
            } else {
                echo 'Erreur : aucun post à afficher';
    
                die;
            }
        } else {
            echo "Erreur 404 : la page que vous recherchez n'existe pas.";
        }
    } else {
        $users = getUsers($db);
        homepage($db, $users);
    }

