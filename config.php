<?php

//error reporting
$PROJECT_NAME = "CMPS 3420 Project Plant Page";

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

// Establishes a connection to the MariaDB database 
function get_mysqli_connection() {
    static $connection;
    
    if (!isset($connection)) {
        $connection = mysqli_connect(
            'localhost', // the server address (don't change)
            'plantpage', // the MariaDB username
	    'egaptnalp3420S23', // the MariaDB username's password
            'plantpage' // the MariaDB database name
         ) or die(mysqli_connect_error());
    }
    if ($connection === false) {
        echo "Unable to connect to database<br/>";
        echo mysqli_connect_error();
    }
  
    return $connection;
}

// Gets a connection to the database using PHP Data Objects (PDO)
function get_pdo_connection() {
    static $conn;

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


require_once("FormBuilder.php");

// This includes a function called makeTable that accepts a PHP array of 
// objects and returns a string of the array contents as an HTML table
require_once("tablemaker.php");

require_once("functions.php")
?>