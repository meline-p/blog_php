<?php
session_start();
include_once('../parts/header.php');

include_once('../php/functions.php');
include_once('../sql/pdo.php');

if (!isset($_SESSION['LOGGED_USER'])) {
    echo "Vous devez être connecté pour ajouter un commentaire.";
} elseif (isset($_POST['comment']) && !empty($_POST['comment']) && isset($_GET['id'])) {
    $postId = $_GET['id'];

    if (ctype_digit($postId)) {
        $postId = intval($postId);
        $userId = $_SESSION['USER_ID']; 

        $content = $_POST['comment'];
        $created_at = date('Y-m-d H:i:s');
        $insertComment = $db->prepare('INSERT INTO comments(user_id, post_id, content, created_at) 
            VALUES (:user_id, :post_id, :content, :created_at)');

        $insertComment->execute([
            'user_id' => $userId,
            'post_id' => $postId,
            'content' => $content,
            'created_at' => $created_at
        ]);

        echo "Votre commentaire a bien été ajouté.";
    } else {
        echo "ID non valide.";
    }
} else {
    echo "Veuillez remplir le champ commentaire.";
}
?>
