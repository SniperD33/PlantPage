<?php 
require_once ("config.php");
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
        <a href="plog.php">Plant Dictionary</a>
        <a href="pplog.php">Personal Plant Log</a>
        <a href="title.php">Brought to You by</a>
    </div>
    <div id="content">
    <div id = "PoD">
    <h2>Plant of the Day</h2>
<?php

$db = get_mysqli_connection();
$query = $db->prepare("SELECT * FROM POD");
$query->execute();

$result = $query->get_result();
$rows = $result->fetch_all(MYSQLI_ASSOC);

echo makeTable($rows);
?>
    </div>
<div id= "MVP">
<h2> Most Viewed Plant</h2>
<?php 

$db = get_mysqli_connection();
$query = $db->prepare("SELECT * FROM TopViewPlants");
$query->execute();

$result = $query->get_result();
$rows = $result->fetch_all(MYSQLI_ASSOC);

echo makeTable($rows);

?>
        </div>
    </div>
    <footer> <p> Plant Page</p></footer>
</body>
</html>
