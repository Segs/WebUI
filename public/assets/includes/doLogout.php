<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2019 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
     */

    session_start();

    //if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    //    header("Location: https://" . $_SERVER['HTTP_HOST']);
    //}

    require_once '../../../config/config.php';
    require_once '../../../vendor/autoload.php';
        
    use Segs\ReturnType;

    $result = new ReturnType();
    
    if(isset($_SESSION['isAuthenticated'])) {
        if(isset($_SESSION['username'])) {
            $m_message = ", " . $_SESSION['username'];
        }
        $result->value = 0;
        $result->return_message[] = "<div>Goodbye{$m_message}.</div>";
        $result->return_message[] = "<div>You have been logged out.</div>";
    } else {
        $result->value = 1;
        $result->return_message[] = "<div>You were not logged in.</div>";
    }
    
    unset($_SESSION['isAuthenticated']);
    unset($_SESSION['username']);
    
    echo json_encode($result);
    
   