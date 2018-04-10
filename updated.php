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


//params
//("newYear", "Year", "CarID", "Car")
function editVehicle($value, $name){ 		
	//examples
	//IDname == CarID or IDname == BuyerID
	//DBtablename == "Car" or DBname == "Buyer" 

	global $conn;
	//half way point -- only does changes for Vehicle information
	
	$newValue = trim($_POST[$value]);
	$CarID = trim($_POST['CarID']);						
		
	$query = "UPDATE Car SET $name = $newValue WHERE CarID = $CarID";
	//echo $query;

	if(mysqli_query($conn, $query)){
		echo '<html><title>Information Updated</title>';
		echo '<head><link rel="stylesheet" href="style.css"></head>';
		echo '<body><h1>Vehicle '.$name.' Updated</h1></body>';
		echo "<body><h3> <a href=\"edit.php?edit=".$name."&CarID=".$CarID."\">Back</a> </h3></body>";
		echo '</html>';			
	}
	else{
		echo "no";
		echo mysql_error();
	}		
	
	
	//////////////////////
	//$newName, $name, $IDname, $DBtableName
/*	$newValue = trim($_POST[$newName]);
	$IDvalue = trim($_POST[$IDname]);
		
	$query = "UPDATE $DBtableName SET $name = $newValue WHERE $IDname = $IDvalue";

//	echo $newValue."<br>";
//	echo $IDvalue."<br>";
	echo $query."<br>";
	
	if(mysqli_query($conn, $query)){
		echo '<html><title>Information Updated</title>';
		echo '<head><link rel="stylesheet" href="style.css"></head>';
		echo '<body><h1>Vehicle '.$name.' Updated</h1></body>';
		echo "<body><h3> <a href=\"edit.php?edit=".$name."&".$IDname."=".$IDvalue."\">Back</a> </h3></body>";
		echo '</html>';			
	}
	else{
		echo "no";
		echo mysql_error();
	}		
		
*/
	//original -- does everything manually
/*	$newYear = trim($_POST['newYear']);
	$CarID = trim($_POST['CarID']);						
		
	$query = "UPDATE Car SET Year = '$newYear' WHERE CarID = '$CarID'";
		
	if(mysqli_query($conn, $query)){
		echo '<html><title>Information Updated</title>';
		echo '<head><link rel="stylesheet" href="style.css"></head>';
		echo '<body><h1>Vehicle Year Updated</h1></body>';
		echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&CarID=".$CarID."\">Back</a> </h3></body>";
		echo '</html>';			
	}
	else{
		echo mysql_error();
	}
	
	
	//half way point -- only does changes for Vehicle information
	/*
	$newValue = trim($_POST[$value]);
	$CarID = trim($_POST['CarID']);						
		
	$query = "UPDATE Car SET $name = $newValue WHERE CarID = $CarID";

	if(mysqli_query($conn, $query)){
		echo '<html><title>Information Updated</title>';
		echo '<head><link rel="stylesheet" href="style.css"></head>';
		echo '<body><h1>Vehicle '.$name.' Updated</h1></body>';
		echo "<body><h3> <a href=\"edit.php?edit=".$name."&CarID=".$CarID."\">Back</a> </h3></body>";
		echo '</html>';			
	}
	else{
		echo mysql_error();
	}	
*/
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
	header("location: noLogin.php");
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$editValue = trim($_POST['editValue']);
}

switch($editValue){
	//changes for Vehicle
	case Year: 
//		editVehicle("newYear", "Year");
	$newYear = trim($_POST['newYear']);
	$CarID = trim($_POST['CarID']);						
		
	$query = "UPDATE Car SET Year = '$newYear' WHERE CarID = '$CarID'";
		
	if(mysqli_query($conn, $query)){
		echo '<html><title>Information Updated</title>';
		echo '<head><link rel="stylesheet" href="style.css"></head>';
		echo '<body><h1>Vehicle Year Updated</h1></body>';
		echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&CarID=".$CarID."\">Back</a> </h3></body>";
		echo '</html>';			
	}
	else{
		echo mysql_error();
	}		
		break;
		
	case Make: 
//		editVehicle("newMake", "Make");
		$newMake = trim($_POST['newMake']);
		$CarID = trim($_POST['CarID']);						
		
		$query = "UPDATE Car SET Make = '$newMake' WHERE CarID = '$CarID'";
		
		if(mysqli_query($conn, $query)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Vehicle Make Updated</h1></body>';
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&CarID=".$CarID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}
		break;
		
	case Model: 
//		editVehicle("newModel", "Model");
		$newModel = trim($_POST['newModel']);
		$CarID = trim($_POST['CarID']);						
		
		$query = "UPDATE Car SET Model = '$newModel' WHERE CarID = '$CarID'";
		
		if(mysqli_query($conn, $query)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Vehicle Model Updated</h1></body>';
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&CarID=".$CarID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}
		break;		

	case Miles: 
//		editVehicle("newMiles", "Miles");
		$newMiles = trim($_POST['newMiles']);
		$CarID = trim($_POST['CarID']);						
		
		$query = "UPDATE Car SET Miles = '$newMiles' WHERE CarID = '$CarID'";
		
		if(mysqli_query($conn, $query)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Vehicle Miles Updated</h1></body>';
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&CarID=".$CarID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}	
		break;
		
	case Vin:
//		editVehicle("newVin", "Vin");
		$newVin = trim($_POST['newVin']);
		$CarID = trim($_POST['CarID']);					
		
		$query = "UPDATE Car SET Vin = '$newVin' WHERE CarID = '$CarID'";
		
		if(mysqli_query($conn, $query)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Vehicle Vin Updated</h1></body>';
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&CarID=".$CarID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}
		break;
		
	case Cost:
//		editVehicle("newCost", "Cost");
		$newCost = trim($_POST['newCost']);
		$CarID = trim($_POST['CarID']);					
		
		$query = "UPDATE Car SET Cost = '$newCost' WHERE CarID = '$CarID'";
		
		if(mysqli_query($conn, $query)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Vehicle Cost Updated</h1></body>';
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&CarID=".$CarID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}
		break;
		
	case Fees:
//		editVehicle("newFees", "Fees");
		$newFees = trim($_POST['newFees']);
		$CarID = trim($_POST['CarID']);					
		
		$query = "UPDATE Car SET Fees = '$newFees' WHERE CarID = '$CarID'";
		
		if(mysqli_query($conn, $query)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Vehicle Fees Updated</h1></body>';
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&CarID=".$CarID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}
		break;
		
	case AskingPrice:
//		editVehicle("newAskingPrice");
		$newAskingPrice = trim($_POST['newAskingPrice']);
		$CarID = trim($_POST['CarID']);					
		
		$query = "UPDATE Car SET AskingPrice = '$newAskingPrice' WHERE CarID = '$CarID'";
		
		if(mysqli_query($conn, $query)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Vehicle Asking Price Updated</h1></body>';
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&CarID=".$CarID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}
		break;
	//changes Vehicle and Balance	
	case SoldFor:
		$newSoldFor = trim($_POST['newSoldFor']);
		$CarID = trim($_POST['CarID']);	
		$BalanceID = trim($_POST['BalanceID']);	
		
		$balanceQuery = "SELECT * FROM Balance WHERE BalanceID = '$BalanceID'";
		$balanceResult = mysqli_query($conn, $balanceQuery);
		$balanceRow = mysqli_fetch_assoc($balanceResult);
		
		$newOwed = $newSoldFor - $balanceRow['Paid'];
		
		//new price - paid = newOwed
		
		$soldQuery = "UPDATE Car SET SoldFor = '$newSoldFor' WHERE CarID = '$CarID'";
		$totalQuery = "UPDATE Balance SET Total = '$newSoldFor' WHERE BalanceID = '$BalanceID'";
		$owedQuery = "UPDATE Balance SET Owed = '$newOwed' WHERE BalanceID = '$BalanceID'";
		
		if(mysqli_query($conn, $soldQuery) && mysqli_query($conn, $totalQuery) && mysqli_query($conn, $owedQuery)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Vehicle Total and Sold For Price Updated</h1></body>';
			
			//echo '<a href="edit.php?edit=SoldFor&CarID='.$ID.'&BalanceID='.$balRow['BalanceID'].'" class = "popup1" id="blackLink">Sold For</a>';
			
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&CarID=".$CarID."&BalanceID=".$BalanceID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}
		break;
	case DatePurchased:
//		editVehicle("newDate", "Date");
		$newDate = trim($_POST['newDate']);
		$CarID = trim($_POST['CarID']);					
		
		$query = "UPDATE Car SET DatePurchased = '$newDate' WHERE CarID = '$CarID'";
		
		if(mysqli_query($conn, $query)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Vehicle Date Purchased Updated</h1></body>';
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&CarID=".$CarID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}
		break;
	case Day:
//		editVehicle("newVin", "Vin");
		$newDay = trim($_POST['newDay']);
		$CarID = trim($_POST['CarID']);					
		
		$query = "UPDATE Car SET Day = '$newDay' WHERE CarID = '$CarID'";
		
		if(mysqli_query($conn, $query)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Message Reminder Day Updated</h1></body>';
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&CarID=".$CarID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}
		break;		
	//changes for Repair
	case PartName:
		$newPartName = trim($_POST['newPartName']);
		$RepairID = trim($_POST['RepairID']);					
		
		$query = "UPDATE Repair SET PartName = '$newPartName' WHERE RepairID = '$RepairID'";
		
		if(mysqli_query($conn, $query)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Repair Part Name Updated</h1></body>';
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&RepairID=".$RepairID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}			
		break;
	case PartCost:
		$newPartCost = trim($_POST['newPartCost']);
		$RepairID = trim($_POST['RepairID']);					
		
		$query = "UPDATE Repair SET PartCost = '$newPartCost' WHERE RepairID = '$RepairID'";
		
		if(mysqli_query($conn, $query)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Repair Part Cost Updated</h1></body>';
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&RepairID=".$RepairID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}			
		break;		
	case LaborCost:
		$newLaborCost = trim($_POST['newLaborCost']);
		$RepairID = trim($_POST['RepairID']);					
		
		$query = "UPDATE Repair SET LaborCost = '$newLaborCost' WHERE RepairID = '$RepairID'";
		
		if(mysqli_query($conn, $query)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Repair Labor Cost Updated</h1></body>';
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&RepairID=".$RepairID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}			
		break;	
	case Comments:
		$newComments = trim($_POST['newComments']);
		$RepairID = trim($_POST['RepairID']);					
		
		$query = "UPDATE Repair SET Comments = '$newComments' WHERE RepairID = '$RepairID'";
		
		if(mysqli_query($conn, $query)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Repair Comments Updated</h1></body>';
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&RepairID=".$RepairID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}			
		break;	
	//changes for Buyer
	case BuyerName:
		$newBuyerName = trim($_POST['newBuyerName']);
		$BuyerID = trim($_POST['BuyerID']);			
		
		$query = "UPDATE Buyer SET Name = '$newBuyerName' WHERE BuyerID = '$BuyerID'";
		
		if(mysqli_query($conn, $query)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Buyer Name Updated</h1></body>';
			
			//echo '<a href="edit.php?edit=BuyerName&BuyerID='.$row["BuyerID"]. '"class = "popup1" id="blackLink">Name</a>';
			
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&BuyerID=".$BuyerID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}			
		break;	
	case Phone:
		$newBuyerPhone = trim($_POST['newBuyerPhone']);
		$BuyerID = trim($_POST['BuyerID']);			
		
		$query = "UPDATE Buyer SET Phone = '$newBuyerPhone' WHERE BuyerID = '$BuyerID'";
		
		if(mysqli_query($conn, $query)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Buyer Phone Updated</h1></body>';
									
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&BuyerID=".$BuyerID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}		
		break;
	case BuyerComments:
		$newBuyerComments = trim($_POST['newBuyerComments']);
		$BuyerID = trim($_POST['BuyerID']);			
		
		$query = "UPDATE Buyer SET Comments = '$newBuyerComments' WHERE BuyerID = '$BuyerID'";
		
		if(mysqli_query($conn, $query)){
			echo '<html><title>Information Updated</title>';
			echo '<head><link rel="stylesheet" href="style.css"></head>';
			echo '<body><h1>Buyer Comments Updated</h1></body>';
									
			echo "<body><h3> <a href=\"edit.php?edit=".$editValue."&BuyerID=".$BuyerID."\">Back</a> </h3></body>";
			echo '</html>';			
		}
		else{
			echo mysql_error();
		}	
		break;	
}
?>
