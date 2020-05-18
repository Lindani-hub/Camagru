<?php 
    session_start();
    require_once("database.php");
    //When a user comments on a photo insert the comment into the database and send an email to the user whose photo it is
    if (isset($_POST['comment'])){
        $user = $_SESSION['id'];
        $img = $_POST['imageN'];
        
        //get the email of the user that the image belongs to
        $getEmail = $connection->prepare("SELECT user FROM image WHERE img='$img'");
        $getEmail->execute();
        $emails = $getEmail->fetchAll();
        foreach ($emails as $email){
            $Email = trim($email['user']);
        }
        
        //insert comments into database
      //  $comment = $_POST['content'].PHP_EOL;
     //   $sql=$connection->prepare("INSERT INTO comment (user,img, comment) VALUES ('$user','$img','$comment');");
      //  $sql->execute();
        //send email to user
        $headers = 'FROM:Camagru';
		$message = " 
			
		Someone commented on your photo.";
		
		mail("$Email", "Someone commented on your photo", "$message", "$headers");
    }
    //Delete image if the image belongs to you
    if (isset($_POST['delete'])){
        $img = $_POST['imageN'];
        $getComments = $connection->prepare("SELECT user FROM image WHERE img='$img'");
        $getComments->execute();
        $users = $getComments->fetchAll();
        foreach ($users as $email){
            $Email = trim($email['user']);
        }
        if ($Email == $_SESSION['id']){
            unlink($img);
            $sql = "DELETE FROM `image` WHERE img='$img'";
            $connection->exec($sql);
        }else {
            $alert = "<h4 style='text-align:center;' class='text-danger'>Not yours to delete</h4>";
        }
    }
    if(isset($_POST['liked'])){
        $img = $_POST['imageN'];
        $getEmail = $connection->prepare("SELECT user FROM image WHERE img='$img'");
        $getEmail->execute();
        $emails = $getEmail->fetchAll();
        foreach ($emails as $email){
            $Email = trim($email['user']);
        }
        
        $comment = $_POST['liked'].PHP_EOL;
     
        $headers = 'FROM:Camagru';
		$message = " 
			
		Someone liked your photo";
        

		mail("$Email", "Someone liked your photo", "$message", "$headers");
    }
    if (isset($_POST['unliked'])){
        $img = $_POST['imageN'];
        $sql = "UPDATE `image` SET `article_likes` = `article_likes`-1 WHERE img='$img'";
        $connection->exec($sql);
    }
?>
<!doctype html>
<html>
    <head>
        <title>Camagru</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
        .abs {
            text-align:center;
            font-size:105%;
        }
        .absL {
            text-align:center;
            font-size:105%;
        }
        .absN {
            text-align:center;
            text-decoration:underline;
            font-size:105%;
        }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-light">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Camagru</a>
            </div>
            <div style="position:absolute; right:5%;">
               <a class="navbar-nav" href="capture_upload.php" style="margin:16px 5px;">Capture or Upload </a> 
               <a class="navbar-nav" href="admin.php" style="margin:16px 5px;">Modify your details</a> 
               <a class="navbar-nav" href="registration/logout.php" style="margin:16px 5px;">Logout <?php echo $_SESSION['id']?></a>
            </div>
        </nav>
        <h1 style="text-align:center;">Gallery</h1>
            <div class="rel">
            <?php
                $files = glob("uploads/*.*");
                usort($files,"date_sort");
                for($i = count($files) - 1; $i >= 0;$i--){
                    $image = $files[$i];
                    echo '
                        <img style="inline:block; margin:43px auto 0px auto;" class="img-thumbnail center-block" src="'.$image.'" alt="Image"/>
                        <form method="post" action="Gallery.php">
                        <div class="form-group purple-border">
                            <textarea rows="3" style="width:650px;margin-left:auto;margin-right:auto;" class="form-control" name="content" required></textarea>
                        </div>
                        <input type="hidden" name="imageN" value="'.$image.'">
                        <button class="btn btn-info center-block" type="submit" name="comment">Comment</button>
                        </form>

                        <form method="post" action="Gallery.php">
                        <button id="like" style="margin-top:10px;" class="btn btn-danger center-block" name="delete" type="submit"> DELETE</button>
                        <input type="hidden" name="imageN" value="'.$image.'">
                        <button id="like" style="margin-top:10px;" class="btn btn-primary center-block" name="liked" type="submit"><i class="glyphicon glyphicon-thumbs-up"></i> LIKE</button>
                    
                        </form>

                    ';
                    $getComments = $connection->prepare("SELECT * FROM image");
                    $getComments->execute();
                    $users = $getComments->fetchAll();
                    foreach ($users as $user){
                        if ($user['img'] == $files[$i])
                        {
                         echo '<h6 class="absL">'.$user['article_likes'].' likes</h6>'. '<br/>';
                        }
                    }
                    $getComments = $connection->prepare("SELECT * FROM comment");
                    $getComments->execute();
                    $users = $getComments->fetchAll();
                    foreach ($users as $user){
                        if ($user['img'] == $files[$i])
                        {
                          echo '<h6 class="abs">'.$user['comment'].'</h6>';
                            echo $alert;
                        }
                    }
                }
                echo $alert
            ?>
            </div>
<?php require 'head_foot/footer.php' ?>
