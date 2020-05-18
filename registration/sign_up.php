<?php
	require_once "../database.php";
	if (isset($_POST["submit"])){
		$email = trim($_POST['email']);
		$username = trim($_POST['username']);
		$password = sha1(trim($_POST['pass']));
		$check = $connection->prepare("SELECT `email` FROM `users` WHERE `email`=?");
		$check->bindValue(1, $email);
		$check->execute();
		if($_POST['email'] == "" || $_POST['username'] == "" || $_POST['pass'] == ""){
			$alert = "<h5 class='text-danger'>Please complete form<h5>";
		}
		elseif($check->rowCount() > 0){
			$alert = "<h5 class='text-danger'>Email provided is already in use<h5>";
		}
		else {
			try{
			$connection->beginTransaction();
			$sql = "INSERT INTO users (username, email, password, verified) VALUES ('$username','$email','$password', 0);";
			$connection->exec($sql);

			$headers = 'FROM:Camagru';
			$message = " Congratulations $username, you are now registered!! 
			
			Please click on the link below to login
			
			http://127.0.0.1:8080/Camagru_/registration/verify.php?email=$email";

			mail("$email", "Verify Camagru account", "$message", "$headers");
			
			$alert = "You have been registered! Please verify your email!";

			$connection->commit();
			}catch(PDOException $e){
				echo $sql . "\n" . $e->getMessage();
			}
		}
	}


?>
	<?php
			require_once "../database.php";
			$files = glob("uploads/*.*");
			// usort($files,"date_sort");
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
				
			}
			// echo $alert
		?>
<!doctype html>
<html>
    <head>
        <title>Camagru</title>
        <meta charset="UTF-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">        <link rel="stylesheet" href="../css/log_sign.css">
		<link rel="stylesheet" href="../css/other.css">
	</head>




    <body>



        <div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="sign_up.php" method="post">
					<span class="login100-form-title p-b-43">
                        Sign up
					</span>
					
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" required>
						<span class="focus-input100"></span>
						<span class="label-input100">Email</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Username is required">
						<input class="input100" type="text" name="username" required>
						<span class="focus-input100"></span>
						<span class="label-input100">Username</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" type="password" id="psw" name="pass" required>
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
                    </div>
                    
                    <div class="text-center p-t-46 p-b-20">
						<span class="txt2">
							or sign in <a href="login.php">here</a>
						</span>
                    </div>
                    <div class="container-login100-form-btn">
						<button style="margin:20px 0px 40px 0px" class="login100-form-btn" type="submit" name="submit">
							SIGN UP
						</button>
						
					<div id="message">
						<h3>Password must contain the following</h3>
						<p id="letter" class="invalid">A <b>lowercase</b> letter</p>
						<p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
						<p id="number" class="invalid">A <b>number</b></p>
						<p id="length" class="invalid">Mininum <b>8 characters</b></p>
					</div>
					</div>

					
                </form>

				



			</div>
		</div>
	    </div>
		<script>
			
			var myInput = document.getElementById("psw");
			var letter = document.getElementById("letter");
			var capital = document.getElementById("capital");
			var number = document.getElementById("number");
			var length = document.getElementById("length");

			myInput.onfocus = function() {
				document.getElementById("message").style.display = "block";
			}

			myInput.onblur = function(){
				document.getElementById("message").style.display = "none";
			}

		
			myInput.onkeyup = function() {
				var lowerCaseLetters = /[a-z]/g;
				if (myInput.value.match(lowerCaseLetters)){
					letter.classList.remove("invalid");
					letter.classList.add("valid");
				}else {
					letter.classList.remove("valid");
					letter.classList.add("invalid");
				}
				var upperCaseLetters = /[A-Z]/g;
				if(myInput.value.match(upperCaseLetters)) {  
    				capital.classList.remove("invalid");
    				capital.classList.add("valid");
  				} else {
    				capital.classList.remove("valid");
    				capital.classList.add("invalid");
  				}
				var numbers = /[0-9]/g;
				if(myInput.value.match(numbers)){
					number.classList.remove("invalid");
					number.classList.add("valid");
				}else {
					number.classList.remove("valid");
					number.classList.add("invalid");
				}
				if (myInput.value.length >= 8){
					length.classList.remove("invalid");
					length.classList.add("valid");
				}else{
					length.classList.remove("valid");
					length.classList.add("invalid");
				}
			}
		</script>
<?php require '../head_foot/footer.php' ?>
