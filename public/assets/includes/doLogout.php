<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2019 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
     */

    session_start();
    require_once '../../../config/config.php';
    require_once '../../../vendor/autoload.php';
    
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
    
    use Segs\ReturnType;

    $result = new ReturnType();
    
    if(isset($_SESSION['isAuthenticated'])){
        $result->value = 0;
        $result->return_message[] = "<div>Goodbye, {$_SESSION['username']}.</div>";
        $result->return_message[] = "<div>You have been logged out.</div>";
    } else {
        $result->value = 1;
        $result->return_message[] = "<div>You were not logged in.</div>";
    }
    
    unset($_SESSION['isAuthenticated']);
    unset($_SESSION['username']);
    
    echo json_encode($result);
    
   