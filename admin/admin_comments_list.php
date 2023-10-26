<?php session_start(); ?>
<?php include_once('../parts/header.php'); ?>

<div class="col-lg-12 row">
    <div class="col-lg-3">
        <?php include_once('parts/sidebar.php'); ?>
    </div>

    <div id="content" class="container col-lg-9">
        <h1>Commentaires</h1>
        <?php
        include_once('../php/functions.php');
        include_once('../sql/pdo.php');
        ?>

        <div class="col-lg-12 row">
            <div>Filter</div>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col">Commentaire</th>
                        <th scope="col">Auteur du commentaire</th>
                        <th scope="col">Titre du post</th>
                        <th scope="col">Date de création</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allComments as $allComment) : ?>
                        <tr>
                            <td class='<?= $allComment['is_enabled'] === null ? "table-active" : '' ?>'>
                                <?= $allComment['content'] ?>
                            </td>
                            <td class='<?= $allComment['is_enabled'] === null ? "table-active" : '' ?>'>
                                <?= $allComment['user_id'] ?></td>
                            <td class='<?= $allComment['is_enabled'] === null ? "table-active" : '' ?>'>
                                <?= $allComment['post_id'] ?>
                            </td>
                            <td class='<?= $allComment['is_enabled'] === null ? "table-active" : '' ?>'>
                                <?= $allComment['created_at'] ?>
                            </td>
                            <td class='<?= $allComment['is_enabled'] === null ? "table-active" : '' ?>'>
                                <?php if ($allComment['is_enabled'] === null) : ?>
                                    <a href="#" class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-check"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                <?php elseif (!$allComment['is_enabled']) : ?>
                                    <a href="#" class="btn btn-secondary btn-sm">
                                        <i class="fa-solid fa-rotate-left"></i>
                                    </a>
                                <?php else : ?>
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