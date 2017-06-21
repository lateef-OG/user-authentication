<?php 
	session_start();
	require('connection.php');
	if(!isset($_SESSION['user'])){
		header("Location: login.php");
		exit;
	} 
	
	$res = mysql_query("SELECT * FROM users WHERE id =".$_SESSION['user']);
	$userRow = mysql_fetch_array($res);
	
	$result = mysql_query("SELECT * FROM users");
	$count = mysql_num_rows($result);
?>


<!doctype html>
<html class="no-js" lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User auth | <?php echo $userRow['username'];?></title>
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
	<div class="top-bar">
	  <div class="top-bar-left">
		<ul class="dropdown menu" data-dropdown-menu>
		  <li class="menu-text">User Auth</li>
		  <li><a href="users.php">users</a></li>
		</ul>
	  </div>
	  <div class="top-bar-right">
		<ul class="dropdown menu" data-dropdown-menu>
		  <li>
			<a href="profile.php">hi <?php echo $userRow['username'];?></a>
		  </li>
		  <li><a href="logout.php?logout">sign out</a></li>
		</ul>
	  </div>
	</div>
  
	<div class="row" id = "container">
      <div class="large-8 medium-centered columns">
	  <h3 class = "text-center"></h3>
	  <div class = "callout primary">
	  <h4>users</h4>
		<?php
			if ($count > 0){
				while($row = mysql_fetch_assoc($result)){
					echo $row["username"]. " - " .$row["name"]. "<br>";
				}
			}
		?>
	  </div>
	  </div>
    </div>
	  
    	
        
    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>