<?php
    include_once('php/variables.php');
    include_once('php/functions.php');

    $email = "";
    $surname = "";
    $loggedIn = false;

    if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
    isset($_POST['password']) && !empty($_POST['password'])) 
    {
        $loggedIn = false;
        foreach ($users as $user) {
            if ($user['email'] === $_POST['email'] && $user['password'] === $_POST['password']) {
                $loggedUser = [
                    'email' => $user['email'],
                    'surname' => $user['surname'],
                ];
                $loggedIn = true; 
                $_SESSION['LOGGED_USER'] = $user['surname'];
                break;
            }
        }

        if ($loggedIn) {
            $email = $loggedUser['email'];
            $surname = $loggedUser['surname'];
        }
    }
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container justify-content-between">
        <a class="navbar-brand" href="index.php">Blog</a>
        <div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="postsList.php">Posts</a>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['LOGGED_USER'])): ?>
                            <p class="nav-link"><?= $_SESSION['LOGGED_USER'] ?> <span> <a id="logout" class="btn btn-dark btn-sm" href="logout.php">Se déconnecter</a></span></p>
                        <?php else: ?>
                            <a class="nav-link" href="login.php">S'inscire / Se connecter</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>