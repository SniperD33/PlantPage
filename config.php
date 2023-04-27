<?php
$servername = 'localhost';
$username = 'plantpage';
$password = 'egaptnalp3420S23';
$dbname = 'plantpage';
?>


<?php

$PROJECT_NAME = "Plant Page";

date_default_timezone_set('America/Los_Angeles');
error_reporting(E_ALL);
ini_set("log_errors", 1);
ini_set("display_errors", 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Establishes a connection to the MariaDB database 
// Gets a connection to the database using PHP Data Objects (PDO)


// This includes a form builder PHP class that lets you generate HTML forms
// from PHP. See the repo here: https://github.com/joshcanhelp/php-form-builder
require_once("FormBuilder.php");

// This includes a function called makeTable that accepts a PHP array of 
// objects and returns a string of the array contents as an HTML table
require_once("tablemaker.php");

require_once("gridbuilder.php")
?>