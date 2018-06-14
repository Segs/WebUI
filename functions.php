<?php
  
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
    public $value = "0";
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
      return $retval;
    }
    if($stmt = $mysqli->prepare("INSERT INTO accounts(username, passw, salt) VALUES(?, ?, ?)")){
      $stmt->bind_param('sss', $username, $hashed_pass_bytearr, $sample_salt);
      if(!$stmt->execute()){
        $retval->msg = "User creation failed! " . $mysqli->errno;
	$retval->value = 1;
        return $retval;
      }
      else{
	$retval->msg = "User succesfully created!";
	$retval->value = 0;
        return $retval;
      }
    }
  }

  function fetchchat(){
    include 'settings.php';
    echo $dbhost;
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $accdb);
    if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
  }

?>
