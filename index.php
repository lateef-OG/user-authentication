<?php
	require('connection.php');
	session_start();
	if(isset($_SESSION['user'])!=""){
		header("Location: profile.php");
	} 
	
	$error = false;
	$unameError = $passError = $errMsg = "";
	
	if(isset($_POST['submit'])){
	
		//to prevent SQL injection
		$uname = trim($_POST['username']);
		$uname = strip_tags($uname);
		$uname = htmlspecialchars($uname);
				
		$pass = trim($_POST['password']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		
		//username validation
		if(empty($uname)){
			$error = true;
			$unameError = "please enter a username.";
		}
		
		//password validation
		if(empty($pass)){
			$error = true;
			$passError = "please enter a password";
		}
		
		//if no error, proceed to login
		if(!$error){
			//$passEncrypt = hash('sha256',$pass);
			
			$result = mysql_query("SELECT id, username, password FROM users WHERE username = '$uname'");
			$row = mysql_fetch_array($result);
			$count = mysql_num_rows($result);
			echo mysql_error();
			
			if($count == 1 && $row['password'] == $pass){
				$_SESSION['user'] = $row['id'];
				header("Location: profile.php");
			}else{
				$errMsg = "incorrect username or password";
			}
		}
	}
?>


<!doctype html>
<html class="no-js" lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User auth | login</title>
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
	<div class="row" id = "container">
      <div class="large-8 medium-centered columns">
	  <h3 class = "text-center"></h3>
	  <div class="large-6 medium-6 columns">
	  <h5 class = "alert"><?php echo $errMsg; ?></h5>
	  <form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<input type = "text" name = "username" placeholder = "username">
		<span class = "errormsg"><?php echo $unameError; ?></span>
		<input type = "password" name = "password" placeholder = "password">
		<span class = "errormsg"><?php echo $passError; ?></span>
		<input type="submit" name = "submit" onclick = "" value="login">
	  </form>	
	  </div>
	  <div class="large-6 medium-6 columns">
		<h3>Don't have an account?</h3>
		<h4>Sign up <a href = "signup.php" class = "link">here</a>.</h4>
	  </div>
	  </div>
    </div>
	  
    	
        
    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>
