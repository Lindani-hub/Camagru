<?php
    require_once("database.php");
    session_start();
  
    if (!isset($_SESSION['id'])){
        header("location:/registration/login.php");
    }
    if (isset($_POST['upload'])){
        $file = $_FILES['image'];
        $extensions = array('jpg', 'jpeg', 'gif', 'png');
        $file_text = explode('.', $_FILES['image']['name']);
        $file_ext = strtolower(end($file_text));
        if (!in_array($file_ext, $extensions)){
            $alert = "<h5>Format not accepted: Please upload<br>jpg, jpeg, png or gif</h5>";
        }
        elseif($_FILES['image']['error']){
            $alert = "An error occured";
        }
        else {
            $fileNameNew = uniqid('',true).".".$file_ext;
            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$fileNameNew);
            $alert = "<h5>File Uploaded successfully</h5>";
            $sql = "INSERT INTO image (img,article_likes) VALUES ('\"uploads/\".$fileNameNew', 0)";
	        $connection->exec($sql);
        }
    }
?>
<!doctype html>
<html>
    <head>
        <title>Camagru</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-default navbar-expand-lg">
            <div class="navbar-header">
                <a class="navbar-brand" href="Gallery.php" style="margin:16px 5px">Camagru</a>
            </div>
            <div style="position:absolute; right:5%;">
                <a class="navbar-nav" href="Gallery.php" style="margin:23px 5px">Gallery</a>
                <a class="navbar-nav" href="admin.php" style="margin:23px 5px">Change credentials</a>
                <a class="navbar-nav" href="registration/logout.php" style="margin:23px 5px">Logout <?php echo $_SESSION['id']?></a>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <video id="video" autoplay></video>
                    <p>
                        <button id="snap" class="btn btn-default">Take Snapshot</button>
                        <button onclick="uploadEx()" id="new" class="btn btn-default">Save and Upload</button>
                        <form method="post" accept-charset="utf-8" name="form1">
                            <input name="hidden_data" id="hidden_data" type="hidden">
                        </form>
                        <img src="">
                        <canvas id="canvas" style="display:none"></canvas>
                    </p>
                <img id="test" onclick="change()">
                </div>
                <div class="col-md-4">
                    <form class="form-group" method="post" action="capture_upload.php" enctype="multipart/form-data">
                        <input type="hidden" name="size" value="10000000">
                        <div>
                            <input type="file" class="form-control-file" name="image">
                        </div>
                        <div>
                            <input type="submit" name="upload" value="upload image">
                        </div>
                    </form>
                    <?php echo $alert ?>
                   
                    <img class="img1" height="200" width="300" src="resources/handtinywhite.gif">
                    <select id="dropdown" onchange="setPicture(this)">
                        <option value="resources/handtinywhite.gif">Non</option>
                        <option value="resources/brick.jpg">brick</option>
                        <option value="resources/book.png">book</option>
                        <option value="resources/arrow.png">arrow</option>
                        <option value="resources/reload.png">reload</option>
                        <option value="resources/chat-icon.png">chat</option>
                        <option value="resources/towel.png">towel</option>
                        <option value="resources/oeil.png">oeil</option>
                        <option value="resources/loupe.png">loupe</option>
                    </select>
                </div>
            </div>
            <div class="row">
            <?php
                $getComments = $connection->prepare("SELECT * FROM image");
                    $getComments->execute();
                    $users = $getComments->fetchAll();
                    foreach ($users as $user){
                        if ($user['user'] == $_SESSION['id'])
                        {
                            echo '<img style="inline:block; margin:43px auto 0px auto;" class="img-thumbnail center-block col-sm-12 col-md-6 col-lg-3" src="'.$user['img'].'" alt="Image"/>';
                        }
                    }
            ?>
            <div>
        </div>
        <script>
               
                const constraints = {
                    video:true,
                    audio:false
                }
                const video = document.querySelector("#video");
                navigator.mediaDevices.getUserMedia(constraints).then((stream) => {video.srcObject = stream});
                const screenShotButton = document.querySelector('#snap');
                const img = document.querySelector("img");
                const img1 = document.querySelector('.img1');
                
                function setPicture(select){
                    var DD = document.getElementById('dropdown');
                    var value = DD.options[DD.selectedIndex].value;
                    img1.src = value;

                }
                screenShotButton.onclick = video.onclick = function(){
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    var context = canvas.getContext('2d');

                    context.globalAlpha = 1.0;
                    context.drawImage(video, 0, 0);
                    context.globalAlpha = 1.0;
                    context.drawImage(img1, 59, 92);
                    
                    img.src = canvas.toDataURL('image/png');
                };
                function handleSuccess(stream) {
                    screenShotButton.disabled = false;
                    video.srcObject = stream;
                }
                var url = canvas.toDataURL();

                function uploadEx(){
                    var dataURL = canvas.toDataURL("image/png");
                    document.getElementById('hidden_data').value = dataURL;
                    var fd = new FormData(document.forms["form1"]);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'upload_data.php', true);

                    xhr.upload.onprogress = function(e){
                        if (e.lengthComputable) {
                            var percentComplete = (e.loaded /e.total) * 100;
                            console.log(percentComplete + '% uploaded');
                            alert('Succesfully uploaded');
                        }
                    };
                    xhr.send(fd);

                }
        </script>
    </body>
</html>