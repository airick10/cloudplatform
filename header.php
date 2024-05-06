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

echo "<div class='headerbar'>";
	echo "<div class='headerleft' style='border-bottom:0px; width:15%;'>";
		echo "<form method='post' action='vmlist.php'>";	
		echo "<img src='magnify.png' width='15px'>&nbsp;<input type='text' name='search' placeholder='Search VM'>";
		echo "<input type='submit' value='Go'></form>";
	echo "</div>";
	echo "<div class='headerleft'>";
		echo "<a href='vmlist.php'>VM List</a>";
	echo "</div>";
	echo "<div class='headerleft'>";
		echo "<a href='hostlist.php'>Host List</a>";
	echo "</div>";
	echo "<div class='headercenter'>";
		echo "<a href='http://www.rontoe.com/cloud/'><img src='cloud_icon.png'></a>";
	echo "</div>";		
	echo "<div class='headerright'>";
		echo "<a href='create.php'>New VM</a>";
	echo "</div>";
	echo "<div class='headerright'>";
		echo "<a href='support.php'>Support</a>";
	echo "</div>";	
	echo "<div class='headerright'>";
	if (isset ($_SESSION['SESS_NAME'])) echo "<a href='panel.php'>". $_SESSION['SESS_NAME'] . "</a> - <a href='logout.php'>Logoff</a>";
	else echo "<a href='#' onclick=\"document.getElementById('loginnew').style.display='block'\" style='width:auto;'>Login</a>";
	echo "</div>";						
echo "</div>";
echo "<center><div id='loginnew' class='popupbox'>";
	echo "<form class='loginbox animate' method='POST' action='login-exec.php'>";
	echo "<div class='logincontent'>";
		echo "<div class='logintitle'><div class='loginsignin'>SIGN IN</div>";
			echo "<div class='logcloseimage'>";
			echo "<img src='redx.png' height=15px onclick=\"document.getElementById('loginnew').style.display='none'\">";
			echo "</div>";
		echo "</div>";
		echo "<div class='loginbody'>";
			echo "<input id='user' placeholder='User Name' type='text'>";
			echo "<input id='password' placeholder='Password' type='password'>";
		echo "</div>";
		echo "<div class='loginfooter'>";
			echo "<button id='buttonsub' type='button'>Sign In</button>";
		echo "</div>";
	echo "</div></form>";
echo "</div></center>";
?>