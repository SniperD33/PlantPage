<?php
require_once("config.php");
?>

<!DOCTYPE html>
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
		<a href="pplog.php">Personal Plant Log</a>
		<a href="title.php">Brought to You by</a>
		<a href="home.php">Home</a>
	</div>
	<div id="content">

	<?php
	$db = get_mysqli_connection();
	$query = $db->prepare("SELECT * FROM Plant");
	$query->execute();

	$result = $query->get_result();
	$rows = $result->fetch_all(MYSQLI_ASSOC);

	echo buildGrid($rows);
	?>

	</div>




	<footer> <p> Plant Page</p></footer>
</body>
</html>
