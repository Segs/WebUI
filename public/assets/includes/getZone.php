<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2019 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
     */

    session_start();
    
//    if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
//       header("Location: https://" . $_SERVER['HTTP_HOST']);
//    }
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    require_once '../../../config/config.php';
    require_once '../../../vendor/autoload.php';
    
    use Segs\MiscFunctions;
    use Segs\ReturnType;
    use Segs\DatabaseConnection;

    // class ReturnData
    // {
    //     function __construct($a, $b)
    //     {
    //         $this->name = $a;
    //         $this->entityData = $b;
    //     }
    //     public $name;
    //     public $entityData;
    // }

    function getZones($m_username, $m_character_name, &$m_result)
    {
        global $dbhost, $dbuser, $dbpass, $accdb, $chardb, $dbport;
        $databaseConnection = new DatabaseConnection($dbhost, $dbuser, $dbpass, $chardb, $dbport);
     
         if($databaseConnection) {
            $statementEntityData = $databaseConnection->prepareStatement("SELECT a.entitydata FROM " .
                            "characters AS a INNER JOIN " . $accdb . ".accounts AS b ON a.account_id = b.id " .
                            "WHERE b.username = ? AND a.char_name = ?");
            if($statementEntityData){
                $statementEntityData->bind_param('ss', $m_username, $m_character_name);
                if(!$statementEntityData->execute()) {
                    $m_result->return_message = "NO DATA";
                } else {
                    $statementEntityData->bind_result($entity_data);
                    $statementEntityData->fetch();
                    $m_result->return_message = $entity_data;
                }
            } else {
                $m_result->value = 1;
                $m_result->return_message[] = "NOT OK";
            }
            $databaseConnection->closeConnection();
        }
    }


    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);
    $result = new ReturnType();
    
    $character_name = $decoded['character_name'];
    if(isset($_SESSION['username']) && ($_SESSION['username'] !== "" && $_SESSION['username'] != null)){
        $username = $_SESSION['username'];
    } else {
        $username = null;
    }
    
    if($username == null || ($character_name == null || $character_name == "")){
        $result->return_message[] = "<div>No data returned.</div>";
        $result->value = 1;
    } else {
        $result->value = 0;
        getZones($username, $character_name, $result);
    }


    echo json_encode($result);
