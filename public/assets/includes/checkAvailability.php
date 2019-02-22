<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2019 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
     */

    session_start();
    
    if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
        header("Location: https://" . $_SERVER['HTTP_HOST']);
    }
    
    header('Content-Type: application/json');
    
    require '../../../vendor/autoload.php';
    require '../../../config/config.php';
    
    use Segs\DatabaseConnection;

    $db_conn = new DatabaseConnection($dbhost, $dbuser, $dbpass, $accdb, $dbport);

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
