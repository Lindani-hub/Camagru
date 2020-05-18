
<?php
	require_once "../database.php";
	if (isset($_POST['reset'])){
		$email = trim($_POST['email']);
		$check = $connection->prepare("SELECT `email` FROM `users` WHERE `email`=?");
		$check->bindValue(1, $email);
		$check->execute();
		if ($check->rowCount() == 0){
			$alert = "<h5>Email does not exist</h5>";
		}else{
			$headers = 'FROM:Camagru';
			$message = " 
			Please click on the link below to reset your password
			
			http://127.0.0.1:8080/Camagru_/registration/forgot.php?email=$email";
			

			mail("$email", "Verify Camagru account", "$message", "$headers");
			$alert = "<h5>Check your email</h5>";
		}
	}
?>
<!doctype html>
<html>
    <head>
        <title>Camagru</title>
        <meta charset="UTF-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">        <link rel="stylesheet" href="../css/log_sign.css">
    </head>
    <body>
        <div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post" action="reset.php">
					<span class="login100-form-title p-b-43">
						Type in your email and we'll send you a reset link.
					</span>
					
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email">
						<span class="focus-input100"></span>
						<span class="label-input100">Email</span>
					</div>
					<span class="login100-form-title p-b-43">
						Go back to <a href="login.php">Login</a>
					</span>
                    <div class="container-login100-form-btn">
						<button style="margin-bottom:40px" class="login100-form-btn" type="submit" name="reset">
							Reset
						</button>
						<?php echo $alert?>
					</div>
					</div>
                </form>
			</div>
		</div>
	    </div>
<?php require '../head_foot/footer.php' ?>
