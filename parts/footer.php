<!-- footer.php -->
<?php 
include_once('sql/pdo.php');

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
            if($user['role_id'] === 1) {
                $_SESSION['LOGGED_ADMIN'] = $user['surname'];  
            } else {
                $_SESSION['LOGGED_USER'] = $user['surname'];
            }
        
            break;
        }
    }

    if ($loggedIn) {
        $email = $loggedUser['email'];
        $surname = $loggedUser['surname'];
    }
}
?>

<footer class="bg-light text-center text-lg-start mt-auto">
  <div class="text-center p-3">

  <?php if(isset($_SESSION['LOGGED_ADMIN'])): ?>
    <a href="admin/dashboard.php">Administration</a>
  <?php endif ?>

  <p class="text-dark">©<?= date("Y") ?> Copyright: Méline Pischedda</p>
  </div>
</footer>

</body>
</html>