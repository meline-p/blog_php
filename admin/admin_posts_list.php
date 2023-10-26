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
            <table class="table text-center">
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
                    <?php foreach ($allPosts as $allPost) : ?>
                        <tr>
                            <td><a target="_blank" href="../showPost.php?id=<?= $allPost['id']; ?>"><?= $allPost['title'] ?></a></td>
                            <td><?= $allPost['user_id'] ?></td>
                            <td class='<?= $allPost['is_published'] ? 'text-success' : 'text-danger' ?>'>
                                <strong><?= $allPost['is_published'] ? 'Oui' : 'Non' ?></strong>
                            </td>
                            <td><?= $allPost['created_at'] ?></td>
                            <td><?= $allPost['updated_at'] ? $allPost['updated_at'] : '-' ?></td>
                            <td>
                                <?php if ($allPost['deleted_at']) : ?>
                                    <a href="#" class="btn btn-secondary btn-sm">
                                        <i class="fa-solid fa-rotate-left"></i>
                                    </a>
                                <?php else : ?>
                                    <a href="#" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include_once('parts/admin_footer.php'); ?>