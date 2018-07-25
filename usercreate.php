<?php
/*
 * SEGS - Super Entity Game Server
 * http://www.segs.io/
 * Copyright (c) 2006 - 2018 SEGS Team (see Authors.md)
 * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
 */
  session_start();
  include('settings.php');

  class RETURN_VALUE{
    public $value = 0;
    public $retmsg = "";
  }

  function adduser($loginname, $password, &$retvalue){
    include 'functions.php';

    if($loginname == "" || $password == ""){
      $retvalue->value = 1;
      $retvalue->retmsg = "Wrong parameter format. You should probably not be here.";
    }
    else{
      $retvalue = create_user($loginname, $password);
      if(!$retvalue->value){
        $retvalue->retmsg = "Account " . $loginname . " successfully created.<br>\n";
        $retvalue->retmsg .= "Welcome, hero!";
      }
      else{
        $retvalue->retmsg = "Something went wrong. Contact dracc, please.";
      }
    }
  }

  $usermsg = new RETURN_VALUE();
  if(isset($_POST['user']) && isset($_POST['pass'])){
    adduser($_POST['user'], $_POST['pass'], $usermsg);
    echo json_encode($usermsg);
  }
  else{
    $usermsg->retmsg = "You did not set everything.";
    echo json_encode($usermsg);
  }

?>
