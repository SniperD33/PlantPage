<?php
require_once 'config.php';

function getConnection(){
	global $server;
	global $username;
	global $password;
	global $dbname;

	$conn = mysqli_connect($server, $username, $password, $dbname);
	if(!($conn))
		die(mysqli_error($conn));
	else{
		return $conn;
	}
}
function closeConnection($conn){
	mysqli_close($conn);
	if(!(mysqli_close($conn))){
		die(mysqli_error($conn));
	}
}
function addPersonalPlant($pplant){
	$conn = getConnection();
	
	$query = <<<QUERY
	INSERT INTO PersonalPlant
	(Email, PPName, HomeEnv, SciName)
	VALUES(?,?,?,?,?,?);
	QUERY;

	$stmt = mysqli_prepare($conn, $query);
	mysqli_stmt_bind_param(
		$stmt,
		'ssssis',
		$product['id'], $product['name'], $product['vendor'],
		$product['vendorPhone'], $product['quantity'], $product['lastPurchased']
	);

	closeConnection($conn);
}
function removeProduct($id){
	$conn = getConnection();

	$query = "DELETE FROM product WHERE internalId = ?";
	$stmt = mysqli_prepare($conn, $query);
	mysqli_stmt_bind_param($stmt,'s', $id);
	mysqli_execute($stmt);

	closeConnection($conn);
}
function dumpProduct(){
	$conn = getConnection();

	$query = "DELETE FROM product;";
	mysqli_query($conn, $query);

	closeConnection($conn);
}
function getProducts($product){
	$conn = getConnection();

	$query = <<<QUERY
	SELECT internalId, name, vendor, vendorPhone, quantity, lastPurchased
	FROM product;
	QUERY;

	$stmt = mysqli_prepare($conn, $query);
	mysqli_stmt_bind_param($stmt,'s', $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	
	$products = [];
	while($row = mysqli_fetch_assoc($result)){
		array_push($products, $row);
	}

	closeConnection($conn);
	return $products;
}
function uniqueID($id){
	$conn = getConnection();

	$query = "SELECT internalId FROM product WHERE internalId = ?";
	$stmt = mysqli_prepare($conn, $query);
	mysqli_stmt_bind_param($stmt,'s', $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);

	if(mysqli_stmt_num_rows($stmt) > 0){
		return false;
	}else{
		return true;
	}
	
	closeConnection($conn);
}

?>
