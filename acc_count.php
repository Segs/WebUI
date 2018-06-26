<?php
/*
 * SEGS - Super Entity Game Server
 * http://www.segs.io/
 * Copyright (c) 2006 - 2018 SEGS Team (see Authors.md)
 * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
 */

   class retdata{
     public $numaccs = 0;
     public $numchar = 0;
   }
   include 'settings.php';
   $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $accdb);
   $ret = new retdata();
   $ret->numaccs = $mysqli->query("select id from accounts")->num_rows;
   $mysqli->select_db($chardb);
   $ret->numchar = $mysqli->query("select count(*) from characters")->fetch_array()[0];
   echo json_encode($ret);
   $mysqli->close();
?>
