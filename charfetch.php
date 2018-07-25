<?php
/*
 * SEGS - Super Entity Game Server
 * http://www.segs.io/
 * Copyright (c) 2006 - 2018 SEGS Team (see Authors.md)
 * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
 */
session_start();

class retdata{
    function __construct($a, $b){
        $this->name = $a;
        $this->entitydata = $b;
    }
    public $name;
    public $entitydata;
}

function fetch_chars(){
    include 'settings.php';
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $chardb);
    $retval;

    if($mysqli->connect_errno){
        echo "ERROR " . mysqli_connect_error();
        return;
    }
    if($stmt = $mysqli->prepare("SELECT a.char_name,a.entitydata FROM characters as a " .
                                "INNER JOIN " . $accdb . ".accounts as b ON a.account_id = b.id " .
                                "WHERE b.username = ?")){
        $stmt->bind_param('s', $_SESSION['user']);
	$stmt->execute();
	$stmt->bind_result($char_name, $entitydata);
        while($stmt->fetch()){
            $retval[] = json_encode(new retdata($char_name, $entitydata));
        }
    }
    else{
        echo "STMTFAIL ";
    }
    echo json_encode($retval);
    $mysqli->close();
}

fetch_chars();
?>
