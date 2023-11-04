<?php include_once('../../templates/parts/header_page.php'); ?>

<div class="col-lg-12 row">

    <div id="content" class="container col-lg-9">
    <h1>Ajouter un post</h1>
    <form action="post_add.php" method="post">
        <div class="row">
            <div class="col-lg-8">
                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" id="title" name="title" class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <label for="chapo">Chapô</label>
                    <input type="text" id="chapo" name="chapo" class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <label for="content">Contenu</label>
                    <textarea id="content" name="content" rows="15" class="form-control"></textarea>
                </div>
            </div>
            <div class="col-lg-4">

                <div class="form-group">
                    <label for="user_id">Auteur :</label>
                    <select name="user_id" id="user_id">
                        <?php foreach ($admins as $admin): ?>
                            <option value="<?php echo $admin['id']; ?>"<?php echo ($_SESSION['LOGGED_USER'] === $admin['surname']) ? ' selected' : ''; ?>>
                                <?php echo $admin['first_name'] . ' ' . $admin['last_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <br>             
                <div class="form-group">
                    <label for="is_published">Publié</label>
                    <input type="checkbox" id="is_published" name="is_published" value="1">
                </div>
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-success btn-sm">Ajouter un post</button>
        <a class="btn btn-secondary btn-sm" href="../admin_posts_list.php">Annuler</a>

    </form>
</div>
