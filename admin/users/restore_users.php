<?php session_start(); ?>
<?php include_once('../../parts/header.php'); ?>

<?php 
    include_once('../../php/functions.php');
    include_once('../../sql/pdo.php');

    if (isset($_GET['id'])) {
        $userId = $_GET['id'];

        if (ctype_digit($userId)) {
            $userId = intval($userId); 
    
            $query = $db->prepare('SELECT * FROM users WHERE id = :userId');
            $query->execute(['userId' => $userId]);
    
            if ($query->rowCount() > 0) {
                $user = $query->fetch();
            } else {
                echo "L'utilisateur avec l'ID $userId n'a pas été trouvé.";
            }
        } else {
            echo "ID non valide.";
        }
    }
?>
<div class="col-lg-12 row">
    <div class="col-lg-3">
        <?php include_once('../parts/sidebar.php'); ?>
    </div>

    <div id="content" class="container col-lg-9">
    <h1>Activer l'utilisateur</h1>

    <form action="post_restore_users.php?id=<?= $user['id']; ?>" method="post">
        <label>Voulez-vous activer l'utilisateur suivant ?</label>
        <br><br>

        <div class="col-lg-12 row">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Utilisateur :</h5>
                    <p class="card-text"><b>Rôle</b> : <?= $user['role_id'] ?></p>
                    <p class="card-text"><b>pseudo</b> : <?= $user['surname'] ?></p>
                    <p class="card-text"><b>Nom</b> : <?= $user['last_name'] ?></p>
                    <p class="card-text"><b>Prénom</b> : <?= $user['first_name'] ?></p>
                    <p class="card-text"><b>Email</b> : <?= $user['email'] ?></p>
                </div>
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-success btn-sm">Activer l'utilisateur</button>
        <a class="btn btn-secondary btn-sm" href="../admin_pusers_list.php">Annuler</a>

    </form>
</div>
