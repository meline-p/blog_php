<?php     
    include_once('templates/parts/header_page.php');
    include_once('templates/parts/navbar_page.php'); 
?>

<div id="content" class="container">

    <h1>Affichage des posts</h1>

    <div class="card-deck">
        <?php foreach ($posts as $post): ?>
           
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= $post['title']; ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted" style="font-weight:normal;"><i>
                            <?php if($post['updated_at'] === null):?>
                               publié le <?= date_format(date_create($post['created_at']), "d/m/Y à H:i");?>
                            <?php else:?>
                                mis à jour le <?= date_format(date_create($post['updated_at']), "d/m/Y à H:i");?>
                            <?php endif; ?>  
                        </i></h6>
                        <p class="card-text"><i><?= $post['chapo']; ?></i></p>
                        <p class="card-text"><?= (strlen($post['content']) > 300) ? substr($post['content'], 0, 300) . '...' : $post['content']; ?></p>
                        <a class="btn btn-outline-dark btn-sm" href="showPost.php?id=<?= $post['id']; ?>">voir la suite</a>
                    </div>
                </div>
         
        <?php endforeach; ?>
    </div>

</div>
<?php 
    include_once('templates/parts/footer_page.php'); 
?>