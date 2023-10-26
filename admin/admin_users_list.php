<?php session_start(); ?>
<?php include_once('../parts/header.php'); ?>

<div class="col-lg-12 row">
    <div class="col-lg-3">
        <?php include_once('parts/sidebar.php'); ?>
    </div>

    <div id="content" class="container col-lg-9">
        <h1>Utilisateurs</h1>
        <?php
        include_once('../php/functions.php');
        include_once('../sql/pdo.php');
        ?>

        <div class="col-lg-12 row">
            <div>Filter</div>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col">Rôle</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Pseudo</th>
                        <th scope="col">Email</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $user['role_id'] ?></td>
                            <td><?= $user['last_name'] ?></td>
                            <td><?= $user['first_name'] ?></td>
                            <td><?= $user['surname'] ?></td>
                            <td><?= $user['email'] ?></td>

                            <td>
                                <?php if ($user['deleted_at']) : ?>
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