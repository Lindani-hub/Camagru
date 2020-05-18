<?php
    $servername = 'localhost';
    $username = 'root';
    $password = 'mkhululi2509';
    try
    {
        $connection = new PDO("mysql:host=$servername", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        include_once("config.php");
    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }
?>