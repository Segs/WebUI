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
    
    use Segs\DatabaseConnection;
    use Segs\MiscFunctions;
    use Segs\ReturnValue;
    
    $username = "";
    $password1 = "";
    $password2 = "";
    $canContinue = true;
   /* Need to validate:
        username
            validate length
            validate availability
        password
            validate length
            validate complexity
            validate password1 and password2 match
    */

    //class RETURN_VALUE {
    //    public $value = 0;
    //    public $return_message = array();
    //}

    $user_message = new ReturnValue();

    //Validate variables
    if(!empty($_POST['username'])) {
        $username = $_POST['username'];
    } else {
        $canContinue = false;
        $user_message->value += 1;
        $user_message->return_message[] = "Username is empty.";
    }

    if(strlen($username) < $min_username_len) {
        // Too short, cannot continue
        $canContinue = false;
        $user_message->value += 2;
        $user_message->return_message[] = "Username is too short.";
    }

    if($canContinue && !empty($_POST['password1'])) {
        $password1 = $_POST['password1'];
    } else {
        $canContinue = false;
        $user_message->value += 4;
        $user_message->return_message[] = "Password1 is empty.";
    }

    if($canContinue && !empty($_POST['password2'])) {
        $password2 = $_POST['password2'];
    } else {
        $canContinue = false;
        $user_message->value += 8;
        $user_message->return_message[] = "Password2 is empty.";
    }

    // validate username availability
    if(!$canContinue || !isset($_SESSION['IsAvailable']) || $_SESSION['IsAvailable'] !== 'true') {
        $canContinue = false;
        $user_message->value += 16;
        $user_message->return_message[] = "Username is not available.";
    }

    // validate passwords match
    if(!$canContinue || $password1 !== $password2) {
        $canContinue = false;
        $user_message->value += 32;
        $user_message->return_message[] = "Passwords do not match.";
    }

    function addUser($m_username, $m_password, &$m_user_message) {    
    //function addUser($m_username, $m_password) {
        //$m_user_message = new RETURN_VALUE;
        $miscFunctions = new MiscFunctions();

        global $site_admin;
        //, $dbhost, $dbuser, $dbpass, $accdb;
        //global $segsFunction;
        //$db_conn = new DatabaseConnection($dbhost, $dbuser, $dbpass, $accdb);
        //
        // if ($m_username == "" || $m_password == "") {
        //     $return_value->value = 1;
        //     $return_value->return_message = "Login name and password cannot be empty.";
        // } else {

        // if(!empty($_POST["username"]))
        //  {
        //     $username = $_POST["username"];
        //     $query = "SELECT * FROM accounts WHERE username='" . $username . "'";
        //     $user_count = $db_conn->getNumRows($query);
        //     if($user_count > 0) {
        //         $_SESSION['IsAvailable'] = 'false';
        //         $response = 'false';
        //     } else {
        //         $_SESSION['IsAvailable'] = 'true';
        //         $response = 'true';
        //     }
        // }
        // else
        // {
        //     $_SESSION['IsAvailable'] = 'false';
        //     $response = 'not_supplied';
        // }
        $m_create_user_message = $miscFunctions->createUser($m_username, $m_password);
        $m_user_message->value += $m_create_user_message->value;
        $m_user_message->return_message[] = $m_create_user_message->return_message;
        
        if(!$m_create_user_message->value) {
            $m_user_message->return_message[] = "Account for " . $m_username . " successfully created.<br>\n";
            $m_user_message->return_message[] = "Welcome, hero!";
        } else {
            $m_user_message->value += 256;
            $m_user_message->return_message[] = "Something went wrong. Please contact {$site_admin}.";
        }
        // }
        return $m_user_message;
    }

    addUser($username, $password1, $user_message);
    
    if($canContinue) {
        //addUser($username, $password1, $user_message);
        // $message = new RETURN_VALUE;
        // $message = addUser($username, $password1);
        // $user_message->value += $message->value;
        // $user_message->return_message[] = $message->return_message;

        
        $user_message->value += 64;
        $user_message->return_message[] = "Would this work?";
        // $user_message->return_message[] = $message.return_message; 
    } else {
        $user_message->value += 128;
        $user_message->return_message[] = "You did not set everything.";
    }

    echo json_encode($user_message);
    //if(isset($_POST['user']) && isset($_POST['pass'])){
    //    addUser($_POST['username'], $_POST['password'], $user_message);
    //}
    //else{
    //    $usermsg->retmsg = "You did not set everything.";
    //    echo json_encode($user_message);
    //}


