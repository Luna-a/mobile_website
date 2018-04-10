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
//ID = CarID
$ID = mysqli_real_escape_string($conn, $_GET['ID']);
$BuyerID = mysqli_real_escape_string($conn, $_GET['BuyerID']);

//get BalanceID
$query = "SELECT * FROM Payment WHERE CarID = '$ID'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$BalanceID = $row['BalanceID'];

//get query ready to get all payment info
$paymentResult = mysqli_query($conn, $query);

//get vehicle status
$statusQuery = "SELECT Status From Car WHERE CarID = '$ID'";
$statusResult = mysqli_query($conn, $statusQuery);
$statusRow = mysqli_fetch_assoc($statusResult);
$status = $statusRow['Status'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>All Vehicles</title>
	<link rel="shortcut icon" href="images/favicon.ico">

	<!--
		tableStyle.css code from https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css	
	
		table sorter from https://datatables.net/
	-->
	
	<link rel="stylesheet" href = "style.css">	
	<link rel="stylesheet" href="tableStyle.css">	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
	
	<!--
	adds:
		sortable tables
		search
		multiple pages
	-->
	<script>
	$(document).ready(function(){
    $('#paymentTable').DataTable();
	});
	</script>
</head>
<body>			
	<center>
	<div class="top">
		Payment List & Information
	</div>
	
	<?php	
	//displays 'add payment' link if vehicle status is 'sold'
	if($status === 'Sold'){
		echo '<div class="payment">';
			echo "<a href=\"addPayment.php?ID={$ID}&BuyerID={$BuyerID}&BalanceID={$BalanceID}\">Add Payment</a>";
		echo '</div>';
	}
	?>
	
	<br>
	<table id="paymentTable" class="display" cellspacing="0" width="100%">
		<thead>
			<tr>				
				<th>Date</th>
				<th>Amount</th>
			</tr>
		</thead>
		
		<tbody>
<?php
		while($paymentRow = mysqli_fetch_array($paymentResult)){
			echo "<tr>";				
				echo "<td> {$paymentRow["Date"]} </td>";
				echo "<td>$ {$paymentRow["Amount"]} </td>";				
			echo "</tr>";
		}
?>	
		</tbody>
			<tfoot>
			<tr>
				<th>Date</th>
				<th>Amount</th>
			</tr>
		</tfoot>
	</table>
	
	<br>
	<br>
	<div class="payment">
		<?php
			echo "<a href=\"details.php?ID={$ID}\">Back</a>";
		?>
	</div>
	</center>
	
<p>
	<br>
	<div class="spacer"></div>
	<div class="footer">	
		<a href="account.php">account</a> | 
		<a href="logout.php">log out</a>
	</div>
</body>


</html>