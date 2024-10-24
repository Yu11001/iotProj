<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Coin Saver Project</title>
<style type="text/css">
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: small;
}
</style>
</head>

<body>
<?php
date_default_timezone_set("Asia/Bangkok");
require "connection.php";  // Include your database connection file
error_reporting(error_reporting() & ~E_NOTICE);  // Only show necessary error messages

echo "Processing data...<br>";

// Capture current time
$cknow = date("Y-m-d H:i:s");

// Check if the required GET parameters are present
if (isset($_GET["b1"]) && isset($_GET["b5"]) && isset($_GET["b10"]) && isset($_GET["total"])) {
	// Prepare the SQL query
	$sql = "INSERT INTO project (b1, b5, b10, total, time)
	VALUES ('" . $_GET["b1"] . "', '" . $_GET["b5"] . "', '" . $_GET["b10"] . "', '" . $_GET["total"] . "', '" . $cknow . "')";

	// Execute the query
	if (mysqli_query($conn, $sql)) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
} else {
	echo "Error: Missing required parameters (b1, b5, b10, total)";
}

// Close the database connection
mysqli_close($conn);
?>
</body>
</html>
