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
$Sold = mysqli_real_escape_string($conn, $_GET['Sold']);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Repair Addition</title>
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
<form method="POST">
	<center>
	<table class="addInfo">
		<thead>
			<tr>
				<th>New Repair Information</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><center><input class="box" type="text" name="partName" placeholder="Part Name*" size="40" ></center></td>
			</tr>
			<tr>
				<td><center><input class="box" type="text" name="partCost" placeholder="Part Cost*" size="40" ></center></td>
			</tr>
			<tr>
				<td><center><input class="box" type="text" name="laborCost" placeholder="Labor Cost" size="40" ></center></td>
			</tr>
			<!--<tr>
				<td><center><input type="hidden" name="id" <?php echo " value=$ID" ?> size="40"></center></td>
			</tr>-->
			<tr>				
				<td><center>
					<textarea class="addComments" name="comments" cols="45" rows="4" placeholder="Additional Comments..."></textarea>
				<!--<input type="textarea" name="comments" placeholder="Additional Comments" size="40"	>-->
				
				</center>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th>
					<center><input type="submit" value="Add Repair" name="submitRepair"></center>
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
		<a href="account.php" class="popup2">account</a> | 
		<a href="logout.php">log out</a>
	</div>
</body>
</html>

<?php
if(isset($_POST['submitRepair'])){
	$partName = trim($_POST['partName']);
	$partCost = trim($_POST['partCost']);
	$laborCost = trim($_POST['laborCost']);
	$carID = $ID;
	$comments = trim($_POST['comments']);						

	if($comments == NULL){
		$comments = "N/A";
	}

	//insert repair info to database
	$query = "INSERT INTO Repair (CarID, PartName, PartCost, LaborCost, Comments) Values ('$carID', '$partName', '$partCost', '$laborCost	', '$comments')";

	//if query successful then redirect back to details.php
	if(mysqli_query($conn, $query)){
	
		//javascript to redirect back to details.php
		echo '<script type="text/javascript">';
		echo "window.location = \"details.php?ID=$ID\"";
		echo '</script>';
	}
	else{
		echo mysql_error();
	}
}
?>