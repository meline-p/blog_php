<?php 

function isPublishedPost(array $post): bool
{
    if(array_key_exists('is_published', $post)) {
        $isPublished = $post['is_published'];
    } else {
        $isPublished = false;
    }
    
    return $isPublished;
}

function getPosts(array $posts) : array
{
    $published_posts = [];

    foreach($posts as $post) {
        if(isPublishedPost($post)) {
            $published_posts[] = $post;
        }
    }

    return $published_posts;
}

function getPostById($postId, $posts) {
    foreach ($posts as $post) {
        if ($post['id'] == $postId && $post['is_published'] == true) {
            return $post;
        }
    }
    return null;
}

