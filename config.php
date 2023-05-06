<?php

// Change this to your project name
$PROJECT_NAME = "Plant Log";

//error reporting
date_default_timezone_set('America/Los_Angeles');
error_reporting(E_ALL);
ini_set("log_errors", 1);
ini_set("display_errors", 1);
/*
If you want to turn on file error logging, run these commands on Artemis:
     touch ~/php_errors.log
     chmod 646 ~/php_errors.log
and then uncomment line 15 and change the file path. Use an absolute path,
not a relative path. e.g. /home/stu/jcox/php_errors.log
*/

// ini_set("error_log", "/home/stu/jmiranda/php_errors.log");

// Starts a PHP session and gives the client a cookie :3
// Will be useful for other features, like staying logged in.
//start a session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}   

// Gets a connection to the database using PHP Data Objects (PDO)
//connects to database
//pdo driver
function get_pdo_connection() {
    static $conn;   //static variable so we only need to initialize it once

    if (!isset($conn)) {
        try {
            // Make persistent connection
            $options = array(
                PDO::ATTR_PERSISTENT => true
            );

            $conn = new PDO(
                "mysql:host=localhost;dbname=plantpage",  // change dbname
                "plantpage",                          // change username
                "egaptnalp3420S23",                      // change password
                $options);
        }
        catch (PDOException $pe) {
            echo "Error connecting: " . $pe->getMessage() . "<br>";
            die();
        }
        
    }

    if ($conn === false) {
        echo "Unable to connect to database<br/>";
        die();
    }
  
    return $conn;
    

}

// This includes a form builder PHP class that lets you generate HTML forms
// from PHP. See the repo here: https://github.com/joshcanhelp/php-form-builder
require_once("FormBuilder.php");

// This includes a function called makeTable that accepts a PHP array of 
// objects and returns a string of the array contents as an HTML table
require_once("tablemaker.php");
?>