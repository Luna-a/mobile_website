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
?>

<!DOCTYPE html>
<html>
<head>
	<title>Vehicle Addition</title>
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
<br><br>
<form method="POST">
	<center>
	<table class="addInfo">
		<thead>
			<tr>
				<th>New Vehicle Information</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><center><input class="box" type="text" name="year" placeholder="Year*" size="40"	></center></td>
			</tr>
			<tr>
				<td><center><input class="box" type="text" name="make" placeholder="Make*" size="40"	></center></td>
			</tr>
			<tr>
				<td><center><input class="box" type="text" name="model" placeholder="Model*" size="40" ></center></td>
			</tr>
			<tr>
				<td><center><input class="box" type="text" name="vin" placeholder="Vin*" size="40" ></center></td>
			</tr>
			<tr>
				<td><center><input class="box" type="text" name="miles" placeholder="Miles*" size="40" ></center></td>
			</tr>
			<tr>
				<td><center><input class="box" type="text" name="cost" placeholder="Cost*" size="40"	></center></td>
			</tr>
			<tr>
				<td><center><input class="box" type="text" name="fees" placeholder="Fees" size="40"	></center></td>
			</tr>
			<tr>
				<td><center><input class="box" type="text" name="askingprice" placeholder="Asking Price" size="40"></center></td>
			</tr>
			<tr>
				<td> 
					<div class="tableDateText">
						<center>Date Purchased*</center>
						<center><input class="box" type="date" name="date"></center>
					</div>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th>
					<center><input type="submit" value="Add Vehicle" name="submitVehicle"></center>
				</th>			
			</tr>
		</tfoot>	
	</table>
	</center>
</form>
</body>
</html>

<?php
if(isset($_POST['submitVehicle'])){
	$year  = trim($_POST['year']);
	$make  = trim($_POST['make']);
	$model = trim($_POST['model']);
	$vin   = trim($_POST['vin']);
	$miles = trim($_POST['miles']);
	$cost  = trim($_POST['cost']);
	$fees  = trim($_POST['fees']);
	$askingprice = trim($_POST['askingprice']);
	$date  = trim($_POST['date']);	


	$user = $_SESSION['login_user'];
	$buyerID = 'NULL';
	$status = 'Available';
	$profit = 0.0;
	$sold = 'NULL';
	$carID = 'DEFAULT';
	
	if($fees === '')
		$fees = 'NULL';
	
	$Day = 'NULL';

	$query = "INSERT INTO Car VALUES ('$year','$make','$model','$vin','$date','$profit','$cost','$fees','$user','$buyerID','$miles','$status','$sold','$askingprice','$carID', '$Day')";

	if(mysqli_query($conn, $query)){
		//javascript to redirect back to inventory.php
		echo '<script type="text/javascript">';
		echo 'window.location = "inventory.php"';
		echo "</script>";	
	}
	else{
		echo mysql_error();
	}
}
?>