<?php
session_start();
include ("code.inc");
//$con = mysql_connect($serverhost,$account,$key);
//if (!$con)
//	{  die('Could not connect: ' . mysql_error());
//	}
		
$con=mysqli_connect($serverhost, $account, $key, "vmcloud");
// Check connection
if (mysqli_connect_error())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}	

//mysqli_select_db("vmcloud", $con);

$query = "UPDATE logins SET Name = 'Eric' WHERE EMail = 'jim@rontoe.com'";
$result = mysqli_query($con, $query);
echo "Done";
?>