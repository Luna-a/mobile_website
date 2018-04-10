<?php
function GetConnection($DBUser, $DBpass, $DBHost, $DBname)
{
	$conn = mysqli_connect($DBHost,$DBUser,$DBpass, $DBname);
	if(!$conn)
	{
           echo mysqli_error();
         #  echo "Error: Unable to connect to MySQL." . PHP_EOL;
         #  echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
         #  echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
           exit;
	}

	return $conn;
}
?>