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


//$name = $_SESSION['login_user'];
$query = "SELECT * FROM Car WHERE User = 'User1' AND Status = 'Available'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Inventory</title>
	
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="stylesheet" href = "style.css">	
	
	<!--
		tableStyle.css code from https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css	
	
		table sorter from https://datatables.net/
	-->
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
    $('#mainTable').DataTable();
	});
	</script>
</head>
<body>		
	
	<center>
	<div class="top">
		<a href="home.php">All</a> | 
		<a href="inventory.php"><b>Inventory</b></a> | 
		<a href="sold.php">Sold</a> | 
		<a href="archive.php">Archive</a> |
		<a href="buyers.php">Buyers</a>
	</div>
		
	<div class="add">	
		<a href="addVehicle.php">Add Vehicle</a>
	</div>
	</center>


	<center>
	<table id="mainTable" class="display" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Year</th>
				<th>Make</th>
				<th>Model</th>
				<th>Cost</th>
			</tr>
		</thead>
		
		<tbody>
<?php
		while($row = mysqli_fetch_array($result)){
			echo "<tr>";
				echo '<td> <a href="details.php?ID='.$row["CarID"].'" id="blackLink">'.$row["Year"].'</a> </td>';
				echo "<td>". $row["Make"]. "</td>";
				echo "<td>". $row["Model"]. "</td>";
				echo "<td>$ ". $row["Cost"]. "</td>";				
			echo "</tr>";
		}
?>	
		</tbody>
			<tfoot>
			<tr>
				<th>Year</th>
				<th>Make</th>
				<th>Model</th>
				<th>Cost</th>		
			</tr>
		</tfoot>
	</table>
	</center>

<p>
	<div class="spacer">
	</div>
	<div class="footer">			
		<a href="account.php">account</a> | 
		<a href="logout.php">log out</a>
	</div>
</body>


</html>