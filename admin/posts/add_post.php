<?php 
    session_start();
    require('../../sql/pdo.php');
    require('../../src/models/post.php');
    require('../../src/models/user.php');

    $admins = getAdmins($db);

    require('../../templates/admin/posts/add_post_page.php');
?>