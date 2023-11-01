<?php include_once('../templates/parts/header_page.php'); ?>

<div class="col-lg-12 row">
    <div class="col-lg-3">
    <?php include_once('parts/sidebar_page.php'); ?>
    </div>

    <div id="content" class="container col-lg-9">
        <h1>Commentaires</h1>
      
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
                                <?= $allComment['user_surname'] ?></td>
                            <td class='<?= $allComment['is_enabled'] === null ? "table-active" : '' ?>'>
                                <a href="../showPost.php?id=<?= $allComment['post_id'] ?>"><?= $allComment['post_title'] ?></a>
                            </td>
                            <td class='<?= $allComment['is_enabled'] === null ? "table-active" : '' ?>'>
                                <?= $allComment['created_at'] ?>
                            </td>
                            <td class='<?= $allComment['is_enabled'] === null ? "table-active" : '' ?>'>
                                <?php if ($allComment['is_enabled'] === null) : ?>
                                    <a href="comments/valid_comments.php?id=<?= $allComment['id'] ?>" class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-check"></i>
                                    </a>
                                    <a href="comments/delete_comments.php?id=<?= $allComment['id'] ?>" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                <?php elseif (!$allComment['is_enabled']) : ?>
                                    <a href="comments/restore_comments.php?id=<?= $allComment['id'] ?>" class="btn btn-secondary btn-sm">
                                        <i class="fa-solid fa-rotate-left"></i>
                                    </a>
                                <?php else : ?>
                                    <a href="comments/delete_comments.php?id=<?= $allComment['id'] ?>" class="btn btn-danger btn-sm">
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


<?php include_once('parts/admin_footer_page.php'); ?>