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
		<a href="title.php">Brought to You by</a>
		<a href="home.php">Home</a>
	</div>
	<div id="content">
		<div class="personalPlant">
<?php
foreach($plants as $key){
	echo<<<PLANT
	<div id='content'>
		<div class='personalPlant'>
		Name: {$key['PersonalPlant']['PPName']}<br>
		Name: {$key['PersonalPlant']['SciName']}<br>
		Home Environment: {$key['PersonalPlant']['HomeEnv']}<br>
		</div>
	</div>
	PLANT;
	}
?>
	<footer> <p> Plant Page</p></footer>
</body>
</html>
/* image would need to be added to each of the plants, 
 * and added to the rosters
 * would be put back in the onStart section
 * <img src='{$key['PersonalPlant']['image']} id= 'allImages'><br>
 *
 * difficulty level and discription would also need to be added to the
 * roster and each of the plants 
 * both would be put back in the whenClicked section
 *
 * Difficulty Level: {$key['PersonalPlant']['']}<br>
 * Description: {$key['PersonalPlant']['']}<br>
*/
