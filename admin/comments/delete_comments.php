<?php 
    session_start();
    include_once('../../sql/pdo.php');
    require('../../src/models/user.php');
    require('../../src/models/post.php');

    $users = getUsers($db);
    $posts = getAllPosts($db);

    if (isset($_GET['id'])) {
        $commentId = $_GET['id'];

        if (ctype_digit($commentId)) {
            $commentId = intval($commentId); 
    
            $query = $db->prepare('SELECT  c.*, u.surname AS user_surname 
                FROM comments c
                LEFT JOIN users u ON c.user_id = u.id
                WHERE c.id = :commentId');
            $query->execute([
                'commentId' => $commentId
            ]);
    
            if ($query->rowCount() > 0) {
                $allComment = $query->fetch();

                $user_id = $allComment['user_id'];
                $user = getUserById($db, $user_id, $users);
                $user_surname = $user['surname'];

                $post_id = $allComment['post_id'];
                $post = getPostById($db, $post_id, $posts);
                $post_title = $post['title']; 
            } else {
                echo "Le commentaire avec l'ID $commentId n'a pas été trouvé.";
            }
        } else {
            echo "ID non valide.";
        }
    }

    require('../../templates/admin/comments/delete_comments_page.php');
