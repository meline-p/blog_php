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
                    'role_id' => $user['role_id'],
                ];
                $loggedIn = true; 
                if(isset($user['role_id']) && $user['role_id'] === 1) {
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

    require('templates/parts/footer_page.php');
?>

