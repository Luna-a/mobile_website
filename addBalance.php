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
$CarID = mysqli_real_escape_string($conn, $_GET['carID']);
$BuyerID = mysqli_real_escape_string($conn, $_GET['buyerID']);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Adding Pricing Information</title>
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
				<th>Pricing Information</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><center><input class="box" type="text" name="total" placeholder="Total Price*" size="40"	></center></td>
			</tr>
			<tr>
				<td><center><input class="box" type="text" name="paid" placeholder="Amount Paid / Down Payment*" size="40"></center></td>
			</tr>
			<tr>
				<td>
					<div class="tableDateText">
						<center>Date Purchased*</center>
						<center><input class="box" type="date" name="date"></center>
					</div>	
					<?php
						if(isset($_GET['error']) === true){
							echo "<br>";
							echo "<center>Error: Payment is Greater than Total Price!</center>";
						}
					?>
				</td>
			</tr>
			<!--<input type="hidden" name="buyerID" <?php echo " value=$BuyerID" ?>>
			<input type="hidden" name="carID" <?php echo "value=$CarID" ?>>-->
		</tbody>
		<tfoot>
			<tr>
				<th>
					<center><input type="submit" value="Add Info" name="submitInfo"></center>
				</th>			
			</tr>
		</tfoot>
	</table>
	</center>
</form>
	<br><br>
	<div class="spacer">
	</div>
	<div class="footer">	
		<a href="account.php">account</a> | 
		<a href="logout.php">log out</a>
	</div>
</body>
</html>

<?php
if(isset($_POST['submitInfo'])){
	$total = trim($_POST['total']);
	$paid = trim($_POST['paid']);
	$date = trim($_POST['date']);
	$user = $_SESSION['login_user'];

	//if full amount paid then add vehicle to archive 
	if($total === $paid){
	
		//create new balance
		$query = "INSERT INTO Balance (CarID, Total, Paid, User) Values ('$CarID','$total', '$paid', '$user')";	
	
		//update Car table with new values for Status and SoldFor
		$query2 = "UPDATE Car SET Status = 'Archive' WHERE CarID = '$CarID'"; 
		$query3 = "UPDATE Car SET SoldFor = '$paid' WHERE CarID = '$CarID'";
	
		if(mysqli_query($conn, $query) && mysqli_query($conn, $query2) && mysqli_query($conn, $query3)){
			//determine BalanceID since it is done by database automatically
			$query4 = "SELECT BalanceID FROM Balance NATURAL JOIN Car WHERE CarID = '$CarID'";
			$result = mysqli_query($conn, $query4);
			$row = mysqli_fetch_assoc($result);
			$BalanceID = $row['BalanceID'];
	
			//create new payment which will be equal to the total of the price ie paid in full
			$query5 = "INSERT INTO Payment (BuyerID, Amount, Date, BalanceID, CarID) Values ('$BuyerID','$paid','$date', '$BalanceID', '$CarID')";			
			
			if(mysqli_query($conn, $query5)){	
				//javascript to redirect back to archive.php
				echo '<script type="text/javascript">';
				echo 'window.location = "archive.php"';
				echo '</script>';				
			}
			else{
				echo mysql_error();
			}
		}
		else{
			echo mysql_error();
		}
	}
	//else add vehicle to sold b/c transaction is not fully complete
	else if($paid < $total){
		$down = $paid;
		$owed = $total - $paid;
	
		//create new balance
		$query = "INSERT INTO Balance (CarID, Total, Paid, Owed, DownPayment, User) Values ('$CarID', '$total', '$paid', '$owed', '$down', '$user')";
	
		//update Car table with values for Status and SoldFor
		$query2 = "UPDATE Car SET Status = 'Sold' WHERE CarID = '$CarID'";
		$query3 = "UPDATE Car SET SoldFor = '$total' WHERE CarID = '$CarID'";
	
		if(mysqli_query($conn, $query) && mysqli_query($conn, $query2) && mysqli_query($conn, $query3)){
			//determine BalanceID since it is done by database automatically
			$query4 = "SELECT BalanceID FROM Balance NATURAL JOIN Car WHERE CarID = '$CarID'";
			$result = mysqli_query($conn, $query4);
			$row = mysqli_fetch_assoc($result);
			$BalanceID = $row['BalanceID'];
		
			//create new payment which will be the down payment
			$query5 = "INSERT INTO Payment (BuyerID, Amount, Date, BalanceID, CarID) Values ('$BuyerID','$paid','$date','$BalanceID', '$CarID')";
		
			if(mysqli_query($conn, $query5)){
								
				//javascript to redirect to messageSetup.php
				echo '<script type="text/javascript">';
				echo "window.location = \"messageSetup.php?CarID=$CarID\"";
				echo '</script>';
			}
			else{
				echo mysql_error();
			}
		}
		else{
			echo mysql_error();
		}
	}
	//payment is greater than price resulting in error
	else if($paid > $total){
		
		//javascript to display error message
		echo '<script type="text/javascript">';
		echo "window.location = \"addBalance.php?carID={$CarID}&buyerID={$BuyerID}&error=1\"";
		echo '</script>';
	}
}
?>