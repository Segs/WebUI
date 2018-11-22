<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2018 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
     */

    session_start();
    require_once '../../../config/config.php';

    //Validate variables
    var_dump($_POST['desired_username']);
    if(!empty($_POST['desired_username'])){
        $loginName = $_POST['desired_username'];
    } else {
        $loginName = NULL;

    }
    echo "<pre>";
    var_dump($loginName);
    echo "</pre>";

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
    $user_message = new RETURN_VALUE();
    if(isset($_POST['user']) && isset($_POST['pass'])){
        addUser($_POST['username'], $_POST['password'], $user_message);
        echo json_encode($user_message);
    }
    else{
        $usermsg->retmsg = "You did not set everything.";
        echo json_encode($user_message);
    }
