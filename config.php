<?php
   
	$sql = "CREATE DATABASE IF NOT EXISTS Camagru_";
    $connection->exec($sql);
  
    $sql = "USE Camagru_";
    $connection->exec($sql);
    
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        username varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        password varchar(255) NOT NULL,
        verified INT(11)
    )";
    $connection->exec($sql);
    
    $sql = "CREATE TABLE IF NOT EXISTS comment (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user varchar(255) NOT NULL,
        img varchar(255) NOT NULL,
        comment varchar(255) NOT NULL
    )";
    $connection->exec($sql);
    $sql = "CREATE TABLE IF NOT EXISTS likes (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        userid INT(11),
        imgid varchar(255)
    )";
    $connection->exec($sql);
    $sql = "CREATE TABLE IF NOT EXISTS image (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user varchar(255) NOT NULL,
        img varchar(255) NOT NULL,
        article_likes INT(11) NOT NULL
    )";
    $connection->exec($sql);
   
?>