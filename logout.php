<?php
	//Start session
	session_start();
	echo "<head>";
	echo "<link rel='stylesheet' type='text/css' href='style.css'>";
	echo "<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>";
	echo "<link href='https://fonts.googleapis.com/css?family=Rubik' rel='stylesheet'>";
	echo "<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>"; 
	echo "<link href='https://fonts.googleapis.com/css?family=Biryani:200|Cabin' rel='stylesheet'> ";

	//Unset the variables stored in session
	unset($_SESSION['SESS_NAME']);
	unset($_SESSION['SESS_EMAIL']);
	unset($_SESSION['SESS_DATE']);

	include ("header.php");	
?>
<html>
<head>
<title>Cloud</title>
</head>
<body>
<h4 align="center">You have been logged out.</h4>
</body>
</html>
