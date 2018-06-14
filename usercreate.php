<?php
  include('settings.php');

  /**************************
  A quick and dirty hack for creating new SEGS accounts.
  Install instructions:
  Put dbtool and settings.cfg in the parent folder of this file.
  Use it.
  ***************************/
  function adduser($loginname, $password){
    include 'functions.php';  
    if($loginname == "" || $password == ""){
      $retvalue->value = 1;
      $retvalue->retmsg = "Wrong parameter format. You should probably not be here.";
      return $retvalue;
    }
    $retvalue = create_user($loginname, $password);
    if(!$retvalue->value){
      $retvalue->retmsg = "Account " . $loginname . " successfully created.<br>\n";
      $retvalue->retmsg .= "Welcome, hero!";
      return $retvalue;
    }
    else{
      $retvalue->retmsg = "Something went wrong. Contact dracc, please.";
      return $retvalue;
    }
  }
  if(isset($_POST['user']) && isset($_POST['pass'])){
    $usermsg = adduser($_POST['user'], $_POST['pass']);
    echo json_encode($usermsg);
  }
  else{
    $usermsg->retmsg = "You did not set everything.";
    echo json_encode($usermsg);
  }
  
?>
