-- Drop tables if they exist
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;

-- Create tables
CREATE TABLE roles (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL
);

CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  role_id INT NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  first_name VARCHAR(255) NOT NULL,
  surname VARCHAR(255) UNIQUE DEFAULT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  deleted_at DATETIME DEFAULT NULL,
  FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE posts (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  chapo VARCHAR(255) DEFAULT NULL,
  content TEXT NOT NULL,
  is_published BOOLEAN NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT NULL,
  deleted_at DATETIME DEFAULT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE comments (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  post_id INT NOT NULL,
  content TEXT NOT NULL,
  is_enabled BOOLEAN DEFAULT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  deleted_at DATETIME DEFAULT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (post_id) REFERENCES posts(id)
);

-- Insert Data
INSERT INTO roles (name) VALUES
('Administrateur'),
('Utilisateur');

INSERT INTO users (role_id, last_name, first_name, surname, email, password, created_at, deleted_at) VALUES
(1, 'Pischedda', 'Méline', 'melinep', 'meline.pischedda@gmail.com', '$2y$10$phiKnB965wo9Vwg8onEyjOVbNgx.SvsVI9QjHkWLi138F9Kso3W8a', '2024-01-26 17:15:58', NULL),
(2, 'Martin', 'Emma', 'emmadventures', 'emma.martin@email.com', '$2y$10$Qh3MAgrtngN7RHroGuYfEubR1bEt/waXIyC8dOSueLJoeVok4Q4QG', '2024-01-26 17:17:51', NULL),
(2, 'Dupont', 'Lucas', 'thelucasexplorer', 'lucas.dupont@email.com', '$2y$10$gS0dojfMg1M5B6ZPsfRx.uSEcVl7e6Omc/I8jEQfWO6pJqUkY216G', '2024-01-26 17:18:50', NULL),
(1, 'Rodriguez', 'Sofia', 'sunnysofia', 'sofia.rodriguez@email.com', '$2y$10$dToea8hjq2FgAFq7hTpML.y8p5EgYEf7EFLBYl8S6FnmERihOczPK', '2024-01-26 17:20:04', NULL),
(2, 'Leroy', 'Hugo', 'skyhighhugo', 'hugo.leroy@email.com', '$2y$10$86wNEcUGywY4WRCYNvw5COLt8oK.2dZrCDgPmttt0/AZ2GSnbSUg.', '2024-01-26 17:26:44', NULL),
(2, 'Diop', 'Amina', 'aminadreams', 'amina.diop@email.com', '$2y$10$RULnEG7qTE86JzbbyWE6de54NDutUtgvQVExdg/FxOZ7GPmKTl/sK', '2024-01-26 17:27:30', NULL),
(1, 'Lambert', 'Gabriel', 'galacticgab', 'gabriel.lambert@email.com', '$2y$10$MpiewaMpvXMUjorxryW89.C7FlGP21TCIYB4Zro53HLmqpgjlmZfS', '2024-01-26 17:28:21', NULL),
(2, 'Dubois', 'Léa', 'creativaleauxui', 'lea.dubois.design@gmail.com', '$2y$10$hNfPuv8IP4vz8iNWW58.Eel1CQahVtZubVAqQ3C.Mq5pRvvfuGG7i', '2024-01-26 20:19:14', '2024-01-26 20:19:27');


INSERT INTO posts (user_id, title, chapo, content, is_published, created_at, updated_at, deleted_at) VALUES
(1, "Langages Web : Comparatif Essentiel", "Découvrez les différences clés entre HTML, CSS et JavaScript. Ce guide vous aidera à comprendre leur rôle dans le développement web.", "Le développement web repose sur trois langages fondamentaux : HTML, CSS et JavaScript. Chacun joue un rôle distinct dans la création d\'un site web interactif et est essentiel pour comprendre les bases du développement.\r\n\r\n- HTML (HyperText Markup Language): Il sert à structurer le contenu d\'une page web en utilisant des balises telles que <div>, <p> et <h1>. HTML fournit la base structurelle pour la présentation de l\'information.\r\n\r\n- CSS (Cascading Style Sheets): En charge du design et de la mise en page, CSS permet de styliser les éléments HTML. Il offre des sélecteurs pour cibler spécifiquement des parties du code HTML, appliquant des styles tels que la couleur, la taille du texte et la disposition.\r\n\r\n- JavaScript: En ajoutant de l\'interactivité, JavaScript permet de créer des sites web dynamiques. Il peut manipuler le contenu HTML, réagir aux événements utilisateur et communiquer avec des serveurs pour obtenir des données en temps réel.\r\n\r\nComprendre ces langages est essentiel pour tout développeur web, car ils travaillent ensemble pour créer une expérience utilisateur harmonieuse et attrayante.", 1, '2024-01-26 17:34:26', '2024-01-26 18:04:18', NULL),
(4, "PHP dans le Développement Web", "Explorez les bases de PHP, son rôle dans les sites dynamiques, et découvrez comment il peut améliorer vos projets web.", "PHP, acronyme de \'Hypertext Preprocessor\', est un langage de script côté serveur largement utilisé dans le développement web. Voici quelques points essentiels sur PHP :\r\n\r\n- Dynamisme des Pages Web : PHP est particulièrement adapté à la création de sites web dynamiques. Il peut générer du contenu dynamiquement, interagir avec des bases de données et traiter des formulaires, permettant ainsi de créer des applications web interactives.\r\n\r\n- Intégration avec HTML : PHP peut être intégré directement dans le code HTML, ce qui facilite la création de pages web dynamiques. Les balises PHP, telles que <?php ... ?>, permettent d\'insérer du code PHP au sein de fichiers HTML.\r\n\r\n- Frameworks PHP : Des frameworks populaires tels que Laravel et Symfony simplifient le processus de développement en fournissant une structure organisée, des fonctionnalités prêtes à l\'emploi et une sécurité renforcée.\r\n\r\nEn comprenant ces aspects de PHP, les développeurs peuvent créer des sites web robustes et fonctionnels.", 1, '2024-01-26 17:35:33', '2024-01-26 17:35:33', NULL),
(7, "Frameworks Frontend : Vue d\'Ensemble", "Découvrez l\'impact de React, Vue.js et Angular dans le développement moderne. Explorez comment ces frameworks facilitent la création d\'interfaces dynamiques.", "Les frameworks frontend ont révolutionné la manière dont les développeurs construisent des interfaces utilisateur interactives et réactives. Focus sur trois des frameworks les plus populaires :\r\n\r\n- React : Développé par Facebook, React est une bibliothèque JavaScript utilisée pour la construction d\'interfaces utilisateur. Il utilise un concept appelé \'Virtual DOM\' pour améliorer les performances et offre une approche déclarative du développement.\r\n\r\n- Vue.js : Conçu pour être progressivement adopté, Vue.js est un framework JavaScript flexible et simple. Il facilite la création d\'interfaces utilisateur réactives avec des composants réutilisables et une gestion efficace de l\'état.\r\n\r\n- Angular : Développé par Google, Angular est un framework complet qui couvre tout, de la création d\'interfaces utilisateur à la gestion de l\'état et à la communication avec les serveurs. Il utilise le langage TypeScript pour une typage statique et une meilleure maintenabilité du code.\r\n\r\nCes frameworks simplifient le développement frontend en offrant des solutions prêtes à l\'emploi pour des tâches courantes, permettant aux développeurs de se concentrer sur la création d\'expériences utilisateur exceptionnelles.", 1, '2024-01-26 17:36:58', '2024-01-26 17:36:58', NULL),
(4, "Gérer un Projet de A à Z dans le Développement", "Découvrez les étapes cruciales pour gérer efficacement un projet de développement, de la conception à la mise en œuvre. Ce guide pratique vous aide à naviguer dans toutes les phases du cycle de vie d\'un projet avec succès.", "La gestion de projet est une compétence essentielle dans le développement, garantissant que les idées se concrétisent de manière efficace et efficiente. Voici un aperçu détaillé du processus, du début à la fin :\r\n\r\nConception du Projet : Tout commence par une idée. Identifiez clairement les objectifs du projet, définissez les exigences fonctionnelles et techniques, et créez un plan détaillé. La clarté à ce stade est cruciale pour orienter le reste du processus.\r\n\r\nPlanification : Élaborez un calendrier réaliste, définissez les ressources nécessaires, et attribuez des responsabilités. La planification minutieuse garantit une exécution en douceur et permet d\'anticiper les éventuels obstacles.\r\n\r\nDéveloppement : La phase de développement est le cœur du projet. Les développeurs travaillent en étroite collaboration pour créer le produit selon les spécifications. Utilisez des méthodologies agiles comme Scrum pour des itérations rapides et une flexibilité accrue.\r\n\r\nTests et Débogage : Après le développement, placez-vous dans une phase intensive de tests. Identifiez et corrigez les bogues, assurez-vous que le produit répond aux exigences initiales, et effectuez des tests de performance pour garantir une expérience utilisateur optimale.\r\n\r\nDéploiement : Une fois les tests réussis, déployez le produit. Assurez-vous que le processus de déploiement est contrôlé et surveillé pour éviter des erreurs imprévues.\r\n\r\nMaintenance et Évolution : Même après le déploiement, la gestion de projet continue. Assurez-vous de planifier la maintenance régulière du produit, de prendre en compte les retours des utilisateurs et d\'envisager des évolutions futures.\r\n\r\nÉvaluation du Projet : À la fin du projet, évaluez les performances en comparant les résultats aux objectifs initiaux. Identifiez les points forts et les domaines à améliorer pour perfectionner vos processus à l\'avenir.\r\n\r\nLa gestion de projet est une compétence continue, nécessitant flexibilité et adaptabilité tout au long du processus.", 0, '2024-01-26 17:39:44', '2024-01-26 18:13:14', NULL),
(1, "Développeur Full Stack : Un Aperçu Complet", "Explorez le monde dynamique des développeurs full stack, capables de travailler sur toutes les facettes d\'une application web. Découvrez leurs compétences, responsabilités et l\'impact qu\'ils ont sur le développement.", "Le rôle de développeur full stack est de plus en plus prisé dans le monde du développement web, car ces professionnels sont capables de gérer l\'ensemble du processus de création d\'une application. Voici ce que cela implique :\r\n\r\nCompétences Frontend : Les développeurs full stack sont compétents en HTML, CSS et JavaScript, et sont capables de créer des interfaces utilisateur interactives et attrayantes. Ils comprennent les frameworks frontend tels que React, Vue.js et Angular.\r\n\r\nCompétences Backend : Du côté serveur, les développeurs full stack maîtrisent un langage côté serveur comme PHP, Python, Ruby, ou Node.js. Ils sont capables de créer des bases de données, de gérer les requêtes serveur, et de construire la logique métier de l\'application.\r\n\r\nGestion de Base de Données : Les développeurs full stack sont familiarisés avec la gestion des bases de données, du modèle de données à l\'exécution de requêtes complexes. Ils peuvent travailler avec des bases de données SQL comme MySQL ou des bases de données NoSQL comme MongoDB.\r\n\r\nArchitecture et Déploiement : Comprendre l\'architecture d\'une application est crucial. Les développeurs full stack peuvent concevoir une architecture robuste et déployer une application de manière efficace, en utilisant des services cloud tels que AWS, Azure ou Google Cloud.\r\n\r\nGestion de Projet : Ils ont souvent des compétences en gestion de projet, car ils peuvent voir l\'ensemble du processus de développement et coordonner les efforts entre le frontend et le backend.\r\n\r\nLes développeurs full stack sont polyvalents et peuvent être un atout majeur pour les petites équipes de développement ou les projets nécessitant une compréhension globale de l\'application.", 1, '2024-01-26 17:40:14', '2024-01-26 17:40:14', NULL),
(7, "Devenir Développeur Web : Parcours et Conseils", "Plongez dans le monde passionnant du développement web en suivant ces étapes clés. Que vous soyez débutant ou cherchiez à changer de carrière, ce guide vous offre un itinéraire pour devenir un développeur web compétent.", "Le chemin pour devenir développeur web peut sembler intimidant, mais avec une approche structurée, il devient plus accessible. Suivez ces étapes pour vous lancer dans le développement web :\r\n\r\nAcquérir les Fondamentaux : Commencez par apprendre les langages de base tels que HTML, CSS et JavaScript. Utilisez des ressources en ligne gratuites comme MDN Web Docs, W3Schools, ou des plateformes éducatives comme Codecademy.\r\n\r\nExplorer les Technologies : Familiarisez-vous avec les frameworks et les bibliothèques populaires telles que React, Vue.js et Bootstrap. Expérimentez avec différentes technologies pour trouver celles qui correspondent le mieux à vos préférences.\r\n\r\nConstruire des Projets Pratiques : La pratique est la clé. Créez des projets simples pour appliquer vos connaissances. Cela peut être un site web personnel, un portfolio ou des applications web interactives.\r\n\r\nUtiliser des Plates-formes d\'Éducation : Rejoignez des plates-formes comme FreeCodeCamp, Udacity, ou Coursera pour des cours structurés et des projets guidés. Certains offrent même des certifications qui renforcent votre crédibilité en tant que développeur.\r\n\r\nCollaborer et Apprendre en Groupe : Rejoignez des communautés en ligne telles que GitHub, Stack Overflow, ou des forums spécifiques aux langages. Participez à des projets open source et engagez-vous dans des discussions pour élargir vos connaissances.\r\n\r\nCréer un Portfolio : Construisez un portfolio en ligne pour mettre en avant vos projets. Un portfolio solide est un excellent moyen de montrer vos compétences à d\'éventuels employeurs ou clients.\r\n\r\nRestez Curieux et Actualisé : Le développement web est en constante évolution. Restez informé des dernières tendances, technologies et meilleures pratiques. Soyez prêt à apprendre continuellement.\r\n\r\nEn suivant ces étapes, vous poserez des bases solides pour devenir un développeur web compétent et passionné.", 1, '2024-01-26 18:06:42', '2024-01-26 18:13:08', NULL),
(1, "Choisir le Bon PC pour Débuter en Programmation", "Naviguez dans le monde des ordinateurs pour trouver la machine idéale pour vos débuts en programmation. Des spécifications techniques aux considérations budgétaires, ce guide vous aide à prendre une décision éclairée.", "Choisir le bon ordinateur est crucial pour un débutant en programmation. Voici les éléments à prendre en compte pour faire le meilleur choix :\r\n\r\nType d\'Ordinateur : Les deux principales options sont les ordinateurs portables et les ordinateurs de bureau. Les portables offrent la mobilité, tandis que les ordinateurs de bureau peuvent offrir plus de puissance à moindre coût.\r\n\r\nSystème d\'Exploitation : Les systèmes d\'exploitation populaires pour la programmation sont Windows, macOS et Linux. Choisissez celui avec lequel vous êtes le plus à l\'aise. Linux est souvent recommandé pour son utilisation dans le développement web.\r\n\r\nSpécifications Techniques : Pour la plupart des tâches de programmation, un processeur moderne, 8 Go de RAM et un espace de stockage d\'au moins 256 Go sont suffisants. Les cartes graphiques dédiées ne sont généralement pas nécessaires pour la programmation de base.\r\n\r\nÉcran et Résolution : Un écran avec une résolution décente est important, surtout si vous travaillez sur des projets graphiques. Un écran HD (1080p) est un bon point de départ.\r\n\r\nClavier et Trackpad/Souris : Un clavier confortable est essentiel. Certains préfèrent également utiliser une souris externe plutôt que le trackpad intégré pour une meilleure précision.\r\n\r\nConnectivité : Assurez-vous que l\'ordinateur a suffisamment de ports USB et d\'autres ports dont vous pourriez avoir besoin. Une connectivité Wi-Fi fiable est également importante.\r\n\r\nBudget : Définissez un budget réaliste en fonction de vos besoins. Vous n\'avez pas besoin d\'un ordinateur haut de gamme pour commencer, mais assurez-vous d\'investir dans un matériel fiable.\r\n\r\nGardez à l\'esprit que le choix de l\'ordinateur dépend également du type de programmation que vous prévoyez de faire. Pour la plupart des débutants, un ordinateur polyvalent et fiable est un excellent point de départ.", 1, '2024-01-26 18:07:21', '2024-01-26 18:07:21', NULL),
(7, "Démystifier Git : Guide Complet sur son Fonctionnement", "Git, le système de contrôle de version le plus populaire, peut sembler complexe au début. Cet article décompose le fonctionnement de Git en termes simples, vous permettant de comprendre ses principes fondamentaux et de maximiser son utilité dans vos proje", "Git, créé par Linus Torvalds, est un outil essentiel pour tout développeur collaborant sur des projets de code source. Comprendre son fonctionnement est fondamental. Voici une exploration étape par étape de la manière dont Git opère :\r\n\r\nRépertoire Git : Chaque répertoire de travail Git est associé à un répertoire Git local. Lorsque vous initialisez un projet avec git init, Git crée un répertoire caché (.git) qui contient toutes les informations nécessaires au suivi des changements.\r\n\r\nZone de Travail, Index, et Répertoire Git : Git a trois zones principales : la zone de travail (working directory), l\'index (staging area), et le répertoire Git lui-même. La zone de travail est où vous travaillez sur vos fichiers, l\'index est une étape intermédiaire où vous préparez les changements pour la validation, et le répertoire Git stocke l\'historique complet du projet.\r\n\r\nLes Trois États : Git gère les fichiers dans trois états : modifié, indexé, et validé. Un fichier modifié est celui qui a été modifié depuis la dernière validation. Un fichier indexé est un fichier modifié inclus dans la prochaine validation. Un fichier validé est un fichier indexé qui a été sauvegardé dans la base de données Git.\r\n\r\nCommandes de Base : Les commandes fondamentales de Git incluent git add pour ajouter des changements à l\'index, git commit pour sauvegarder les changements dans le répertoire Git, et git push pour partager les modifications avec un dépôt distant.\r\n\r\nBranches : Git permet la création de branches pour travailler sur des fonctionnalités spécifiques sans affecter la branche principale (habituellement appelée main ou master). Utilisez git branch pour créer une nouvelle branche et git merge pour fusionner une branche dans une autre.\r\n\r\nDépôts Distants : Git facilite la collaboration. Vous pouvez cloner des dépôts distants avec git clone, synchroniser avec git fetch et git pull, et partager vos changements avec git push.\r\n\r\nGestion des Conflits : Lorsque des changements conflictuels se produisent, Git utilise des marqueurs de conflit pour indiquer où les modifications entrent en conflit. Vous devez résoudre ces conflits manuellement avant de poursuivre.\r\n\r\nRéférences Utiles : Familiarisez-vous avec des concepts tels que les commits, les branches distantes, les tags, et les fichiers .gitignore pour personnaliser le comportement de Git.\r\n\r\nComprendre le fonctionnement interne de Git peut sembler complexe au début, mais maîtriser ces concepts est essentiel pour une gestion efficace des versions dans le développement logiciel. Avec ces bases, vous serez prêt à collaborer de manière plus efficace et à tirer le meilleur parti de cet outil puissant.", 0, '2024-01-26 18:12:47', '2024-01-26 18:12:54', '2024-01-26 18:12:54');

INSERT INTO comments (user_id, post_id, content, is_enabled, created_at, deleted_at) VALUES
(2, 1, 'Excellent article pour les débutants comme moi ! La clarté dans la distinction entre HTML, CSS et JavaScript m&#039;aide vraiment à comprendre comment ils travaillent ensemble. Merci!', 1, '2024-01-26 17:44:12', NULL),
(2, 3, 'Je suis un fan de React, mais cet article m&#039;a donné une meilleure compréhension de Vue.js et Angular. Une excellente comparaison qui m&#039;aide à choisir le bon framework pour mes projets. Merci!', 1, '2024-01-26 17:44:37', NULL),
(3, 1, 'J&#039;apprécie le fait que vous ayez simplifié les bases du développement web. Cela rend le processus moins intimidant pour quelqu&#039;un qui commence tout juste. Très instructif, merci!', 1, '2024-01-26 17:45:10', NULL),
(3, 2, 'Je n&#039;avais qu&#039;une compréhension superficielle de PHP avant de lire cet article. Maintenant, je comprends mieux comment il fonctionne dans le développement web. Merci pour ces explications détaillées!', 1, '2024-01-26 17:45:38', NULL),
(5, 2, 'J&#039;utilise PHP depuis un moment, mais cet article m&#039;a rappelé l&#039;importance de son rôle dans la création de sites dynamiques. Les informations sur les frameworks PHP sont également très utiles. Bon travail!', 1, '2024-01-26 17:46:14', NULL),
(5, 5, 'Je suis déjà un développeur full stack, mais cet article a résumé parfaitement ce que cela signifie. Les compétences polyvalentes nécessaires sont bien détaillées. Bon rappel de l&#039;importance de la polyvalence dans le développement web.', 1, '2024-01-26 17:46:41', NULL),
(6, 4, 'La gestion de projet a toujours été un défi pour moi, mais cet article m&#039;a donné une structure solide à suivre. Les conseils sur la phase d&#039;évaluation du projet sont particulièrement utiles. Merci!', 1, '2024-01-26 17:47:11', NULL),
(6, 5, 'En tant que développeur débutant, je me demandais ce qu&#039;était un développeur full stack. Cet article m&#039;a offert une excellente introduction. J&#039;aspire à devenir un jour un développeur aussi polyvalent !', 1, '2024-01-26 17:47:26', NULL),
(6, 2, 'La section sur l&#039;intégration de PHP dans le HTML est géniale. Cela clarifie vraiment comment les deux travaillent ensemble. J&#039;attends avec impatience d&#039;en apprendre davantage sur les frameworks PHP. Merci!', 0, '2024-01-26 17:47:47', '2024-01-26 17:59:16'),
(6, 7, 'Ce guide m&#039;a aidé à prendre une décision éclairée lors de l&#039;achat de mon nouvel ordinateur. Les conseils sur les spécifications techniques étaient particulièrement utiles. Merci pour cet article informatif!', 1, '2024-01-26 18:08:37', NULL),
(2, 7, 'En tant que débutant, choisir un PC pour la programmation était un défi, mais cet article a dissipé mes doutes. Les suggestions sur le système d&#039;exploitation étaient particulièrement utiles. J&#039;ai maintenant un ordinateur parfaitement adapté à mes besoins. Merci!', NULL, '2024-01-26 18:09:02', NULL),
(5, 6, 'Ce guide est exactement ce dont j&#039;avais besoin pour commencer ma carrière de développeur web. Les conseils sont clairs, et les étapes sont bien définies. Merci de simplifier un chemin qui semblait complexe !', NULL, '2024-01-26 18:09:26', NULL),
(3, 6, 'Je suis actuellement en train de suivre le parcours décrit dans cet article, et c&#039;est une ressource inestimable. La recommandation de construire un portfolio a vraiment fait la différence dans la façon dont je présente mes compétences. Bravo pour ces conseils pratiques!', NULL, '2024-01-26 18:10:05', NULL);
