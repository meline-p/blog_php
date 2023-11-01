<?php 
    session_start();
    require('../../sql/pdo.php');
    require('../../src/models/post.php');

    require('../../templates/admin/posts/add_post_page.php');
?>