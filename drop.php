<?php 
require_once 'sqlTools.php';

$conn = getConnection();

$drop = mysqli_query($conn, 'DROP TABLE product;');

if(!($drop)){
	die();
}else{
	echo "Table dropped successful";
}

closeConnection($conn);

?>
