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
    use Segs\ReturnType;
	use Segs\DatabaseConnection;

    function moveCharacter($m_username, $m_character_index, $m_map_index, $m_location, $m_orientation, &$m_result)
    {
        global $dbhost, $dbuser, $dbpass, $accdb, $chardb, $dbport;
        $m_canContinue = TRUE;
        $m_databaseConnection = new DatabaseConnection($dbhost, $dbuser, $dbpass, $chardb, $dbport);
        $m_decoded;
        $m_account_id;

        if($m_databaseConnection) {
//            $m_result->return_message[] = "<div>Connection to database successful.</div>";
//            $m_result->value = 0;
            $m_statementUser = $m_databaseConnection->prepareStatement("SELECT entitydata,a.id FROM characters " . 
                        "AS c INNER JOIN " . $accdb . ".accounts as a ON a.id = c.account_id " . 
                        "WHERE a.username = ? AND c.slot_index = ?");
            
            if($m_statementUser) {
//                $m_result->return_message[] = "<div>User '{$m_username}:{$m_character_index}' lookup statement preparation successful.</div>";
//                $m_result->value = 0;
                $m_statementUser->bind_param('si', $m_username, $m_character_index);
                if(!$m_statementUser->execute()) {
                    $m_result->return_message[] = "<div>User lookup failed.</div>";
                    $m_result->value += 1;
                    $m_canContinue = FALSE;
                } else {
//                    $m_result->return_message[] = "<div>User lookup successful.</div>";
//                    $m_result->value = 0;
                    $m_statementUser->bind_result($entitydata, $m_account_id);
                    $m_statementUser->fetch();
                    $m_decoded = json_decode($entitydata);
                    $m_result->return_message[] = json_decode($entitydata);
                    $m_result->value = 0;
                    
                    if(array_key_exists('CurrentMap', $m_decoded->value0)) {
                        $m_map_names = array("City_00_01", "City_01_01", "City_01_02", "City_01_03", "City_02_01", 
                               "City_02_02", "City_03_01", "City_03_02", "City_04_01", "City_04_02", "City_05_01", 
                               "Hazard_01_01", "Hazard_02_01", "Hazard_03_01", "Hazard_04_01", "Hazard_04_02", 
                               "Hazard_05_01", "Trial_01_01", "Trial_01_02", "Trial_02_01", "Trial_03_01", "Trial_04_01", 
                               "Trial_04_02", "Trial_05_01");
                        $m_map_prefix = substr($m_decoded->value0->CurrentMap,0,strrpos($m_decoded->value0->CurrentMap,'/')+1);
                        $m_decoded->value0->CurrentMap = $m_map_prefix . $m_map_names[$m_map_index];
                    }
                    
                    if (array_key_exists('cereal_class_version', $m_decoded->value0)) {
                        $m_decoded->value0->Orientation = $m_orientation;
                    }
                    $m_decoded->value0->Position = $m_location;
                    $m_decoded->value0->MapIdx = $m_map_index;
                    settype($m_decoded->value0->MapIdx, "integer");
//                    $m_result->return_message[] = $m_decoded;
//                    $m_result->value = 0;
                    $m_statementUser->free_result();
                }
            } else {
                $m_result->return_message[] = "<div>User lookup selection preparation failed.</div>";
                $m_result->value += 4;
                $m_canContinue = FALSE;
            }
            
            if($m_canContinue && $m_statementCharacter = $m_databaseConnection->prepareStatement("UPDATE characters " . 
                        "SET entitydata = ? WHERE account_id = ? AND slot_index = ?")){
//                $m_result->return_message[] = "<div>Character update statement preparation successful.</div>";
//                $m_result->value = 0;
                $encoded = json_encode($m_decoded,JSON_UNESCAPED_SLASHES);
                $m_statementCharacter->bind_param('sii', $encoded, $m_account_id, $m_character_index);
                if(!$m_statementCharacter->execute()){
                    $m_result->return_message[] = "<div>Account update failed.</div>";
                    $m_result->value = 5;
                    $m_canContinue = FALSE;
                } else {
//                    $m_result->return_message[] = $encoded;
                    $m_result->return_message[] = "<div>Account updated successfully!</div>";
                    $m_result->value = 0;
                }
            } else {
                $m_result->return_message[] = "<div>Character lookup statement preparation failed.</div>";
                $m_result->value += 8;
                $m_canContinue = FALSE;
            }
        } else {
            $m_canContinue = FALSE;
            $m_result->return_message[] = "<div>Unable to create a database connection.</div>";
            $m_result->value += 16;
        }
        
        $m_databaseConnection->closeConnection();
        //return $m_result;
        
        //echo json_encode($m_decoded);
    }

    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);
    $result = new ReturnType();
    
    $character_index = $decoded['character_id'];
    $map_index = $decoded['map_index'];
    $location = $decoded['location'];
    $orientation = $decoded['orientation'];
    
    $result->return_message[] = "<div>Character Index: {$character_index}</div>";
    $result->return_message[] = "<div>Map Index: {$map_index}</div>";
    $result->return_message[] = "<div>Location: [" . implode(", ", $location) . "]</div>";
    $result->return_message[] = "<div>Orientation: [" . implode(", ", $orientation) . "]</div>";
    // $character_index = 0;
    // $map_index = rand(0,10);
    // $map_index = 0;
    if(isset($_SESSION['username']) && $_SESSION['username'] !== "" ) {
        $user_name = $_SESSION['username'];
    } else {
        $user_name = null;
    }
    
    if($user_name == null || $character_index == null || $map_index == null ){
        $result->return_message[] = "<div>No data returned.</div>";
        $result->value = 1;
    } else {
        moveCharacter($user_name, $character_index, $map_index, $location, $orientation, $result);
        $result->value = 0;
    }

    echo json_encode($result);


