<?php $title = "Activer l'utilisateur" ?>

<?php ob_start(); ?>

<form action="/admin/utilisateur/restaurer/confirmation/<?= $user->id; ?>" method="post">
    <label>Voulez-vous activer l'utilisateur suivant ?</label>
    <br><br>

    <div class="col-lg-12 row">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Utilisateur :</h5>
                <p class="card-text"><b>Rôle</b> : <?= $user->role_name ?? ''; ?></p>
                <p class="card-text"><b>pseudo</b> : <?= $user->surname ?></p>
                <p class="card-text"><b>Nom</b> : <?= $user->last_name ?></p>
                <p class="card-text"><b>Prénom</b> : <?= $user->first_name ?></p>
                <p class="card-text"><b>Email</b> : <?= $user->email ?></p>
            </div>
        </div>
    </div>

    <br>
    <button type="submit" class="btn btn-success btn-sm">Activer l'utilisateur</button>
    <a class="btn btn-secondary btn-sm" href="/admin/utilisateurs">Annuler</a>

</form>

<?php $content = ob_get_clean(); ?>

<?php require('../templates/admin/parts/admin_layout.php') ?>
