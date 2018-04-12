<?php
include('Connection.php');
include('Constants.php');


$conn = GetConnection($DBUser, $DBpass, $DBHost, $DBname);
session_start();


if($_SERVER['REQUEST_METHOD'] === 'POST'){
	$name = trim($_POST['username']);
	$password = trim($_POST['password']);
} 
else {
	echo "Something went wrong!!";
}

//escapes special characters
$name = mysqli_real_escape_string($conn, $name);

$query = "SELECT Password FROM User WHERE Username = '$name'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
		
$hash = $row["Password"];
if(password_verify($password, $hash)){
	//echo "yes";		
	$_SESSION['login_user'] = $name;
	header("location: home.php");
	}
else{
	//echo "no";
	//header("location: loginError.php");
	header("location: index.php?error=1");
}
?>
