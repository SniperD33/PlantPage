<?php
require_once("config.php");
require_once("sqlTools.php");

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
	
	<div class="wrapper">
		<div class="sidenav" >
				<li><a href="plog.php">Plant Dictionary</a></li>
				<li><a href="pplog.php">Personal Plant Page</a></li>
				<li><a href="logout.php">Log Out</a></li>
		</div> 
	</div>
	
	<div id="content">

	</div>




	<footer> <p> Plant Page </p></footer>
</body>
</html>
