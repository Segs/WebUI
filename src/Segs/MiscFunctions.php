<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2019 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
     */
    namespace Segs;

    use Segs\DatabaseConnection;
    use Segs\ReturnType;

    class MiscFunctions {

        // // public function __construct()
        // // {
        // //     //die('Functions');
        // // }

        function debugToConsole( $data )
        {
            if(is_array( $data )) {
                $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
            } else {
                $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
            }
            echo $output;
        }

        function generateSalt($length = 16)
        {
            $possible_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz012345678';
            $rand_string = '';
            for($i = 0; $i < $length; ++$i) {
                $rand_string .= $possible_chars[random_int(0, strlen($possible_chars) - 1)];
            }
            return utf8_encode($rand_string);
        }

        function hashPassword($plaintext_pass, $salt)
        {
            try {
                $hashed_password = hash('sha256', $plaintext_pass . $salt, true);
            } catch (Exception $e) {
                $hashed_password = null;
            }
            return $hashed_password;
        }

        public function createUser($m_username, $m_password)
        {   
            include '../../../config/config.php';
            $escapedUsername = escapeshellcmd($m_username);
            $escapedPassword = escapeshellcmd($m_password);
            $m_username = substr($escapedUsername, 0, strlen($escapedUsername));
            $m_password = substr($escapedPassword, 0, strlen($escapedPassword));
            $sample_salt = $this->generateSalt();
            $return_value = new ReturnType();
            $hashed_pass_bytearr = $this->hashPassword($m_password, $sample_salt);
            if($hashed_pass_bytearr !== null) {
                $db_conn = new DatabaseConnection($dbhost, $dbuser, $dbpass, $accdb, $dbport);
                if($stmt = $db_conn->prepareStatement("INSERT INTO accounts(username, passw, salt) VALUES(?, ?, ?)")) {
                    $stmt->bind_param('sss', $m_username, $hashed_pass_bytearr, $sample_salt);
                    if(!$stmt->execute()) {
                        $return_value->return_message[] = "<div>User creation failed.<div>";
                        $return_value->value = 1;
                    } else {
                        $return_value->return_message[] = "<div>The username '$m_username' hs been added to database.</div>";
                        $return_value->value = 0;
                    }
                }
            } else {
                $return_value->message = "<div>Failed to connect to the database.<div>";
                $return_value->value = 1;
            }
            return $return_value;
        }

        public function fetchChat()
        {
            include '../../../config/config.php';
            echo $dbhost;
            $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $accdb, $dbport);
            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }
            $mysqli->close();
        }
    }
?>
