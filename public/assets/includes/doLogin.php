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
	

    function loginUser($m_username, $m_password, &$m_result){
		$miscFunctions = new MiscFunctions();
		global $dbhost, $dbuser, $dbpass, $accdb, $dbport;
		$databaseConnection =  new DatabaseConnection($dbhost, $dbuser, $dbpass, $accdb, $dbport);
		if($databaseConnection) {
			if($stmt = $databaseConnection->prepareStatement("SELECT passw, salt FROM accounts WHERE username = ?")){
				$stmt->bind_param('s', $m_username);
				if(!$stmt->execute()){
					$m_result->return_message = "<div>User lookup failed. Please check your username and try again.</div>";
					return $m_result;
				} else{
					$stmt->bind_result($passw, $salt);
					$stmt->fetch();
					$saltedpwd = $miscFunctions->hashPassword($m_password, $salt);
					if(!strcasecmp($saltedpwd, $passw)){
						$m_result->return_message[] = "<div>Welcome, {$m_username}!</div>";
						$m_result->return_message[] = "<div>You have been signed in successfully!</div>";
						$m_result->value = 0;
						$_SESSION['isAuthenticated'] = true;
						$_SESSION['username'] = $m_username;
					} else{
						$m_result->return_message[] = "<div>We are unable to sign you in with the username '{$m_username}'</div>";
						$m_result->return_message[] = "<div>Please check your username and password, and try again.</div>";
					}
					$stmt->free_result();
				}
			}
			$databaseConnection->closeConnection();
		} else {
			$m_result->return_message[] = "<div>Failed to connect to database.</div>";
			return $m_result;
		}
        return $m_result;
    }

    $content = trim(file_get_contents("php://input"));//
    $decoded = json_decode($content, true);
    $result = new ReturnType();
    loginUser($decoded['username'], $decoded['password'], $result);

    echo json_encode($result);
