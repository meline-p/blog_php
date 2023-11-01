<?php 
    session_start();
    include_once('../../parts/header.php');
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
?>
<div class="col-lg-12 row">
    <div class="col-lg-3">
        <?php include_once('../parts/sidebar.php'); ?>
    </div>

    <div id="content" class="container col-lg-9">
    <h1>Restaurer le commentaire</h1>

    <form action="post_valid_comments.php?id=<?= $allComment['id']; ?>" method="post">
        <label>Voulez-vous restaurer le commentaire suivant ?</label>
        <br><br>

        <div class="col-lg-12 row">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Commentaire</h5>
                    <p class="card-text"><b>Contenu</b> : <?= $allComment['content'] ?></p>
                    <p class="card-text"><b>Auteur du commentaire</b> : <?= $allComment['user_id'] ?></p>
                    <p class="card-text"><b>Post</b> : <?= $allComment['post_id'] ?></p>
                </div>
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-success btn-sm">Restaurer le commentaire</button>
        <a class="btn btn-secondary btn-sm" href="../admin_comments_list.php">Annuler</a>

    </form>
</div>
