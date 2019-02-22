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

    require_once '../../../config/config.php';
    require_once '../../../vendor/autoload.php';
	
	use Segs\MiscFunctions;
	use Segs\DatabaseConnection;

    class ReturnData
    {
        function __construct($a, $b)
        {
            $this->name = $a;
            $this->entityData = $b;
        }
        public $name;
        public $entityData;
    }

    function getCharacters()
    {
		global $dbhost, $dbuser, $dbpass, $accdb, $chardb, $dbport;
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $chardb, $dbport);
        $result = array();

        if($mysqli->connect_errno){
            echo "ERROR " . mysqli_connect_error();
            return;
        }
        if($stmt = $mysqli->prepare("SELECT a.char_name,a.entitydata FROM characters as a " .
                                    "INNER JOIN " . $accdb . ".accounts as b ON a.account_id = b.id " .
                                    "WHERE b.username = ?")){
            $stmt->bind_param('s', $_SESSION['username']);
            $stmt->execute();
            $stmt->bind_result($char_name, $entity_data);
            while($stmt->fetch()){
                $result[] = json_encode(new ReturnData($char_name, $entity_data));
            }
        }
        else{
            echo "STMTFAIL ";
        }
        echo json_encode($result);
        $mysqli->close();
    }

    getCharacters();
