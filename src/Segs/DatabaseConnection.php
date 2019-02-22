<?php
namespace Segs;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

class DatabaseConnection
{
    private $conn;
    public function __construct($dbhost, $dbuser, $dbpass, $database, $dbport)
    {
        $this->conn = $this->connectDatabase($dbhost, $dbuser, $dbpass, $database, $dbport);
        if(!empty($this->conn)) {
            try {
				$this->selectDatabase($database);
				return true;
			} catch (Exception $e) {
				return $e;
			}
        }
		return false;
    }
     
    function connectDatabase($dbhost, $dbuser, $dbpass, $database, $dbport)
    {
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $database, $dbport);
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

    public function prepareStatement($statement)
    {
        return $this->conn->prepare($statement);
    }
	
	public function closeConnection() {
		$this->conn->close();
	}
}
