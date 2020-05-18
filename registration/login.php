<?php
	require_once "../database.php";
		if (isset($_POST['login'])){
		$user = $_POST['email'];
		$pass = sha1($_POST['password']);
		if (empty($user) || empty($pass)){
			$alert = "<h5 class='text-danger'>All fields are required</h5>";
		}
		else {
			$query = $connection->prepare("SELECT email, password FROM users WHERE email=? AND password=? AND verified=?;");
			$query->execute(array($user, $pass, 1));
			$row = $query->fetch(PDO::FETCH_ASSOC);
			if ($query->rowCount() > 0){
				session_start();
				$_SESSION['id'] = $_POST['email'];
				$email = $_SESSION['id'];
				$getComments = $connection->prepare("SELECT username FROM users WHERE email='$email'");
    			$getComments->execute();
				$users = $getComments->fetchAll();
				$_SESSION['user'] = implode($users);
				header("location:../Gallery.php");
			}
			elseif($row['verified'] == 0){
				$alert = "<h5>Please verify your email</h5>";
			}
			else {
				$alert = "<h5 class='text-danger'>Username/Password is wrong</h5>";
			}
		}
	}
?>
<!doctype html>
<html>
    <head>
        <title>Camagru</title>
        <meta charset="UTF-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">        
		<!-- <link rel="stylesheet" href="../css/log_sign.css"> -->
		<link rel="stylesheet" href="../css/log_sign.css">
		<link rel="stylesheet" href="../css/other.css">
	</head>
    <body>
        <div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post" action="login.php">
					<span class="login100-form-title p-b-43">
						Login to continue
					</span>
					
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email">
						<span class="focus-input100"></span>
						<span class="label-input100">Email</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password">
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
                    </div>
			
                    <div class="text-center p-t-46 p-b-20">
						<span class="txt2">
							or sign up <a href="sign_up.php">here</a>
						</span>
                    </div>
					<div class="text-center p-t-46 p-b-20" style="margin-top:20px">
						<span class="txt2">
							<a href="reset.php">Forgot Password?</a>
						</span>
                    </div>
                    <div class="container-login100-form-btn">
						<button style="margin-bottom:40px" class="login100-form-btn" type="submit" name="login">
							Login
						</button>
					
					</div>
					</div>
                </form>
			</div>
		</div>
	    </div>
<?php require '../head_foot/footer.php' ?>
