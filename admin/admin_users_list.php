<?php 
    session_start();
    include_once('../parts/header.php'); 
    include_once('../php/functions.php');
    include_once('../sql/pdo.php');

    $sqlQuery = "SELECT u.*, r.name AS role_name
            FROM users u
            LEFT JOIN roles r ON u.role_id = r.id
            ORDER BY COALESCE(u.deleted_at, u.created_at) ASC";
    $rolesStatement = $db->prepare($sqlQuery);
    $rolesStatement->execute();
    $users = $rolesStatement->fetchAll();
?>

<div class="col-lg-12 row">
    <div class="col-lg-3">
        <?php include_once('parts/sidebar.php'); ?>
    </div>

    <div id="content" class="container col-lg-9">
        <h1>Utilisateurs</h1>

        <div class="col-lg-12 row">
            <div>Filter</div>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col">Rôle</th>
                        <th scope="col">Pseudo</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Date de Création</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td>
                                <?php
                                    $userRoleName = $user['role_name'];
                                    echo $userRoleName;
                                ?>
                            </td>
                            <td><?= $user['surname'] ?></td>
                            <td><?= $user['last_name'] ?></td>
                            <td><?= $user['first_name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['created_at'] ?></td>
                            <td>
                                <?php if ($user['deleted_at']) : ?>
                                    <a href="users/restore_users.php?id=<?= $user['id'] ?>" class="btn btn-secondary btn-sm">
                                        <i class="fa-solid fa-rotate-left"></i>
                                    </a>
                                <?php else : ?>
                                    <a href="users/delete_users.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm">
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