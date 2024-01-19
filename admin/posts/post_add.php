<?php session_start(); ?>
<?php include_once('../../parts/header.php'); ?>

<?php 
    include_once('../../php/functions.php');
    include_once('../../sql/pdo.php');

if (
    !isset($_POST['title']) || empty($_POST['title']) ||
    !isset($_POST['content']) || empty($_POST['content'])
) {
    echo "Veuillez remplir les champs Titre et Contenu.";
    return;
}

$title = $_POST['title'];
$chapo = $_POST['chapo'];
$content = $_POST['content'];
$user_id = $_POST['author'];
$is_published = isset($_POST['is_published']) ? 1 : 0;

$insertPost = $db->prepare('INSERT INTO posts(user_id, title, chapo, content, is_published) 
    VALUES (:user_id, :title, :chapo, :content, :is_published)');

$insertPost->execute([
    'user_id' => $user_id,
    'title' => $title,
    'chapo' => $chapo,
    'content' => $content,
    'is_published' => $is_published
]);
?>

<div class="col-lg-12 row">
    <div class="col-lg-3">
        <?php include_once('../parts/sidebar.php'); ?>
    </div>

    <div id="content" class="container col-lg-9">

        <h1>Post ajouté</h1>
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $title ?></h5>
                    <p class="card-text"><b>Chapo</b> : <?= $chapo ?></p>
                    <p class="card-text"><b>Contenu</b> : <?= strip_tags($content); ?></p>
                    <p class="card-text"><b>Auteur</b> : <?= $user_id ?></p>
                    <p class="card-text"><b>Publié</b> : <?= $is_published === 1 ? 'Oui' : 'Non' ?></p>
                </div>
            </div>

            <br>
            <a class="btn btn-secondary btn-sm" href="../admin_posts_list.php">Revenir aux posts</a>

    </div>
</div>
        