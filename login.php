<?php
/*
 * SEGS - Super Entity Game Server
 * http://www.segs.io/
 * Copyright (c) 2006 - 2018 SEGS Team (see Authors.md)
 * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
 */

session_start();
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    throw new Exception('Request method must be POST!');
}

include 'functions.php';

function commit_login($username, $password, &$retval){
    include 'settings.php';
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
        }
        else{
            $stmt->bind_result($passw, $salt);
            $stmt->fetch();
            $saltedpwd = hash_pass($password, $salt);
            if(!strcasecmp($saltedpwd, $passw)){
                $retval->msg = "Signed in successfully!";
                $retval->value = 0;
                $_SESSION['signedin'] = true;
                $_SESSION['user'] = $username;
            }
            else{
                $retval->msg = "Wrong credentials.";
            }
            $stmt->free_result();
        }
    }
    $mysqli->close();
    return $retval;
}

$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);
$result = new RET_TYPE();
commit_login($decoded['user'], $decoded['pass'], $result);

echo json_encode($result);
?>
