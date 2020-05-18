<?php
    
    require_once "../database.php";
    $email = $_GET['email'];
    $sql=$connection->prepare("update `users` set verified=1 where email='$email'");
	$sql->execute();
    header("Location:login.php");
?>