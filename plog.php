<?php
require_once("sqlTools.php");

if(empty($_SESSION["logged_in"])) {
    header("Location: login.php");  
}

if ($_SESSION["logged_in"] == false) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Plants Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="functions.js"></script>
	<style>
		body {
			background-color: #d2fab9;
		}
	</style>
</head>
<body>
	<div id="header">
		<h1>Plant Page</h1>
	</div>
	<div id="navigation">
		<a href="pplog.php">Personal Plant Log</a>
		<a href="title.php">Brought to You by</a>
		<a href="home.php">Home</a>
	</div>
	<div id="plogcontent">

	<?php
	
	$db = getConnection();
	$query = $db->prepare("SELECT * FROM Plant");
	$query->execute();

	$result = $query->get_result();
	$rowsPlant = $result->fetch_all(MYSQLI_ASSOC);

	$query = $db->prepare("SELECT * FROM CareInformation");
	$query->execute();

	$result = $query->get_result();
	$rowsCare = $result->fetch_all(MYSQLI_ASSOC);

	$query = $db->prepare("SELECT * FROM CommonPlantProbs");
	$query->execute();

	$result = $query->get_result();
	$rowsProbs = $result->fetch_all(MYSQLI_ASSOC);

	echo buildGrid($rowsPlant, $rowsCare, $rowsProbs);
	?>

	</div>


	<footer> <p> Plant Page</p></footer>
</body>
</html>
