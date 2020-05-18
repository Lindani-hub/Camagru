<?php
require_once('config/database.php');

try 
{
	$db = new PDO("mysql:$dsn", $user, $password);

	$db->exec("DROP DATABASE IF EXISTS camagru;");

	$db->exec("CREATE DATABASE IF NOT EXISTS camagru;") or die(print_r($db->errorInfo(), true));

	$sql = "use camagru";
	$db->exec($sql);

	$users = "CREATE TABLE IF NOT EXISTS Users (id INT(6) UNSIGNED AUTO_INCREMENT NOT NULL, 
											firstname VARCHAR(30) NOT NULL, 
											lastname VARCHAR(30) NOT NULL, 
											username VARCHAR(30) NOT NULL UNIQUE, 
											userEmail VARCHAR(30) NOT NULL UNIQUE, 
											password VARCHAR(100) NOT NULL,
											reg_date DATETIME NOT NULL,
											isEmailConfirmed VARCHAR(30) NOT NULL,
											token VARCHAR(30) NOT NULL,
											token_p VARCHAR(30) NOT NULL,
											PRIMARY KEY(id));";

	$db->query($users) or die(print_r($db->errorInfo(), true));

	$images = "CREATE TABLE IF NOT EXISTS Images (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
											user_id INT(6) UNSIGNED NOT NULL,
											images_n VARCHAR(255) NOT NULL, 
											upload_time DATETIME ,
											FOREIGN KEY(user_id) REFERENCES Users(id));";

	$db->query($images) or die(print_r($db->errorInfo(), true));

	$comments = "CREATE TABLE IF NOT EXISTS Comments (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
											comments TEXT NOT NULL, 
											user_id INT(6) UNSIGNED NOT NULL, 
											images_id INT(6) UNSIGNED NOT NULL, 
											comment_time DATETIME,
											FOREIGN KEY(user_id) REFERENCES Users(id), 
											FOREIGN KEY(images_id) REFERENCES Images(id));";

	$db->query($comments) or die(print_r($db->errorInfo(), true));

	$likes = "CREATE TABLE IF NOT EXISTS Likes (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,  
											likes_count INT(6) UNSIGNED,
											user_id INT(6) UNSIGNED NOT NULL, 
											images_id INT(6) UNSIGNED NOT NULL, 
											FOREIGN KEY(user_id) REFERENCES Users(id), 
											FOREIGN KEY(images_id) REFERENCES Images(id));";

	$db->query($likes) or die(print_r($db->errorInfo(), true));
	header('Location: sign_up.php');

}
catch(PDOException $e) 
{
	die("failed to connect: " .$e->getMessage());
}

?>