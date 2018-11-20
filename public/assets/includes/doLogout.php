<?php
/**
 * Created by PhpStorm.
 * User: jcicak
 * Date: 11/17/2018
 * Time: 08:41 PM
 */

session_start();
unset($_SESSION['authenticated']);
unset($_SESSION['username']);
//echo "loggingout";
