<?php
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
?>