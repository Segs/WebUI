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

    require_once '../../../config/config.php';
    require_once '../../../vendor/autoload.php';
    
    use Segs\DatabaseConnection;
    use Segs\MiscFunctions;
    use Segs\ReturnType;
    
    $post_content = trim(file_get_contents("php://input"));
    $decoded_post_content = json_decode($post_content, true);

    $username = $decoded_post_content['username'];
    $password1 = $decoded_post_content['password1'];
    $password2 = $decoded_post_content['password2'];
    
    $canContinue = true;
    $user_message = new ReturnType();
    
    /* Need to validate:
        username
            validate length
            validate availability
        password
            validate not equal to username
            validate length
            validate password1 and password2 match
            validate complexity
    */

    //Validate variables
    if($username == null || $username == "") {
        $canContinue = false;
        $user_message->value = 1;
        $user_message->return_message[] = "Username is empty.";
    }
    
    if(strlen($username) < $min_username_len) {
        // Too short, cannot continue
        $canContinue = false;
        $user_message->value = 1;
        $user_message->return_message[] = "Username '$username' is too short.";
    }
    
    // validate username availability
    if(!$canContinue || !isset($_SESSION['IsAvailable']) || $_SESSION['IsAvailable'] !== 'true') {
        $canContinue = false;
        $user_message->value = 1;
        $user_message->return_message[] = "The username '$username' is not available.";
    }
    
    if($password1 == null || $password1 == "") {
        $canContinue = false;
        $user_message->value = 1;
        $user_message->return_message[] = "Password1 is empty.";
    }
    
    if($password2 == null || $password2 == "") {
        $canContinue = false;
        $user_message->value = 1;
        $user_message->return_message[] = "Password2 is empty.";
    }
    
    if(strlen($password1) < $min_password_len) {
        $canContinue = false;
        $user_message->value = 1;
        $user_message->return_message[] = "Password is too short.";
    }
    
    // validate passwords match
    if($password1 !== $password2) {
        $canContinue = false;
        $user_message->value = 1;
        $user_message->return_message[] = "Passwords do not match.";
    }
    
    function addUser($m_username, $m_password, &$m_user_message) {    
        $miscFunctions = new MiscFunctions();
        $m_server_message = new ReturnType();
        
        global $site_admin;
        $m_server_message = $miscFunctions->createUser($m_username, $m_password);

        if($m_server_message->value === 0) {
            $m_user_message->value = 0;
            $m_user_message->return_message[] = "<div>Welcome, {$m_username}!</div>";
            $m_user_message->return_message[] = "<div>Your account has been successfully created.</div>";
        } else {
            $m_user_message->value = 1;
            $m_user_message->return_message[] = "<div>Something went wrong. Please contact {$site_admin}.</div>";
        }

        return $m_user_message;
    }
    
    if($canContinue) {
        addUser($username, $password1, $user_message);
        if($login_users_on_create) {
            $_SESSION['isAuthenticated'] = true;
        }
    } else {
        $user_message->return_message[] = "There was a problem creating your account.";
    }

    echo json_encode($user_message);

