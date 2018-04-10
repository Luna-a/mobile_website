<?php
function vehicleChange($title, $name, $editValue, $CarID){
	echo '<form action ="updated.php" method="POST">';
			echo '<center>';
			echo '<table class="addInfo">';
				echo '<thead>';
					echo '<tr>';
						echo '<th>New "'.$title.'"</th>';
					echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
				echo '<tr>';
					echo '<td><center><input class="box" type="text" name="'.$name.'" placeholder="New Value" size="40" ></center></td>';
				echo '</tr>';
				echo '<input type="hidden" name="editValue" value="'.$editValue.'">';
				echo '<input type="hidden" name="CarID" value="'.$CarID.'">';
				echo '</tbody>';
					echo '<tfoot>';
						echo '<tr>';
							echo '<th>';
								echo '<center><input type="submit" value="Submit Edit"></center>';
							echo '</th>';
						echo '</tr>';
					echo '</tfoot>	';
				echo '</table>';
				echo '</center>';
			echo '</form>';
}

function repairChange($title, $name, $editValue, $RepairID){
	echo '<form action ="updated.php" method="POST">';
			echo '<center>';
			echo '<table class="addInfo">';
				echo '<thead>';
					echo '<tr>';
						echo '<th>New "'.$title.'"</th>';
					echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
				echo '<tr>';
					echo '<td><center><input class="box" type="text" name="'.$name.'" placeholder="New Value" size="40" ></center></td>';
				echo '</tr>';
				echo '<input type="hidden" name="editValue" value="'.$editValue.'">';
				echo '<input type="hidden" name="RepairID" value="'.$RepairID.'">';
				echo '</tbody>';
					echo '<tfoot>';
						echo '<tr>';
							echo '<th>';
								echo '<center><input type="submit" value="Submit Edit"></center>';
							echo '</th>';
						echo '</tr>';
					echo '</tfoot>';
				echo '</table>';
				echo '</center>';
			echo '</form>';
}

function buyerChange($title, $name, $editValue, $BuyerID){
	echo '<form action ="updated.php" method="POST">';
			echo '<center>';
			echo '<table class="addInfo">';
				echo '<thead>';
					echo '<tr>';
						echo '<th>New Buyer "'.$title.'"</th>';
					echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
				echo '<tr>';
					echo '<td><center><input class="box" type="text" name="'.$name.'" placeholder="New Value" size="40" ></center></td>';
				echo '</tr>';
				echo '<input type="hidden" name="editValue" value="'.$editValue.'">';
				echo '<input type="hidden" name="BuyerID" value="'.$BuyerID.'">';
				echo '</tbody>';
					echo '<tfoot>';
						echo '<tr>';
							echo '<th>';
								echo '<center><input type="submit" value="Submit Edit"></center>';
							echo '</th>';
						echo '</tr>';
					echo '</tfoot>';
				echo '</table>';
				echo '</center>';
			echo '</form>';	
}
?>
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

$editValue = mysqli_real_escape_string($conn, $_GET['edit']);

//used for all Vehicle changes
$CarID = mysqli_real_escape_string($conn, $_GET['CarID']);

//used for all Repair changes
$RepairID = mysqli_real_escape_string($conn, $_GET['RepairID']);

//used for all Buyer changes
$BuyerID = mysqli_real_escape_string($conn, $_GET['BuyerID']);
?>

<!DOCTYPE html>
<html>
<title>Edit Information</title>
<head>
<link rel="stylesheet" href = "style.css">	
	<center>
	<div class="top">
		Edit Information
	</div>
	</center>
</head>
<body>
<br><br>
<?php

switch($editValue){
	//changes for vehicle
	case Year:
		vehicleChange("Year", "newYear", $editValue, $CarID);
		break;
	case Make:
		vehicleChange("Make", "newMake", $editValue, $CarID);
		break;
	case Model:
		vehicleChange("Model", "newModel", $editValue, $CarID);
		break;
	case Miles: 		
		vehicleChange("Miles", "newMiles", $editValue, $CarID);
		break;
	case Vin:
		vehicleChange("Vin", "newVin", $editValue, $CarID);
		break;
	case Cost:
		vehicleChange("Cost", "newCost", $editValue, $CarID);
		break;
	case Fees:
		vehicleChange("Fees", "newFees", $editValue, $CarID);
		break;
	case AskingPrice:
		vehicleChange("Asking Price", "newAskingPrice", $editValue, $CarID);
		break;	
	case SoldFor:
		$BalanceID = mysqli_real_escape_string($conn, $_GET['BalanceID']);
		?>
		<form action ="updated.php" method="POST">
			<center>
			<table class="addInfo">
				<thead>
					<tr>
						<th>New "Sold For" and "Total Price"</th>
					</tr>
				</thead>
				<tbody>
				<tr>
					<td><center><input class="box" type="text" name="newSoldFor" placeholder="New Value" size="40" ></center></td>
				</tr>
				<input type="hidden" name="editValue" <?php echo " value=$editValue" ?>>
				<input type="hidden" name="CarID" <?php echo " value=$CarID" ?>>
				<input type="hidden" name="BalanceID" <?php echo " value=$BalanceID" ?>>
				</tbody>
					<tfoot>
						<tr>
							<th>
								<center><input type="submit" value="Submit Edit"></center>
							</th>
						</tr>
					</tfoot>
				</table>
				</center>
		</form>
		<?php
		break;
	case DatePurchased:
		?>
		<form action="updated.php" method="POST">
			<center>
			<table class="addInfo">
				<thead>
					<tr>
						<th>New "Date Purchased"</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<div class="tableDateText">
								<center>Date Purchased</center>
								<center><input class="box" type="date" name="newDate" size="40"></center>
							</div>	
						</td>
					</tr>
			
					<input type="hidden" name="editValue" <?php echo " value=$editValue" ?>>
					<input type="hidden" name="CarID" <?php echo " value=$CarID" ?>>
					
				</tbody>
				<tfoot>
					<tr>
						<th>
							<center><input type="submit" value="Submit Edit"></center>
						</th>			
					</tr>
				</tfoot>	
			</table>
			</center>
		</form>			
		<?php		
		break;
	case Day:
		?>
		<form action="updated.php" method="POST">
			<center>
			<table class="addInfo" width:80%>
				<thead>
					<tr>
						<th>New "Reminder Message Day"</th>
					</tr>
				</thead>
		<tbody>
			<tr>
				<td>
					<div class="tableDateText">
						<center>Day to Receive Message</center>
						<center>
							<!--<input type="date" name="date">-->
							<select class="size" name="newDay">
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
			<input type="hidden" name="editValue" <?php echo " value=$editValue" ?>>
			<input type="hidden" name="CarID" <?php echo "value=$CarID" ?>>
		</tbody>
				<tfoot>
					<tr>
						<th>
							<center><input type="submit" value="Submit Edit"></center>
						</th>			
					</tr>
				</tfoot>	
			</table>
			</center>
		</form>			
		<?php
		break;		
	//changes for repair	
	case PartName:
		repairChange("Part Name", "newPartName", $editValue, $RepairID);
		break;		
	case PartCost:
		repairChange("Part Cost", "newPartCost", $editValue, $RepairID);
		break;		
	case LaborCost:
		repairChange("Labor Cost", "newLaborCost", $editValue, $RepairID);
		break;		
	case Comments:
		repairChange("Comments", "newComments", $editValue, $RepairID);
		break;
	//changes for buyer	
	case BuyerName:	
		buyerChange("Name", "newBuyerName", $editValue, $BuyerID);
		break;
	case Phone:
		buyerChange("Phone", "newBuyerPhone", $editValue, $BuyerID);
		break;
	case BuyerComments:
		buyerChange("Comments", "newBuyerComments", $editValue, $BuyerID);
		break;	
	
}

echo "</body>";
echo "</html>";
?>