<?php 
    session_start(); 
    include_once('../../parts/header.php');  
    include_once('../../php/functions.php');
    include_once('../../sql/pdo.php');

    if (isset($_GET['id'])) {
        $userId = $_GET['id'];
    } else {
        echo "L'ID n'a pas été transmis dans l'URL.";
        return;
    }

    $userId = $_GET['id'];

    $restoreUser = $db->prepare('UPDATE users 
    SET deleted_at = :deleted_at
    WHERE id = :id ');

    $restoreUser->execute([
        'id' => $userId,
        'deleted_at' => null,
    ]);
?>

<div class="col-lg-12 row">
    <div class="col-lg-3">
        <?php include_once('../parts/sidebar.php'); ?>
    </div>

    <div id="content" class="container col-lg-9">
        <h1>Utilisateur activé</h1>
        <br>
        <a class="btn btn-secondary btn-sm" href="../admin_users_list.php">Revenir aux utilisateurs</a>

    </div>
</div>
        