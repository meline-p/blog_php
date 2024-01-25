<?php 
    session_start();
    require('../../sql/pdo.php');
    require('../../src/models/post.php');
    require('../../src/models/user.php');

    $users = getUsers($db);

    $sqlQuery = "SELECT p.*, u.surname AS user_surname
            FROM posts p
            LEFT JOIN users u ON p.user_id = u.id";
    $statement = $db->prepare($sqlQuery);
    $statement->execute();
    $allPosts = $statement->fetchAll(); 

    if (isset($_GET['id'])) {
        $postId = $_GET['id'];

        if (ctype_digit($postId)) {
            $postId = intval($postId); 
    
            $post = getPostById($db, $postId, $allPosts);
    
            if ($post) {
                
                $user_id = $post['user_id'];
                $user = getUserById($db, $user_id, $users);
                $user_surname = $user['surname'];

                require('../../templates/admin/posts/delete_post_page.php');
            } else {
                echo "Le post avec l'ID $postId n'a pas été trouvé.";
            }
        } else {
            echo "ID non valide.";
        }

    }  else {
        echo "L'ID n'a pas été transmis dans l'URL.";
    }

