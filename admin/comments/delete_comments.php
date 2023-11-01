<?php 
    session_start();
    include_once('../../php/functions.php');
    include_once('../../sql/pdo.php');

    if (isset($_GET['id'])) {
        $commentId = $_GET['id'];

        if (ctype_digit($commentId)) {
            $commentId = intval($commentId); 
    
            $query = $db->prepare('SELECT * FROM comments WHERE id = :commentId');
            $query->execute(['commentId' => $commentId]);
    
            if ($query->rowCount() > 0) {
                $allComment = $query->fetch();
            } else {
                echo "Le commentaire avec l'ID $commentId n'a pas été trouvé.";
            }
        } else {
            echo "ID non valide.";
        }
    }

    require('../../templates/admin/comments/delete_comments_page.php');
?>