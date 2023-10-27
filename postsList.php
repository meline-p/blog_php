<?php session_start(); ?>
<?php include_once('parts/header.php'); ?>
<?php include_once('parts/navbar.php'); ?>

<div id="content" class="container">

    <h1>Affichage des posts</h1>

    <?php 
    include_once('php/functions.php');
    include_once('sql/pdo.php');

    $sqlQuery = "SELECT * FROM posts
    WHERE is_published = 1 
    ORDER BY created_at DESC";
    $postsStatement = $db->prepare($sqlQuery);
    $postsStatement->execute();
    $posts = $postsStatement->fetchAll();
    ?>

    <div class="card-deck">
        <?php foreach ($posts as $post): ?>
           
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= $post['title']; ?></h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">
                        publié le <?= date_format(date_create($post['created_at']), "d/m/Y à H:i"); ?>
                        </h6>
                        <p class="card-text"><?= $post['chapo']; ?></p>
                        <a class="btn btn-outline-dark btn-sm" href="showPost.php?id=<?= $post['id']; ?>">voir la suite</a>
                    </div>
                </div>
         
        <?php endforeach; ?>
    </div>

</div>

<?php include_once('parts/footer.php'); ?>