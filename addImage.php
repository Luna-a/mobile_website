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

$ID = mysqli_real_escape_string($conn, $_GET['ID']);
?>

<html>
<head>
	<title>Adding Image</title>
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="stylesheet" href = "style.css">	

	<center>
	<div class="top">
		<a href="home.php">All</a> | 
		<a href="inventory.php">Inventory</a> | 
		<a href="sold.php">Sold</a> | 
		<a href="archive.php">Archive</a> |
		<a href="buyers.php">Buyers</a>
	</div>
	</center>	
</head>
<body>
<br><br>
<form method="POST" enctype="multipart/form-data">
	<center>
	<table class="addInfo">
		<thead>
			<tr>
				<th>New Image</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><center><input class="box" type="file" name="image"></center></td>
			</tr>

		</tbody>
		<tfoot>
			<tr>
				<th>
					<center><input type="submit" value="Add Image" name = "submitImage"></center>
				</th>			
			</tr>
		</tfoot>	
	</table>
	</center>
</form>

<p>
	<br><br><br><br>
	<div class="spacer"></div>
	<div class="footer">	
		<a href="account.php" class="popup2">account</a> | 
		<a href="logout.php">log out</a>
	</div>
</body>

<?php
	if(isset($_POST['submitImage'])){
		if(getimagesize($_FILES['image']['tmp_name']) == FALSE){
			echo "Select an image";
		}
		else{
			$image = addslashes($_FILES['image']['tmp_name']);
			$name = addslashes($_FILES['image']['name']);
			$image = file_get_contents($image);
			$image = base64_encode($image);
			
			$query = "INSERT INTO Image (CarID, Name, Image) VALUES ('$ID', '$name', '$image')";			
			if(mysqli_query($conn, $query)){
				
				//javascript to redirect back to details.php
				echo '<script type="text/javascript">';
				echo "window.location = \"details.php?ID=$ID\"";
				echo "</script>";				
			}
			else{
				mysqli_error();
			}
		}
	}
?>

</html>