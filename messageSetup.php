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

$CarID = mysqli_real_escape_string($conn, $_GET['CarID']);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Reminder Message Information</title>
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
				<th>Reminder Message Information</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<div class="tableDateText">
						<center>Day to Receive Message</center>
						<center>
							<!--<input type="date" name="date">-->
							<select class="size" name="Day">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
							</select>
						</center>
					</div>	
				</td>
			</tr>			
			<!--<input type="hidden" name="carID" <?php echo "value=$CarID" ?>>-->
		</tbody>
		<tfoot>
			<tr>
				<th>
					<center><input type="submit" value="Submit" name="submitInfo"></center>
				</th>			
			</tr>
		</tfoot>
	</table>
	</center>
</form>
	<br><br><br>
	<div class="spacer"></div>
	<div class="footer">	
		<a href="account.php">account</a> | 
		<a href="logout.php">log out</a>
	</div>
</body>
</html>

<?php
if(isset($_POST['submitInfo'])){
	$Day = trim($_POST['Day']);
	//$CarID = trim($_POST['carID']);			

	$query = "UPDATE Car SET Day = '$Day' WHERE CarID = '$CarID'"; 

	if(mysqli_query($conn, $query)){		
		//javascript to redirect back to sold.php
		echo '<script type="text/javascript">';
		echo 'window.location = "sold.php"';
		echo "</script>";	
	}
	else{
		echo mysql_error();
	}
}
?>