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

    $deleteUser = $db->prepare('UPDATE users 
    SET deleted_at = :deleted_at
    WHERE id = :id ');

    $currentTime = date('Y-m-d H:i:s');

    $deleteUser->execute([
        'id' => $userId,
        'deleted_at' => $currentTime,
    ]);
?>

<div class="col-lg-12 row">
    <div class="col-lg-3">
        <?php include_once('../parts/sidebar.php'); ?>
    </div>

    <div id="content" class="container col-lg-9">
        <h1>Utilisateur désactivé</h1>
        <br>
        <a class="btn btn-secondary btn-sm" href="../admin_users_list.php">Revenir aux utilisateurs</a>

    </div>
</div>
        