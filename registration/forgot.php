<?php
	require_once "../database.php";
    if(isset($_POST['reset'])){
		$email = $_GET['email'];
		$pass = sha1(trim($_POST['pass']));
		if ($pass == ""){
			$alert = "<h5 class='text-danger'>Add new password</h5>";
		}
		else {
			$sql=$connection->prepare("update `users` set password='$pass' where email='$email'");
			$sql->execute();
			$alert = "<h5 class='text-danger'>Password reset<br><a href='login.php'>LOGIN</a></h5>";
		}
    }
?>
<!doctype html>
<html>
    <head>
        <title>Camagru</title>
        <meta charset="UTF-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">        
		<link rel="stylesheet" href="../css/log_sign.css">
		<link rel="stylesheet" href="../css/other.css">
    </head>
    <body>
        <div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post" action="forgot.php">
					<span class="login100-form-title p-b-43">
						Reset your password
					</span>
					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" type="password" id="psw" name="pass" required>
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
                    </div>
                    <div class="container-login100-form-btn">
						<button style="margin-bottom:40px" class="login100-form-btn" type="submit" name="reset">
							reset
						</button>
						<?php echo $alert?>
					</div>
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