<?php session_start(); ?>
<?php include_once('parts/header.php'); ?>
<?php include_once('parts/navbar.php'); ?>

<?php 
    include_once('php/functions.php');
    include_once('sql/pdo.php');

if (
    !isset($_POST['surname']) || empty($_POST['surname']) ||
    !isset($_POST['email']) || empty($_POST['email']) ||
    !isset($_POST['password']) || empty($_POST['password']) ||
    !isset($_POST['first_name']) || empty($_POST['first_name']) ||
    !isset($_POST['last_name']) || empty($_POST['last_name'])
) {
    echo "Veuillez remplir tous les champs.";
    return;
} elseif (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $email = $_POST['email'];
    $surname = $_POST['surname'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['password'];
    $role_id = 2;
    $currentTime = date('Y-m-d H:i:s');
    $created_at = $currentTime;

    $insertUser = $db->prepare('INSERT INTO users(role_id, last_name, first_name, surname, email, password, created_at)
    VALUES (:role_id, :last_name, :first_name, :surname, :email, :password, :created_at)');
    $insertUser->execute([
        'role_id' => $role_id,
        'last_name' => $last_name,
        'first_name' => $first_name,
        'surname' => $surname,
        'email' => $email,
        'password' => $password,
        'created_at' =>$created_at
    ]);

    $loggedIn = true;
    $_SESSION['LOGGED_USER'] = $surname;
    $_SESSION['USER_ID'] = $db->lastInsertId();
}
?>
    <div id="content" class="container col-lg-9">
        <h1>Bienvenue, <?= $_SESSION['LOGGED_USER'] ?></h1>
    </div>
