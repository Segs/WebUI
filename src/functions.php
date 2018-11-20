<?php
/*
 * SEGS - Super Entity Game Server
 * http://www.segs.io/
 * Copyright (c) 2006 - 2018 SEGS Team (see Authors.md)
 * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
 */
 
function generate_salt($length = 16){
    $possible_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz012345678';
    $rand_string = '';
    for($i = 0; $i < $length; ++$i)
    {
        $rand_string .= $possible_chars[random_int(0, strlen($possible_chars) - 1)];
    }
    return utf8_encode($rand_string);
}

function hash_pass($plaintext_pass, $salt){
    $test = hash('sha256', $plaintext_pass . $salt, true);
    return $test;
}

class RETURN_TYPE{
    public $return_message = "";
    public $message = "";
    public $value = "1";
}

function create_user($username, $passwd){
    $username = substr(escapeshellcmd($username), 0, 14);
    $password = substr(escapeshellcmd($passwd), 0, 14);
    $sample_salt = generate_salt();
    $return_value = new RETURN_TYPE();
    $hashed_pass_bytearr = hash_pass($password, $sample_salt);

    include '../config/config.php';
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $accdb);
    if ($mysqli->connect_errno) {
        $return_value->message = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        $return_value->value = 1;
        $mysqli->close();
        return $return_value;
    }
    if($stmt = $mysqli->prepare("INSERT INTO accounts(username, passw, salt) VALUES(?, ?, ?)")){
        $stmt->bind_param('sss', $username, $hashed_pass_bytearr, $sample_salt);
        if(!$stmt->execute()){
            $return_value->message = "User creation failed! " . $mysqli->errno;
            $return_value->value = 1;
        }
        else{
            $return_value->message = "User succesfully created!";
            $return_value->value = 0;
        }
        $mysqli->close();
        return $return_value;
    }
}

function fetchchat(){
    include '../config/config.php';
    echo $dbhost;
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $accdb);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    $mysqli->close();
}

?>
