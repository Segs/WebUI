<?php
    /*
    * SEGS - Super Entity Game Server
    * http://www.segs.io/
    * Copyright (c) 2006 - 2018 SEGS Team (see Authors.md)
    * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
    */
    
    session_start();

    //if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    //    header("Location: https://" . $_SERVER['HTTP_HOST']);
    //}

    require_once '../../../vendor/autoload.php';
    require_once '../../../config/config.php';
    
    use Segs\DatabaseConnection;
    
    class ReturnData
    {
        public $num_accts = 0;
        public $msg_accts = array();
        public $num_chars = 0;
        public $msg_chars = array();
    }

    $returnData = new ReturnData();
    $databaseConnectionAccounts = new DatabaseConnection($dbhost, $dbuser, $dbpass, $accdb, $dbport);
    $databaseConnectionCharacters = new DatabaseConnection($dbhost, $dbuser, $dbpass, $chardb, $dbport);
    
    if($databaseConnectionAccounts) {
        $statementNumberAccounts = $databaseConnectionAccounts->prepareStatement("SELECT id FROM accounts");
        if(!$statementNumberAccounts->execute()) {
            $returnData->num_accts = 0;
            $returnData->msg_accts[] = "NO DATA";
        } else {
            $statementNumberAccounts->store_result();
            $returnData->num_accts = $statementNumberAccounts->num_rows();
            $returnData->msg_accts[] = "OK";
        }
        $databaseConnectionAccounts->closeConnection();
    }
    
    if($databaseConnectionCharacters) {
        $statementNumberCharacters = $databaseConnectionCharacters->prepareStatement("SELECT COUNT(*) FROM characters");
        if(!$statementNumberCharacters->execute()) {
            $returnData->num_chars = 0;
            $returnData->msg_chars[] = "NO DATA";
        } else {
            $statementNumberCharacters->bind_result($chars);
            $statementNumberCharacters->fetch();
            $resultNumberCharacters = $chars;
            $returnData->num_chars = $resultNumberCharacters;
            $returnData->msg_chars[] = "OK";
        }
        $databaseConnectionCharacters->closeConnection();
    }

    echo json_encode($returnData);
