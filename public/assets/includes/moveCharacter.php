<?php
/*
 * SEGS - Super Entity Game Server
 * http://www.segs.io/
 * Copyright (c) 2006 - 2019 SEGS Team (see AUTHORS.md)
 * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
 */

    session_start();

    if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
        throw new Exception('Request method must be POST!');
    }

    require_once '../../../src/functions.php';

    function move_char($username, $charidx, $mapidx, &$retval){
        require_once '../../../config/config.php';
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $chardb);
        if($mysqli->connect_errno){
            $retval->msg = "Failed to connect to db.";
            $mysqli->close();
            return $retval;
        }
        $decoded;
        $accountid;
        if($stmt = $mysqli->prepare("SELECT entitydata,a.id FROM characters as c INNER JOIN " .
                $accdb . ".accounts as a ON a.id = c.account_id " .
                "WHERE a.username = ? AND c.slot_index = ?")){

            $mapnames = array("City_00_01", "City_01_01", "City_01_02", "City_01_03", "City_02_01", "City_02_02",
            "City_03_01", "City_03_02", "City_04_01", "City_04_02", "City_05_01",
            "Hazard_01_01", "Hazard_02_01", "Hazard_03_01", "Hazard_04_01", "Hazard_04_02", "Hazard_05_01",
            "Trial_01_01", "Trial_01_02", "Trial_02_01", "Trial_03_01", "Trial_04_01", "Trial_04_02", "Trial_05_01");

            $stmt->bind_param('si', $username, $charidx);
            if(!$stmt->execute()){
                $retval->msg = "User lookup failed.";
                $mysqli->close();
                return $retval;
            }
            $stmt->bind_result($entitydata, $accountid);
            $stmt->fetch();
            $decoded = json_decode($entitydata);
            $decoded->value0->Position = array(0,0,0);
            $decoded->value0->MapIdx = $mapidx;
            settype($decoded->value0->MapIdx, "integer");
            $mapPrefix = substr($decoded->value0->CurrentMap,0,strrpos($decoded->value0->CurrentMap,'/')+1);
            $decoded->value0->CurrentMap = $mapPrefix . $mapnames[$mapidx];
            $stmt->free_result();
        }
        else{
            $retval->msg = "Selection preparation failed.";
            $mysqli->close();
            return $retval;
        }
        if($stmnt = $mysqli->prepare("UPDATE characters SET entitydata = ? " .
                    "WHERE account_id = ? AND slot_index = ?")){
            $stmnt->bind_param('sii', json_encode($decoded,JSON_UNESCAPED_SLASHES), $accountid, $charidx);
            if(!$stmnt->execute()){
                $retval->msg = "Entitydata insertion failed.";
            }
            else{
            $retval->msg = "Entitydata inserted successfully!";
                $retval->value = 0;
            }
            $mysqli->close();
            return $retval;
        }
        else{
            $retval->msg = "Statement preparation failed: " . $mysqli->errno . " " . $mysqli->error;
            $mysqli->close();
            return $retval;
        }
        echo json_encode($decoded);
    }

    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);
    $result = new RET_TYPE();
    move_char($_SESSION['user'], $decoded['char'], $decoded['map'], $result);

    echo json_encode($result);


