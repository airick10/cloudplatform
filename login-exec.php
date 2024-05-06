<?php
	//Start session
	session_start();

	//Include database connection details
	include ("code.inc");

	//Array to store validation errors
	$errmsg_arr = array();

	//Validation error flag
	$errflag = false;

	//Connect to mysql server
	$con = mysql_connect($serverhost,$account,$key);
	if (!$con)
{
die('Could not connect: ' . mysql_error());
}

	//Select database
	mysql_select_db("vmcloud", $con);

	//Function to sanitize values received from the form. Prevents SQL injection
	//function clean($str) {
	//	$str = @trim($str);
	//	if(get_magic_quotes_gpc()) {
	//		$str = stripslashes($str);
	//	}
	//	return mysql_real_escape_string($str);
	//}

	//Sanitize the POST values
	$login = $_POST['username'];
	$password = $_POST['password'];

	//Input Validations
	if($login == '') {
		$errmsg_arr[] = 'Login ID missing';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
	}

	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: http://www.rontoe.com/cloud");
		exit();
	}

	//Create query
	$qry="SELECT * FROM logins WHERE Name='$login' AND Pass='$password'";
	$result=mysql_query($qry) or die ("Error in query: $query. ".mysql_error());

	//Check whether the query was successful or not
	if($result) {
		if(mysql_num_rows($result) == 1) {
			//Login Successful
			session_regenerate_id();
			$member = mysql_fetch_array($result);
			$date = date("Y-m-d H:i:s");
			$name = $member['Name'];			
			$_SESSION['SESS_NAME'] = $member['Name'];
			$_SESSION['SESS_EMAIL'] = $member['EMail'];
			$_SESSION['SESS_DATE'] = $date;
			session_write_close();
			mysql_query("UPDATE logins SET LoginDate = '$date' WHERE Name = '$name'");
			header("location: http://www.rontoe.com/cloud");
			exit();
		}else {
			//Login failed
			header("location: login-failed.php");
			exit();
		}
	}else {
		die("Query failed");
	}
?>