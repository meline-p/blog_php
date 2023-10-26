<?php session_start(); ?>
<?php include_once('../parts/header.php'); ?>

<div class="col-lg-12 row">
    <div class="col-lg-3">
        <?php include_once('parts/sidebar.php'); ?>
    </div>

    <div id="content" class="container col-lg-9">
    <h1>Posts</h1>
    <a class="btn btn-primary btn-sm" href="add_post.php"><i class="fa-solid fa-plus"></i> Ajouter un post</a>

        <?php 
            include_once('../php/functions.php');
            include_once('../sql/pdo.php');
        ?>

        <div class="col-lg-12 row">
            <div>Filter</div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Titre</th>
                        <th scope="col">Auteur</th>
                        <th scope="col">Publié</th>
                        <th scope="col">Date de création</th>
                        <th scope="col">Date de Modification</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($allPosts as $allPost):?>
                        <tr>
                            <td><?= $allPost['title'] ?></td>
                            <td><?= $allPost['user_id'] ?></td>
                            <td><?= $allPost['is_published'] ? 'Oui' : 'Non' ?></td>
                            <td><?= $allPost['created_at'] ?></td>
                            <td><?= $allPost['updated_at'] ?></td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <br>
                                <a href="#" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a class="btn btn-secondary btn-sm" href="#"><i class="fa-solid fa-trash"></i> Afficher les posts supprimés</a>
    </div>
</div>


<?php include_once('parts/admin_footer.php'); ?>