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
$BuyerID = mysqli_real_escape_string($conn, $_GET['BuyerID']);
$BalanceID = mysqli_real_escape_string($conn, $_GET['BalanceID']);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Payment Addition</title>
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="stylesheet" href = "style.css">				
</head>

<body>
	<center>
	<div class="top">
		Payment List & Information
	</div>
	
	<br><br>
	<form method="POST">	
		<table class="addInfo">
			<thead>
				<tr>
					<th>New Payment Information</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><center><input class="box" type="text" name="amount" placeholder="Payment Amount*" size="40" ></center></td>
				</tr>
				<tr>
					<td>
						<div class="tableDateText">
							<center>Payment Date*</center>
							<center><input class="box" type="date" name="date"></center>
						</div>
						<?php
							if(isset($_GET['error']) === true){
								echo "<br>";
								echo "<center>Error: Payment is Greater than Total!</center>";
							}
						?>						
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th>
						<center><input type="submit" value="Add Payment" name="submitPayment"></center>
					</th>			
				</tr>
			</tfoot>	
		</table>
	</form>
	</center>
	
<?php
	if(isset($_GET['payed']) === true){
		echo '<div class="payed">';
		echo '<body><h1>Vehicle is Now Payed Off!</h1></body>';
		echo "<body><h2> <a href=\"payments.php?ID=".$carID."&BuyerID=".$BuyerID."\">Back</a> </h2></body>";
		echo '</div>';
	}
?>
</body>
</html>

<?php

if(isset($_POST['submitPayment'])){
	$amount = trim($_POST['amount']);
	$date = trim($_POST['date']);

	//retrieve balance information
	$balanceQuery = "SELECT * FROM Balance WHERE BalanceID = '$BalanceID'";
	$result = mysqli_query($conn, $balanceQuery);
	$row = mysqli_fetch_assoc($result);

	$total = $row['Total'];
	$paid = $row['Paid'];
	$owed = $row['Owed'];

	//throw error if payment exceeds owed amount
	if($amount > $owed){
		
		//javascript to display error
		echo '<script type="text/javascript">';
		echo "window.location = \"addPayment.php?ID={$carID}&BuyerID={$BuyerID}&BalanceID={$BalanceID}&error=1\"";
		echo '</script>';	
	}
	
	//add payment to payment table
	else if($amount < $owed){
		//calculate new values	
		$owed = $owed - $amount;
		$paid = $paid + $amount;
			
		//query to add new payment
		$payQuery = "INSERT INTO Payment (BuyerID, Amount, Date, BalanceID, CarID) Values ('$BuyerID', '$amount', '$date', '$BalanceID', '$carID')";
	
		//query to update balance with new owed and paid values
		$balanceQuery = "UPDATE Balance SET Owed = '$owed', Paid = '$paid' WHERE BalanceID = '$BalanceID'";	
	
		if(mysqli_query($conn, $payQuery) && mysqli_query($conn, $balanceQuery)){
			//javascript to redirct to payments.php
			echo '<script type="text/javascript">';
			echo "window.location = \"payments.php?ID={$carID}&BuyerID={$BuyerID}\"";
			echo '</script>';	
			
			//header("Location: payments.php?ID={$carID}&BuyerID={$BuyerID}");
		}
		else{
			echo mysql_error();
		}
	}
	//amount = owed
	//vehicle is paid off so is transferred to archive
	else{
		//calculate new values	
		$owed = $owed - $amount;
		$paid = $paid + $amount;
	
		//query to add new payment
		$payQuery = "INSERT INTO Payment (BuyerID, Amount, Date, BalanceID, CarID) Values ('$BuyerID', '$amount', '$date', '$BalanceID', '$carID')";
	
		//query to update balance with new owed and paid values
		$balanceQuery = "UPDATE Balance SET Owed = '$owed', Paid = '$paid' WHERE BalanceID = '$BalanceID'";	
	
		//query to update vehicle to archive
		$archiveQuery = "UPDATE Car SET Status = 'Archive' WHERE CarID = '$carID'"; 
	
		//query to set Day to 'NULL' so that reminder message no longer goes out for this vehicle
		$var = NULL;
		$messageQuery = "UPDATE Car SET Day = NULL WHERE CarID = '$carID'";
	
		if(mysqli_query($conn, $payQuery) && mysqli_query($conn, $balanceQuery) && mysqli_query($conn, $archiveQuery)&& mysqli_query($conn, $messageQuery)){
			//500 error if no 'Location:'
			//header("Location: payments.php?ID={$carID}&BuyerID={$BuyerID}");
			/*
			echo '<html><title>Payed Off</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Vehicle is Now Payed Off!</h1></body>';
			echo "<body><h3> <a href=\"archivePayments.php?ID=".$carID."&BuyerID=".$BuyerID."\">Back</a> </h3></body>";
			echo '</html>';
			*/
			
			//javascript to display payed off message
			echo '<script type="text/javascript">';
			echo "window.location = \"addPayment.php?ID={$carID}&BuyerID={$BuyerID}&payed=1\"";
			echo '</script>';	
		}
		else{
			echo mysql_error();
		}
	}
}
?>