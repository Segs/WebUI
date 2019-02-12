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

    require_once '../../../src/functions.php';

    function commit_login($username, $password, &$retval){
        require_once '../../../config/config.php';
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $accdb);
        if($mysqli->connect_errno){
            $retval->msg = "Failed to connect to db.";
            $mysqli->close();
            return $retval;
        }
        if($stmt = $mysqli->prepare("SELECT passw, salt FROM accounts WHERE username = ?")){
            $stmt->bind_param('s', $username);
            if(!$stmt->execute()){
                $retval->msg = "User lookup failed.";
                return $retval;
            } else{
                $stmt->bind_result($passw, $salt);
                $stmt->fetch();
                $saltedpwd = hash_pass($password, $salt);
                if(!strcasecmp($saltedpwd, $passw)){
                    $retval->msg = "Signed in successfully!";
                    $retval->value = 0;
                    $_SESSION['authenticated'] = true;
                    $_SESSION['username'] = $username;
                } else{
                    $retval->msg = "Wrong credentials.";
                }
                $stmt->free_result();
            }
        }
        $mysqli->close();
        return $retval;
    }

    $content = trim(file_get_contents("php://input"));//
    $decoded = json_decode($content, true);
    $result = new RETURN_TYPE();
    commit_login($decoded['username'], $decoded['password'], $result);

    echo json_encode($result);
