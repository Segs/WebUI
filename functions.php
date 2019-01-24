<?php
/*
 * SEGS - Super Entity Game Server
 * http://www.segs.io/
 * Copyright (c) 2006 - 2018 SEGS Team (see Authors.md)
 * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
 */
 
  function generate_salt($length = 16)
  {
    $possible_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz012345678';
    $rand_string = '';
    for($i = 0; $i < $length; ++$i)
    {
      $rand_string .= $possible_chars[random_int(0, strlen($possible_chars) - 1)];
    }
    return utf8_encode($rand_string);
  }

  function hash_pass($plaintext_pass, $salt)
  {
    $test = hash('sha256', $plaintext_pass . $salt, true);
    return $test;
  }

  class RET_TYPE{
    public $retmsg = "";
    public $msg = "";
    public $value = "1";
  }

  function create_user($username, $pwd){
    $username = substr(escapeshellcmd($username), 0, 14);
    $password = substr(escapeshellcmd($pwd), 0, 14);
    $sample_salt = generate_salt();
    $retval = new RET_TYPE();
    $hashed_pass_bytearr = hash_pass($password, $sample_salt);

    include 'settings.php';
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $accdb);
    if ($mysqli->connect_errno) {
      $retval->msg = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      $retval->value = 1;
      $mysqli->close();
      return $retval;
    }
    if($stmt = $mysqli->prepare("INSERT INTO accounts(username, passw, salt) VALUES(?, ?, ?)")){
      $stmt->bind_param('sss', $username, $hashed_pass_bytearr, $sample_salt);
      if(!$stmt->execute()){
        $retval->msg = "User creation failed! " . $mysqli->errno;
        $retval->value = 1;
      }
      else{
        $retval->msg = "User succesfully created!";
        $retval->value = 0;
      }
      $mysqli->close();
      return $retval;
    }
  }

  function fetchchat(){
    include 'settings.php';
    echo $dbhost;
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $accdb);
    if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    $mysqli->close();
  }

  function onlineStatus(&$retval){
    include 'settings.php';
    // Get IP address of target server
    $address = gethostbyname($serverurl);

    // Create TCP/IP socket
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket === false) {
      $retval->msg = "Socket creation failed!";
      return $retval;
    }

    // Connect socket
    $result = socket_connect($socket, $address, 6001);
    if ($result === false) {
      $retval->msg = "socket_connect() failed.";
      return $retval;
    }

    // $data = "{ \"jsonrpc\":\"2.0\",\r\n\"method": "heyServer",\r\n\"params\": {},\r\n\"id\": 1 }";

    // // Send TCP data
    // socket_write($socket, $data, strlen($data));

    // // Receive TCP reply
    // $jsonData = '';
    // $tmpbuff = '';
    // while ($tmpbuff = socket_read($socket, 2048)) {
    //   $jsonData .= $tmpbuff;
    // }

    // $decJson = json_decode( $jsonData );

    // if(!($result === FALSE)){
      $retval->value = 0;
      $retval->msg = "Server is online!";
    // }
    return $retval;
  }
?>
