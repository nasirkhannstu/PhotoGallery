<?php require_once("database.php"); ?>
<?php
	$addTable = "CREATE TABLE IF NOT EXISTS `users` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`username` varchar(50) NOT NULL,
		`password` varchar(40) NOT NULL,
		`first_name` varchar(30) NOT NULL,
		`last_name` varchar(30) NOT NULL,
		PRIMARY KEY(id),
		UNIQUE KEY `username`(`username`)
		)";
	if(mysql_query($addTable)or die(mysql_error())){
		echo "";}else{die('Sorry');}
?>
<?php
	$addTable = "CREATE TABLE IF NOT EXISTS `photos` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`userid` int(11) NOT NULL,
		`file_name` varchar(255) NOT NULL,
		`type` varchar(100) NOT NULL,
		`size` int(11) NOT NULL,
		`caption` varchar(255) NOT NULL,
		`location` varchar(255) NOT NULL,
		`device` varchar(255) NOT NULL,
		`likes` int(11) NOT NULL,
		`tags` varchar(255) NOT NULL,
		`date` DATETIME NOT NULL,
		PRIMARY KEY(id),
		UNIQUE KEY `file_name`(`file_name`)
		)";
	if(mysql_query($addTable)or die(mysql_error())){
		echo "";}else{die('Sorry');}
?>
<?php
	$addTable = "CREATE TABLE IF NOT EXISTS `comments` (
		`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`photoid` INT(255) NOT NULL,
		`created` DATETIME NOT NULL,
		`author` VARCHAR(255) NOT NULL,
		`body` TEXT NOT NULL
		)";
	if(mysql_query($addTable)or die(mysql_error())){
		echo "";}else{die('Sorry');}
?>