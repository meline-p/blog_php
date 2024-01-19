<?php session_start(); ?>
<?php include_once('../../parts/header.php'); ?>

<?php 
    include_once('../../php/functions.php');
    include_once('../../sql/pdo.php');

    if (isset($_GET['id'])) {
        $postId = $_GET['id'];

        if (ctype_digit($postId)) {
            $postId = intval($postId); 
    
            $query = $db->prepare('SELECT * FROM posts WHERE id = :postId');
            $query->execute(['postId' => $postId]);
    
            if ($query->rowCount() > 0) {
                $allPost = $query->fetch();
            } else {
                echo "Le post avec l'ID $postId n'a pas été trouvé.";
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
    <h1>Restaurer le post</h1>

    <form action="post_restore.php?id=<?= $allPost['id']; ?>" method="post">
        <label>Voulez-vous restaurer le post suivant ?</label>
        <br><br>

        <div class="col-lg-12 row">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $allPost['title'] ?></h5>
                    <p class="card-text"><b>Chapo</b> : <?= $allPost['chapo'] ?></p>
                    <p class="card-text"><b>Contenu</b> : <?= strip_tags($allPost['content']); ?></p>
                    <p class="card-text"><b>Auteur</b> : <?= $allPost['user_id'] ?></p>
                </div>
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-success btn-sm">Restaurer le post</button>
        <a class="btn btn-secondary btn-sm" href="../admin_posts_list.php">Annuler</a>

    </form>
</div>
