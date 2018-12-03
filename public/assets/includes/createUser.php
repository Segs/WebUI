<?php
/*
 * SEGS - Super Entity Game Server
 * http://www.segs.io/
 * Copyright (c) 2006 - 2018 SEGS Team (see AUTHORS.md)
 * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    throw new Exception('Request method must be POST!');
}
require_once '../../../config/config.php';
require_once '../../../src/functions.php';


class RETURN_VALUE {
    public $value = 0;
    public $return_message = "";
}

function addUser($loginName, $password, &$return_value)
{
    require_once '../../../src/functions.php';

    if ($loginName == "" || $password == "") {
        $return_value->value = 1;
        $return_value->return_message = "Login name and password cannot be empty.";
    } else {
        $return_value = create_user($loginName, $password);
        if(!$return_value->value){
            $return_value->return_message = "Account for " . $loginName . " successfully created.<br>\n";
            $return_value->return_message .= "Welcome, hero!";
        } else {
            $return_value->return_message = "Something went wrong. Contact {$site_admin}, please.";
        }
    }
}
//Validate variables
//    if(!empty($_POST['modal_create_username'])){
//        $loginName = $_POST['modal_create_username'];
//    } else {
//        $loginName = NULL;
//
//    }

$content = trim(file_get_contents("php://input"));//
//$decoded = json_decode($content, true);
$user_message = new RETURN_VALUE();
//$modal_create_username="demo2";
//$modal_create_password="demo";
//addUser($modal_create_username, $modal_create_password, $user_message);

if(isset($decoded['modal_create_username']) && isset($decoded['modal_create_password']) && isset($decoded['modal_create_verify'])){
    addUser($decoded['modal_create_username'], $decoded['modal_create_password'], $user_message);
} else {
    if (empty($decoded['modal_create_username'])){
        $user_message->return_message = "You did not provide a user name.";
    }

}
echo json_encode($user_message);
