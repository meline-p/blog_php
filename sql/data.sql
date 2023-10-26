DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;

CREATE TABLE roles (
    id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name varchar(255) NOT NULL
);

CREATE TABLE users (
    id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    role_id int(11) NOT NULL,
    last_name varchar(255) NOT NULL,
    first_name varchar(255) NOT NULL,
    surname varchar(255),
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    deleted_at TIMESTAMP NULL,
    UNIQUE (surname)
);

CREATE TABLE posts (
    id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id int(11) NOT NULL,
    title varchar(255) NOT NULL,
    chapo varchar(255),
    content TEXT NOT NULL,
    is_published boolean NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE comments (
    id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id int(11) NOT NULL,
    post_id int(11) NOT NULL,
    content TEXT NOT NULL,
    is_enabled boolean NOT NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (post_id) REFERENCES posts(id)
);

-- ROLES
INSERT INTO roles (name) VALUES ('Administrateur'),('Utilisateur');

-- USERS
INSERT INTO users(role_id, last_name, first_name, surname, email, password) VALUES
(1, 'Pischedda', 'Méline', "melinep", "meline.pischedda@gmail.com", "123456"),
(2, 'Test', 'Test', 'test', 'test@gmail.com', "987654321");

-- POSTS
INSERT INTO posts (user_id, title, chapo, content, is_published, created_at) VALUES
(1, 'Titre 1 du post', 'chapo 1', "implement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.", 1, CURRENT_TIMESTAMP),
(1, 'Titre 2 du post', 'chapo 2', 'contenu 2 du post', 0, CURRENT_TIMESTAMP),
(1, 'Titre 3 du post', 'chapo 3', "ontrairement à une opinion répandue, le Lorem Ipsum n'est pas simplement du texte aléatoire. Il trouve ses racines dans une oeuvre de la littérature latine classique datant de 45 av. J.-C., le rendant vieux de 2000 ans. Un professeur du Hampden-Sydney College, en Virginie, s'est intéressé à un des mots latins les plus obscurs, consectetur, extrait d'un passage du Lorem Ipsum, et en étudiant tous les usages de ce mot dans la littérature classique, découvrit la source incontestable du Lorem Ipsum. Il provient en fait des sections 1.10.32 et 1.10.33 du", 1, CURRENT_TIMESTAMP);