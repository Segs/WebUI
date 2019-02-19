<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2019 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
     */

    session_start();
    include_once '../../../config/config.php';
    require_once '../../../vendor/autoload.php';
    
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

    use Segs\MiscFunctions;
    use Segs\ReturnType;

    if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
        throw new Exception('Request method must be POST!');
    }

    // require_once '../../../src/functions.php';

    function moveCharacter($m_username, $m_character_index, $m_map_index, &$m_result)
    {
        global $dbhost, $dbuser, $dbpass, $accdb, $chardb;
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $chardb);
        if($mysqli->connect_errno){
            $m_result->return_message = "Failed to connect to db.";
            $mysqli->close();
            return $m_result;
        }
        $decoded;
        $m_account_id;
        if($stmt = $mysqli->prepare("SELECT entitydata,a.id FROM characters as c INNER JOIN " .
                                    $accdb . ".accounts as a ON a.id = c.account_id " .
                                    "WHERE a.username = ? AND c.slot_index = ?")){

            $m_map_names = array("City_00_01", "City_01_01", "City_01_02", "City_01_03", "City_02_01", "City_02_02",
            "City_03_01", "City_03_02", "City_04_01", "City_04_02", "City_05_01",
            "Hazard_01_01", "Hazard_02_01", "Hazard_03_01", "Hazard_04_01", "Hazard_04_02", "Hazard_05_01",
            "Trial_01_01", "Trial_01_02", "Trial_02_01", "Trial_03_01", "Trial_04_01", "Trial_04_02", "Trial_05_01");

            $stmt->bind_param('si', $m_username, $m_character_index);
            if(!$stmt->execute()){
                $m_result->return_message = "User lookup failed.";
                $m_result->value = 1;
                $mysqli->close();
                return $m_result;
            }
            $stmt->bind_result($entitydata, $m_account_id);
            $stmt->fetch();
            $decoded = json_decode($entitydata);
            $decoded->value0->Position = array(0,0,0);
            $decoded->value0->MapIdx = $m_map_index;
            settype($decoded->value0->MapIdx, "integer");
            $m_map_prefix = substr($decoded->value0->CurrentMap,0,strrpos($decoded->value0->CurrentMap,'/')+1);
            $decoded->value0->CurrentMap = $m_map_prefix . $m_map_names[$m_map_index];
            $stmt->free_result();
        } else {
            $m_result->return_message = "Selection preparation failed.";
            $mysqli->close();
            return $m_result;
        }
        if($stmnt = $mysqli->prepare("UPDATE characters SET entitydata = ? " .
                                     "WHERE account_id = ? AND slot_index = ?")){
            $encoded = json_encode($decoded,JSON_UNESCAPED_SLASHES);
            $stmnt->bind_param('sii', $encoded, $m_account_id, $m_character_index);
            if(!$stmnt->execute()){
                $m_result->return_message = "Entitydata insertion failed.";
                $m_result->value = 1;
            } else {
                $m_result->return_message = "Entitydata inserted successfully!";
                $m_result->value = 0;
            }
            $mysqli->close();
            return $m_result;
        } else {
            $m_result->return_message = "Statement preparation failed: " . $mysqli->errno . " " . $mysqli->error;
                $m_result->value = 1;
            $mysqli->close();
            return $m_result;
        }
        echo json_encode($decoded);
    }

    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);
    $result = new ReturnType();
    //$_SESSION['user'] = "";
    $character_index = $decoded['char'];
    $map_index = $decoded['map'];
    if(!isset($_SESSION['username']) || $character_index == null || $map_index == null ){
        $result->return_message = "No data";
        $result->value = 1;
    } else {
        moveCharacter($_SESSION['username'], $character_index, $map_index, $result);
    }
    // moveCharacter($_SESSION['username'], 0, 3, $result);

    echo json_encode($result);


