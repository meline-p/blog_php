<?php session_start(); ?>
<?php include_once('parts/header.php'); ?>
<?php include_once('parts/navbar.php'); ?>

<div id="content" class="container">

    <?php 
    include_once('php/functions.php');
    include_once('sql/pdo.php');

    if (isset($_GET['id'])) {
        $postId = $_GET['id'];
        $post = getPostById($postId, $posts);

        if($post) {
    ?>
        <div>
            <h3><?= $post['title']; ?></h3>
            <p><i>
                <?php if($post['updated_at'] === null):?>
                    publié le <?= date_format(date_create($post['created_at']), "d/m/Y à H:i");?>
                <?php else:?>
                    mis à jour le <?= date_format(date_create($post['updated_at']), "d/m/Y à H:i");?>
                <?php endif; ?> 
            </i></p>
            <p><?= $post['content']; ?></p>
            <a class="btn btn-dark" href="postsList.php">Retour à la liste des posts</a>
        </div>

    <?php
        } else { 
            echo "Aucun post trouvé pour cet ID.";
        }

    } else {
        echo "ID non défini.";
    }
    ?>
<br>
<hr>

    <h4>Commentaires</h4>
    <br>
    <?php 
        $sqlQuery = 'SELECT c.*, u.surname AS user_surname
        FROM comments c 
        INNER JOIN posts p ON p.id = c.post_id
        INNER JOIN users u ON u.id = c.user_id
        WHERE is_enabled = :is_enabled 
        AND c.post_id = :post_id';
        $commentsStatement = $db->prepare($sqlQuery);
        $commentsStatement->execute([
            'is_enabled' => true,
            'post_id' => $post['id']
        ]);
        $comments = $commentsStatement->fetchAll(); 
        ?>

        <div class="card-deck">
            <?php foreach($comments as $comment): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2"><?= $comment['user_surname']; ?></h6>
                        <h6 class="card-subtitle mb-2 text-muted" style="font-weight:normal;"><i>
                            publié le <?= date_format(date_create($comment['created_at']), "d/m/Y à H:i"); ?>
                        </i></h6>
                        <p class="card-text"><?= $comment['content']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <hr>
        <div>
            <?php include_once('parts/comments_form.php'); ?>
        </div>
</div>

<?php include_once('parts/footer.php'); ?>