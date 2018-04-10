<?php
include('Connection.php');
include('Constants.php');

$conn = GetConnection($DBUser, $DBpass, $DBHost, $DBname);
session_start();

if(isset($_SESSION['login_user'])){
	#echo $_SESSION['login_user'];
}
else {
	//echo "not logged in";
	header("location: index.php?noLogin=1");
}

$imageID = mysqli_real_escape_string($conn, $_GET['ID']);

$query = "SELECT CarID FROM Image WHERE ImageID = '$imageID'"; 
$result = mysqli_query($conn, $query);	
$carID = mysqli_fetch_assoc($result);
$carID = $carID['CarID'];

$query2 = "DELETE FROM Image WHERE ImageID = '$imageID'";

if(mysqli_query($conn, $query2)){
	header("location: details.php?ID={$carID}");
}
else{
	echo mysql_error();
}	

?>
