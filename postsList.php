<?php session_start(); ?>
<?php include_once('parts/header.php'); ?>
<?php include_once('parts/navbar.php'); ?>

<div id="content" class="container">

    <h1>Affichage des posts</h1>

    <?php 
    include_once('php/variables.php');
    include_once('php/functions.php');
    ?>

    <?php foreach(getPosts($posts) as $post): ?>
        <?php if(array_key_exists('is_published', $post) && $post['is_published'] == true): ?>
            <div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $post['title']; ?></h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">publié le <?= $post['created_at']; ?></h6>
                        <p class="card-text"><?= $post['chapo']; ?></p>
                        <a class="btn btn-outline-dark btn-sm" href="showPost.php?id=<?= $post['id']; ?>">voir la suite</a>
                    </div>
                </div>

            </div>
        <?php endif; ?>
    <?php endforeach; ?>

</div>

<?php include_once('parts/footer.php'); ?>