<?php
require_once 'sqlTools.php';

$conn = getConnection();

$sql = <<<QUERY
CREATE TABLE product (
	id int unsigned NOT NULL auto_increment,
	internalID varchar(20) NOT NULL,
	name varchar(255) NOT NULL,
	vendor varchar(255) NOT NULL,
	vendorPhone varchar(20) NOT NULL,
	quantity mediumint NOT NULL,
	lastPurchased datetime,
	createdAt datetime DEFAULT NOW(),
	updataedAt datetime ON UPDATE NOW(),
	PRIMARY KEY (id)
);
QUERY;

$created = mysqli_query($conn, $sql);

if($created){
	ehco "Table created.";
}else{
	die();
}

closeConnection();

?>
