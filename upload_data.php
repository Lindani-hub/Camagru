
<?php
    require_once "database.php";
    session_start();
    $email = $_SESSION['id'];
    $upload_dir = "uploads/";
    $img = $_POST['hidden_data'];
    $img = str_replace('data:image/png;base64,','', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = $upload_dir . mktime() . ".png";
    $sql = "INSERT INTO image (user,img,article_likes) VALUES ('$email','$file', 0);";
	$connection->exec($sql);
    $success = file_put_contents($file, $data);
    print $success ? $file : 'Unable to save the file';
?>