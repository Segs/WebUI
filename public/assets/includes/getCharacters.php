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
        $result = array();
		global $dbhost, $dbuser, $dbpass, $accdb, $chardb, $dbport;
        $databaseConnection = new DatabaseConnection($dbhost, $dbuser, $dbpass, $chardb, $dbport);

        if($databaseConnection) {
            $statementCharacters = $databaseConnection->prepareStatement("SELECT a.char_name,a.entitydata FROM " .
                                    "characters AS a INNER JOIN " . $accdb . ".accounts AS b ON a.account_id = b.id " .
                                    "WHERE b.username = ?");
            $statementCharacters->bind_param('s', $_SESSION['username']);

            if(!$statementCharacters->execute()) {
                $result[] = json_encode(new ReturnData("NO DATA", "NO DATA"));
            } else {
                $statementCharacters->bind_result($character_name, $entity_data);
                while($statementCharacters->fetch()){
                    $result[] = json_encode(new ReturnData($character_name, $entity_data));
                }
            }
            $databaseConnection->closeConnection();
        }

        echo json_encode($result);
    }

    getCharacters();
