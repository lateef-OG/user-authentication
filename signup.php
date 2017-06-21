<?php
	session_start();
	require('connection.php');
	if(isset($_SESSION['user'])!=""){
		header("Location: profile.php");
	}
	
	$error = false;
	$nameError = $unameError = $emailError = $passError = $errMsg = "";
	
	if(isset($_POST['submit'])){
	
		//to prevent SQL injection
		$uname = trim($_POST['username']);
		$uname = strip_tags($uname);
		$uname = htmlspecialchars($uname);
		
		$name = trim($_POST['name']);
		$name = strip_tags($name);
		$name = htmlspecialchars($name);
		
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		
		$pass = trim($_POST['password']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		
		//name validation
		if(empty($name)){
			$error = true;
			$nameError = "please enter your name.";
		}else if(!preg_match("/^[a-zA-Z]+$/", $name)){
			$error = true;
			$nameError = "only letters and spaces";
		}
		
		//username validation
		if(empty($uname)){
			$error = true;
			$unameError = "please enter a username.";
		}else{
		//check if username exist or not
			$query = "SELECT `username` FROM `users` WHERE `username` ='$uname'";
			$result = mysql_query($query);
			$count = mysql_num_rows($result);
			if($count != 0){
				$error = true;
				$unameError = "username already in use";
			}
		} 
		
		//email validation
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$error = true;
			$emailError = "please enter a valid email address.";
		}
		
		if(empty($pass)){
			$error = true;
			$passError = "please enter a password";
		}else if(strlen($pass) < 6){
			$error = true;
			$passError = "password must be atleast 6 characters";
		}
		
		//encrypt password
		//$passEncrypt = hash('sha256',$pass);
		
		//if there's no error, continue with signup
		if(!$error){
			$query = "INSERT INTO users(username, name, email, password) VALUES ('$uname', '$name', '$email', '$pass')";
			$result = mysql_query($query);
			
			if($result){
				$errMsg = "signup successful, you may proceed to login";
				unset($uname);
				unset($name);
				unset($email);
				unset($pass);
			}else{
				$errMsg = "something went wrong, try again later...";
			}
		}
	}
	//$conn->close();
?>


<!doctype html>
<html class="no-js" lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User auth | signup</title>
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
	<div class="row" id = "container">
      <div class="large-8 medium-centered columns">
	  <h3 class = "text-center"></h3>
	  <div class="large-6 medium-6 columns">
		<h2>User authentication system.</h2>
		<h4>Already have an account?</h4>
		<h4>Login <a href = "index.php" class = "link">here</a>.</h4>
	  </div>
	  <div class="large-6 medium-6 columns">
	  <h5 class = "alert"><?php echo $errMsg; ?></h5>
		<form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<input type = "text" name = "name" placeholder = "name">
			<span class = "errormsg"><?php echo $nameError; ?></span>
			<input type = "text" name = "username" placeholder = "username">
			<span class = "errormsg"><?php echo $unameError; ?></span>
			<input type = "text" name = "email" placeholder = "email">
			<span class = "errormsg"><?php echo $emailError; ?></span>
			<input type = "password" name = "password" placeholder = "password">
			<span class = "errormsg"><?php echo $passError; ?></span>
			<!-- <input type = "password" name = "password" placeholder = "confirm password"> -->
			<input type="submit" name = "submit" onclick = "" value="sign up">
		</form>
	  </div>
	  </div>
    </div>
	  
    	
        
    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>