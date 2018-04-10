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

$carID = mysqli_real_escape_string($conn, $_GET['ID']);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Vehicle Removal</title>
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
	
	<center>
		<h1>
		<br><br><br>
		<div class="detailsTableTitle">
		Remove Vehicle?
		</div>
		<br><br>
		</h1>
		<h2>
		<div class="detailsTableTitle">
		<?php
		echo "<a href=\"removeVehicle.php?ID={$carID}&remove=1\">Yes</a>";
		echo "&emsp;";
		echo "&emsp;";
		echo "<a href=\"details.php?ID={$carID}\">No</a>";
		?>
		</div>
		</h2>
	</center>
	
	<br><br><br><br>
	<div class="spacer"></div>
	<div class="footer">	
		<a href="account.php">account</a> | 
		<a href="logout.php">log out</a>
	</div>
</body>
</html>

<?php
if(isset($_GET['remove']) === true){
	//$carID = mysqli_real_escape_string($conn, $_GET['ID']);

	$query = "SELECT * FROM Car WHERE CarID = $carID";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);

	$status = $statusRow['Status'];

	if($status === "Available"){
		
		$carQuery = "DELETE FROM Car WHERE CarID = $carID";
		$repairQuery = "DELETE FROM Repair WHERE CarID = $carID";
		$imageQuery = "DELETE FROM Image WHERE CarID = $carID";
	
		if(mysqli_query($conn, $carQuery) && mysqli_query($conn, $repairQuery) && mysqli_query($conn, $imageQuery)){
			
			//javascript to redirect back to inventory.php
			echo '<script type="text/javascript">';
			echo 'window.location = "inventory.php"';
			echo '</script>';
		}
		else{
			echo mysql_error();
		}
	}
	else{
		//determine if buyer of this vehicle is buyer of other vehicles too
		//if yes do not delete buyer else delete
		
		$buyerID = $row['BuyerID'];
	
		$buyerQuery = "SELECT COUNT(*) FROM Car WHERE BuyerID = $buyerID";
	
		$buyerResult = mysqli_query($conn, $buyerQuery);
		$buyerRow = mysqli_fetch_array($buyerResult);
	
		//number of vehicles this cars buyer has bought
		$count = $buyerRow[0];
	
		//echo $count;
	
		//buyer only exists for this vehicle so delete everything
		if($count < 2){
			//echo "less than 2 <br>";
			//echo $count;
		
			$carQ = "DELETE FROM Car WHERE CarID = $carID";
			$repairQ = "DELETE FROM Repair WHERE CarID = $carID";
			$imageQ = "DELETE FROM Image WHERE CarID = $carID";
			$balanceQ = "DELETE FROM Balance WHERE CarID = $carID";	
			$buyerQ = "DELETE FROM Buyer WHERE BuyerID = $buyerID";
			$paymentQ = "DELETE FROM Payment WHERE CarID = $carID";
		
			if(mysqli_query($conn, $carQ) && mysqli_query($conn, $repairQ) && mysqli_query($conn, $imageQ) && 
			mysqli_query($conn, $balanceQ) && mysqli_query($conn, $buyerQ) && mysqli_query($conn, $paymentQ)){
				if($status === "Sold"){
					//javascript to redirect back to sold.php
					echo '<script type="text/javascript">';
					echo 'window.location = "sold.php"';
					echo '</script>';
				}
				else{
					//javascript to redirect back to archive.php
					echo '<script type="text/javascript">';
					echo 'window.location = "archive.php"';
					echo '</script>';
				}
			}
			else{
				echo mysqli_error();
			}
		}
		//buyer has other vehicles so buyer is not deleted
		else{
			//echo "count: ".$count;
		
			$carQ = "DELETE FROM Car WHERE CarID = $carID";
			$repairQ = "DELETE FROM Repair WHERE CarID = $carID";
			$imageQ = "DELETE FROM Image WHERE CarID = $carID";
			$balanceQ = "DELETE FROM Balance WHERE CarID = $carID";	
			$paymentQ = "DELETE FROM Payment WHERE CarID = $carID";
		
			if(mysqli_query($conn, $carQ) && mysqli_query($conn, $repairQ) && mysqli_query($conn, $imageQ) && 
			mysqli_query($conn, $balanceQ) && mysqli_query($conn, $paymentQ)){
				if($status === "Sold"){
					//javascript to redirect back to sold.php
					echo '<script type="text/javascript">';
					echo 'window.location = "sold.php"';
					echo '</script>';
				}
				else{
					//javascript to redirect back to archive.php
					echo '<script type="text/javascript">';
					echo 'window.location = "archive.php"';
					echo '</script>';
				}
			}
			else{
				echo mysqli_error();
			}
		
		}	
	}
}
?>