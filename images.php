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

$user = $_SESSION['login_user'];

//$ID == CarID
$ID = mysqli_real_escape_string($conn, $_GET['ID']);
?>


<!DOCTYPE html>
<html>
<head>
	<title>Images</title>
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="stylesheet" href = "style.css">	
</head>

<body>	
	<center>
	<div class="top">
		<a href="home.php">All</a> | 
		<a href="inventory.php">Inventory</a> | 
		<a href="sold.php">Sold</a> | 
		<a href="archive.php">Archive</a> |
		<a href="buyers.php">Buyers</a>
	</div>
	</center>
	
<?php
	/****************
	images
	*****************/
		
	/* retrieve images from database */
	$query = "SELECT * FROM Image WHERE CarID = '$ID'";
	$result = mysqli_query($conn, $query);

	/* displays all images retrieved from database */
	while ($row = mysqli_fetch_assoc($result)){
		echo '<div class="imgContainer">';
		echo "<a href=\"image.php?ID={$row['ImageID']}\">";
		echo '<img src = "data:image;base64,'.$row["Image"].' " class="p1">';
		echo '</a>';
		echo '</div> ';
	}

?>	
	<br>
	<div class="spacer"></div>
	<div class="footer">	
		<a href="account.php">account</a> | 
		<a href="logout.php">log out</a>
	</div>
</body>
</html>
