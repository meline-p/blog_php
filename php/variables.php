<?php

$posts = [
    [
        'id' => 1,
        'title' => 'Titre 1 du post', 
        'chapo' => '',
        'content' => "implement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.",
        'created_at' => '2023-10-10',
        'updated_at' => '2023-10-10',
        'is_published' => true
    ],
    [
        'id' => 2,
        'title' => 'Titre 2 du post', 
        'chapo' => '',
        'content' => 'contenu 2 du post',
        'created_at' => '2023-10-10',
        'updated_at' => '2023-10-10',
        'is_published' => false
    ],
    [
        'id' => 3,
        'title' => 'Titre 3 du post',
        'chapo' => '', 
        'content' => "ontrairement à une opinion répandue, le Lorem Ipsum n'est pas simplement du texte aléatoire. Il trouve ses racines dans une oeuvre de la littérature latine classique datant de 45 av. J.-C., le rendant vieux de 2000 ans. Un professeur du Hampden-Sydney College, en Virginie, s'est intéressé à un des mots latins les plus obscurs, consectetur, extrait d'un passage du Lorem Ipsum, et en étudiant tous les usages de ce mot dans la littérature classique, découvrit la source incontestable du Lorem Ipsum. Il provient en fait des sections 1.10.32 et 1.10.33 du",
        'created_at' => '2023-10-10',
        'updated_at' => '2023-10-10',
        'is_published' => true
    ],
];

$users = [
    [
        'email' => 'meline.pischedda@gmail.com',
        'password' => '123456',
        'surname' => 'meline'
    ],
    [
        'email' => 'test@gmail.com',
        'password' => '987654321',
        'surname' => 'test'
    ],
];

foreach ($posts as &$post) {
    if (isset($post['content']) && strlen($post['content']) > 140) {
        $post['chapo'] = substr($post['content'], 0, 140) . '...';
    } else {
        $post['chapo'] = $post['content'];
    }
}

unset($post);