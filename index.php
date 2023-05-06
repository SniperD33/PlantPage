<?php
require_once("config.php"); //requires config
//will make it so anyone who has not logged in can not access this page
//  -will use sessions to control who can get on this page
//lets say its the home page

if (empty($_SESSION["logged_in"])){ //if user is not logged in
    header("Location: login.php");  //send them to log in page
}   //they will only be able to see code if they have logged in
    //server evaluates script before generating html

if ($_SESSION["logged_in"] == false) {
    header("Location: login.php");
}

$msg = "hello";
?>

<html>
<head>  <!-- shows header -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $PROJECT_NAME ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>  <!-- what is shown on the page -->
<h1><?= $PROJECT_NAME?></h1>
<ul>

    <p>xoxoxo</p>
    <p><?= $msg ?></p>   <!-- var from php -->
    <li><a href="index.pdo.php">View Plant Log</a></li>
    <!-- shows link to index which is connected through pdo-->
</ul>


<!-- this page is like a homepage 
first thing that shows when u get on home page
has link to index.pdo.pdh-->