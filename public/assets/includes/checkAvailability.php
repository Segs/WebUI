<?php
    session_start();
    if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
        header("Location: https://" . $_SERVER['HTTP_HOST']);
    }
    header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    require '../../../vendor/autoload.php';

    require '../../../config/config.php';
    use Segs\DatabaseConnection;

    $db_conn = new DatabaseConnection($dbhost, $dbuser, $dbpass, $accdb);

    if(!empty($_POST["username"]))
    {
        $username = $_POST["username"];
        $query = "SELECT * FROM accounts WHERE username='" . $username . "'";
        $user_count = $db_conn->getNumRows($query);
        if($user_count > 0) {
            $_SESSION['IsAvailable'] = 'false';
            $response = 'false';
        } else {
            $_SESSION['IsAvailable'] = 'true';
            $response = 'true';
        }
    }
    else
    {
        $_SESSION['IsAvailable'] = 'false';
        $response = 'not_supplied';
    }

    echo json_encode($response);
