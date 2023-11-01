<?php include_once('../templates/parts/header_page.php'); ?>

<div class="col-lg-12 row">
    <div class="col-lg-3">
    <?php include_once('parts/sidebar_page.php'); ?>
    </div>

    <div id="content" class="container col-lg-9">
        <h1>Posts</h1>
        <a class="btn btn-primary btn-sm" href="posts/add_post.php"><i class="fa-solid fa-plus"></i> Ajouter un post</a>

        <div class="col-lg-12 row">
            
            <div>
                <br>
                <button class="btn btn-outline-dark btn-sm">Cacher les posts supprimés</button>
                <br>
            </div>
            
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
                        <td>
                            <?php if (empty($allPost['deleted_at'])) : ?>
                                <a style="text-decoration:none;" class="" target="_blank" href="../showPost.php?id=<?= $allPost['id']; ?>"><?= $allPost['title'] ?></a>
                            <?php else : ?>
                                <span class="text-muted"><?= $allPost['title'] ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="<?= $allPost['deleted_at'] ? 'text-muted' : '' ?>"><?= $allPost['user_surname'] ?></td>
                        <td class='<?= $allPost['deleted_at'] ? 'text-muted' : ($allPost['is_published'] ? 'text-success' : 'text-danger') ?>'>
                            <strong><?= $allPost['is_published'] ? '✓' : 'X' ?></strong>
                        </td>
                        <td class="<?= $allPost['deleted_at'] ? 'text-muted' : '' ?>"><?= $allPost['created_at'] ?></td>
                        <td class="<?= $allPost['deleted_at'] ? 'text-muted' : '' ?>"><?= $allPost['updated_at'] ? $allPost['updated_at'] : '-' ?></td>
                        <td>
                            <?php if ($allPost['deleted_at']) : ?>
                                <a href="posts/restore_post.php?id=<?= $allPost['id'] ?>" class="btn btn-secondary btn-sm">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </a>
                            <?php else : ?>
                                <a href="posts/edit_post.php?id=<?= $allPost['id']; ?>" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="posts/delete_post.php?id=<?= $allPost['id']; ?>" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once('parts/admin_footer_page.php'); ?>