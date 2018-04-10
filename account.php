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
	//header("location: noLogin.php");
	header("location: index.php?noLogin=1");
}
$user = $_SESSION['login_user'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Account</title>
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="stylesheet" href="style.css">
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
<br><br>
<form method="POST">
	<center>
	<table class="addInfo">
		<thead>
			<tr>
				<th>New Password</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><center><input class="box" type="password" name="pass1" placeholder="New Password" size="40" ></center></td>
			</tr>
			<tr>
				<td>
					<center><input class="box" type="password" name="pass2" placeholder="Re-type New Password" size="40" ></center>
					<?php
						if(isset($_GET['error']) == true){
							echo "<br>";
							echo "<center>Error: Passwords Do Not Match</center>";	
						}
						else if(isset($_GET['qError']) == true){
							echo "<br>";
							echo "<center>Error: Could Not Update Password</center>";								
						}
					?>
				</td>
				
			</tr>
			<input type="hidden" name="username" <?php echo " value=$user" ?>>			
		</tbody>
		<tfoot>
			<tr>
				<th>
					<center><input type="submit" value="Update Password" name="submitPassword"></center>
				</th>			
			</tr>
		</tfoot>	
	</table>
	</center>
</form>
<p>
		<div class="spacer">
		</div>
		<div class="footer">	
		<a href="account.php">account</a> | 
		<a href="logout.php">log out</a>
		</div>
</body>
<?php
if(isset($_POST['submitPassword'])){
	$pass1 = trim($_POST['pass1']);
	$pass2 = trim($_POST['pass2']);
	$user = trim($_POST['username']);

	if($pass1 === $pass2){
		//echo "same";
		$newPass = password_hash($pass1, PASSWORD_DEFAULT);
		$query = "UPDATE User SET Password = '$newPass' WHERE Username = '$user'";
	
		//echo $query;
		if(mysqli_query($conn, $query)){
			//javascript to redirect back to home.php
			echo '<script type="text/javascript">';
			echo "window.location = \"home.php\"";
			echo "</script>";	
		}
		else{
			//javascript to redirect back to home.php
			echo '<script type="text/javascript">';
			echo "window.location = \"account.php?qError=1\"";
			echo "</script>";	
		}
	}
	else{
		echo '<script type="text/javascript">';
		echo "window.location = \"account.php?error=1\"";
		echo "</script>";	
	}
}
?>

</html>