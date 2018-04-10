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

$CarID = mysqli_real_escape_string($conn, $_GET['ID']);

$user = $_SESSION['login_user'];
$query = "SELECT * FROM Buyer WHERE User = '$user'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Adding Buyer</title>
	
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="stylesheet" href = "style.css">	
	<link rel="stylesheet" href="tableStyle.css">
	
	<!--
		tableStyle.css code from https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css	
	
		table sorter from https://datatables.net/
	-->
	
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
    $('#mainTable').DataTable();
	});
	</script>
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
				<th>New Buyer Information</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><center><input class="box" type="text" name="name" placeholder="Name*" size="40"	></center></td>
			</tr>
			<tr>
				<td><center><input class="box" type="text" name="phone" placeholder="Phone" size="40"></center></td>
			</tr>
			<tr>
				
				<td><center>
					<textarea class="addComments" name="comments" cols="45" rows="4" placeholder="Additional Comments..."></textarea>
				<!--<input type="textarea" name="comments" placeholder="Additional Comments" size="40"	>-->
				
				</center>
			</tr>
			<!--<input class="box" type="hidden" name="id" <?php echo " value=$CarID" ?> size="40">-->
		</tbody>
		<tfoot>
			<tr>
				<th>
					<center><input type="submit" value="Add Buyer" name="submitInfo"></center>
				</th>			
			</tr>
		</tfoot>
	</table>
	</center>
</form>


	<center><br>
	<div class=detailsTableTitle>
		Existing Buyers
	</div>
	</center>

	
	<center>
	<div class=buyerTableBox>
	<table id="mainTable" class="display" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th></th>
				<th>Name</th>
				<th>Phone</th>				
				<th>Comments</th>
			</tr>
		</thead>
		
		<tbody>
<?php
		while($row = mysqli_fetch_array($result)){
			echo "<tr>";
				//echo "<td> <a href=\"details.php?ID={$row['CarID']}\" class = \"classTable\">Details</a></td>";
				echo "<td> <a href=\"addBuyer.php?BuyerID={$row['BuyerID']}&ID={$CarID}&link=1\" class = \"classTable\">Select</a></td>";
				echo "<td>". $row["Name"]. "</td>";
				echo "<td>". $row["Phone"]. "</td>";
				echo "<td>". $row["Comments"]. "</td>";
			echo "</tr>";
		}
?>	
		</tbody>
			<tfoot>
			<tr>
				<th></th>
				<th>Name</th>
				<th>Phone</th>				
				<th>Comments</th>
			</tr>
		</tfoot>
	</table>
	</div>
	</center>

</body>
</html>

<?php
//if form is used
if(isset($_POST['submitInfo']) === true){
	
	$name = trim($_POST['name']);
	$phone = trim($_POST['phone']);
	$user = $_SESSION['login_user'];
	$comments = trim($_POST['comments']);
	$carID = $CarID;
			
	if($comments === NULL){
		$comments = "N/A";
	}
	if($phone === NULL){
		$phone = "N/A";
	}

	//insert buyer info to database
	$query = "INSERT INTO Buyer (Name, User, Phone, Comments) Values ('$name', '$user', '$phone', '$comments')";

	if(mysqli_query($conn, $query)){
		//determine buyerID since it is done by database automatically
		$query2 = "SELECT BuyerID FROM Buyer WHERE User = '$user' and Phone = '$phone' and Comments = '$comments' and Name = '$name'";
		$result = mysqli_query($conn, $query2);
		$IDresult = mysqli_fetch_assoc($result);
		$IDresult = $IDresult['BuyerID'];
	
		$query3 = "UPDATE Car SET BuyerID = '$IDresult' WHERE CarID = '$carID'";	
	
		if(mysqli_query($conn, $query3)){
			//header("location: addBalance.php?buyerID={$IDresult}");		
			//header("location: addBalance.php?carID={$carID}&buyerID={$IDresult}");
			
			//javascript to redirect to next step of selling : addBalance.php
			echo '<script type="text/javascript">';
			echo "window.location = \"addBalance.php?carID={$carID}&buyerID={$IDresult}\"";
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


//if link is used
if(isset($_GET['link']) === true){
	$BuyerID = mysqli_real_escape_string($conn, $_GET['BuyerID']);
	//$CarID = mysqli_real_escape_string($conn, $_GET['CarID']);
	$carID = $CarID;
	//echo $BuyerID."<br>";
	//echo $CarID;

	$query = "UPDATE Car Set BuyerID = '$BuyerID' WHERE CarID = '$CarID'";

	if(mysqli_query($conn, $query)){
		
		//javascript to redirect to next step of selling : addBalance.php
		echo '<script type="text/javascript">';
		echo "window.location = \"addBalance.php?carID={$carID}&buyerID={$BuyerID}\"";
		echo '</script>';
	}
	else{
		echo mysql_error();
	}	
}


?>