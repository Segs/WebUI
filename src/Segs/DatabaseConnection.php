<?php
namespace Segs;
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

class DatabaseConnection
{
    private $conn;
    public function __construct($dbhost, $dbuser, $dbpass, $database)
    {
        $this->conn = $this->connectDatabase($dbhost, $dbuser, $dbpass, $database);
        if(!empty($this->conn))
        {
            $this->selectDatabase($database);
        }
    }
     
    function connectDatabase($dbhost, $dbuser, $dbpass, $database)
    {
        #global $dbhost;     //database hostname
        #global $dbuser;     //database username
        #global $dbpass;     //database password
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $database);
        return $conn;
    }
    
    public function selectDatabase($database)
    {
        mysqli_select_db($this->conn, $database);
    }
    
    function getNumRows($query)
    {
        $result  = mysqli_query($this->conn, $query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;
    }

    public function PrepareStatement($statement)
    {
        global $conn;
        $conn->prepare($statement);
        return $conn;
    }
}
