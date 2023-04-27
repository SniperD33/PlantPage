<?php
require_once("config.php");

if(empty($_SESSION["logged_in"])) {
    header("Location: login.php");  
}

if ($_SESSION["logged_in"] == false) {
    header("Location: login.php");
}
?>


<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Plants Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="header">
		<h1>Plant Page</h1>
	</div>
	<div id="navigation">
		<a href="plog.html">Plant Dictionary</a>
		<a href="pplog.html">Personal Plant Log</a>
		<a href="title.html">Brought to You by</a>
	</div>
	<div id="content">

	</div>




	<footer> <p> Plant Page</p></footer>
</body>
</html>
