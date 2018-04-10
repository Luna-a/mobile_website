<?php
session_start();

if(isset($_SESSION['login_user'])){
	#echo $_SESSION['login_user'];
	header("location: home.php");
}
else {
	//echo "not logged in";
	//header("location: index.php?noLogin=1");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="stylesheet" href="style.css">
	
</head>
<body>
	<center>
	<div class="error">
	<?php
	if(isset($_GET['error']) === true)
		echo "<center>Error: Wrong Username or Password</center>";	
	
	if(isset($_GET['noLogin']) === true)
		echo "<center>Error: Must be Logged in to Access That Page</center>";		
	?>
	</div>
	<div class="login">
	<form action=loginCheck.php method="POST">
		<p> <input class="login" type="text" name="username" placeholder="Username"/>
		<p> <input class="login" type="password" name="password" placeholder="Password"/>
		<p> <input class="login" type="submit" value="Log In"/>
	</form>
	</div>
	</center>

</body>
</html>