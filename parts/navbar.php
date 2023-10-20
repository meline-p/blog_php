
<?php

$email = "";
$password = "";

if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
   isset($_POST['password']) && !empty($_POST['password'])) 
{
    $email = $_POST['email'];
    $password = $_POST['password'];
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
                        <?php if($email != ""): ?>
                            <p class="nav-link"><?php echo $email ?> <span> / <a id="logout" href="#">Se déconnecter</a></span></p>
                        <?php else: ?>
                            <a class="nav-link" href="login.php">S'inscire / Se connecter</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>