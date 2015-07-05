<?php

$uuid = $_POST["uuid"];
$name = $_POST["name"];
$data = $_POST["data"];

if(!$uuid||!$name){
	print "error";
	exit;
}

// CREATE DATABASE my_youtube_player DEFAULT CHARACTER SET utf8;
// CREATE TABLE json_storage ( uuid VARCHAR(255), name VARCHAR(255), data TEXT, PRIMARY KEY (uuid,name) ) ENGINE=INNODB ;
$MySQLUser = apache_getenv("MySQLUser");
$MySQLPass = apache_getenv("MySQLPass");
$MySQLServer = apache_getenv("MySQLServer");
$Database = "my_youtube_player";
$dsn = 'mysql:host='.$MySQLServer.';dbname='.$Database;
$options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
); 
$dbh = new PDO($dsn, $MySQLUser, $MySQLPass, $options);

if($data){
	$sql = 'REPLACE json_storage (uuid, name, data) VALUES (?, ?, ?)';
	$stmt = $dbh->prepare($sql);
	$res = $stmt->execute(array($uuid, $name, $data));
	print $res;
}else{
	$sql = 'SELECT data FROM json_storage WHERE uuid = ? AND name = ?';
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(1, $uuid, PDO::PARAM_STR); 
	$stmt->bindParam(2, $name, PDO::PARAM_STR); 
	$stmt->execute();
	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		print $result["data"];
	}
}

