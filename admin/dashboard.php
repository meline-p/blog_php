<?php 
    session_start(); 
    include_once('../parts/header.php'); 
    include_once('../sql/pdo.php');
    include_once('../php/variables.php');
    include_once('../php/functions.php');

    $email = "";
    $surname = "";
    $loggedIn = false;

    if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
    isset($_POST['password']) && !empty($_POST['password'])) 
    {
        $loggedIn = false;
        foreach ($admins as $admin) {
            if ($admin['email'] === $_POST['email'] && $admin['password'] === $_POST['password']) {
                $loggedUser = [
                    'email' => $admin['email'],
                    'surname' => $admin['surname'],
                ];
                $loggedIn = true; 
                $_SESSION['LOGGED_ADMIN'] = $admin['surname'];
                break;
            }
        }

        if ($loggedIn) {
            $email = $loggedUser['email'];
            $surname = $loggedUser['surname'];
        }
    }
?>

<div class="col-lg-12 row">
    <div class="col-lg-3">
        <?php include_once('parts/sidebar.php'); ?>
    </div>

    <div id="content" class="container col-lg-9">
        <h1>Bienvenue, <?php if(isset($_SESSION['LOGGED_ADMIN'])) echo $_SESSION['LOGGED_ADMIN']; ?></h1>

        <div class="col-lg-12 row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Posts</h5>
                        <p class="card-text"><?= count($posts); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Commentaires</h5>
                        <p class="card-text"><?= count($comments); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Utilisateurs</h5>
                        <p class="card-text"><?= count($users); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>


<?php include_once('parts/admin_footer.php'); ?>