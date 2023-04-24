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
		<a href="plog.html">Plant Dictionary</a>
		<a href="title.html">Brought to You by</a>
		<a href="home.html">Home</a>
	</div>
	<div id="content">
		<div class="personalPlant">
			<?php foreach($plants as $key): ?>
			Name: {$key['']['']}<br>
			Type: {$key['']['']}<br>
			Difficulty Level: {$key['']['']}<br>
			Description: {$key['']['']}<br>
		</div>
	</div>
	<footer> <p> Plant Page</p></footer>
</body>
</html>
