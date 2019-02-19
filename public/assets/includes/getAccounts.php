<?php
    /*
    * SEGS - Super Entity Game Server
    * http://www.segs.io/
    * Copyright (c) 2006 - 2018 SEGS Team (see Authors.md)
    * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
    */
    
    session_start();

    if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
        header("Location: https://" . $_SERVER['HTTP_HOST']);
    }

    require_once '../../../config/config.php';

    class retdata{
        public $num_accts = 0;
        public $num_chars = 0;
    }

    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $accdb);
    $ret = new retdata();
    $ret->num_accts = $mysqli->query("select id from accounts")->num_rows;
    $mysqli->select_db($chardb);
    $ret->num_chars = $mysqli->query("select count(*) from characters")->fetch_array()[0];
    echo json_encode($ret);
    $mysqli->close();

