<?php
echo "<head>";
echo "<link rel='stylesheet' type='text/css' href='style.css'>";
echo "<link rel='stylesheet' href='https://pro.fontawesome.com/releases/v5.5.0/css/all.css' integrity='sha384-j8y0ITrvFafF4EkV1mPW0BKm6dp3c+J9Fky22Man50Ofxo2wNe5pT1oZejDH9/Dt' crossorigin='anonymous'>";
echo "<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>";
echo "<link href='https://fonts.googleapis.com/css?family=Rubik' rel='stylesheet'>";
echo "<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>"; 
echo "<link href='https://fonts.googleapis.com/css?family=Biryani:200|Cabin' rel='stylesheet'> ";
?>
<title>Cloud</title>
<body>
<?php include ("header.php");
echo "<p>";
echo "<center>";
echo "<div class='vmhostheader'>";
	echo "<div class='vmhostheadergeneric' style='width:150px;'>Host</div>";
	echo "<div class='vmhostheadergeneric'>Version</div>";
	echo "<div class='vmhostheadergeneric'>VMs</div>";
	echo "<div class='vmhostheadergeneric'>CPU</div>";
	echo "<div class='vmhostheadergeneric'>RAM</div>";	
	echo "<div class='vmhostheadergeneric'>RAM Used</div>";
	echo "<div class='vmhostheadergeneric'>RAM Usage</div>";
echo "</div>";
$query = "SELECT * FROM hosts";			
$request = mysqli_query($con, $query) or die("Could not connect : " . mysqli_error()); ;
	while($row = mysqli_fetch_array($request)) {				
echo "<div class='vmhostcontainer'>";
	echo "<div class='vmhostname'>";
	if ($row['Status'] == "On") { 
		echo "<div class='vmhostinfo'><img src='green.png' class='coloricon'>";
		echo "<form id='host' method='post' action='host.php'>";
		echo "<input type='hidden' name='hostname' value='" . $row['ID'] ."'>";
		echo "&nbsp;<a href='javascript:;'' onclick='this.parentNode.submit().submit'>" . $row['Host'] . "</a></form></div>";
		echo "<div class='vmhostip'>" . $row['IP'] . "</div>";
	}
	if ($row['Status'] == "Suspended")  { 
		echo "<div class='vmhostinfo'><img src='yellow.png' class='coloricon'>";
		echo "<form id='host' method='post' action='host.php'>";
		echo "<input type='hidden' name='hostname' value='" . $row['ID'] ."'>";
		echo "&nbsp;<a href='javascript:;'' onclick='this.parentNode.submit().submit'>" . $row['Host'] . "</a></form></div>";
		echo "<div class='vmhostip'>" . $row['IP'] . "</div>";
		}
	if ($row['Status'] == "Off")  { 
		echo "<div class='vmhostinfo'><img src='red.png' class='coloricon'>";
		echo "<form id='host' method='post' action='host.php'>";
		echo "<input type='hidden' name='hostname' value='" . $row['ID'] ."'>";
		echo "&nbsp;<a href='javascript:;'' onclick='this.parentNode.submit().submit'>" . $row['Host'] . "</a></form></div>";
		echo "<div class='vmhostip'>" . $row['IP'] . "</div>";
		}	
	echo "</div>";
	echo "<div class='vmhostgeneric'>" . $row['Version'] . "</div>";
	echo "<div class='vmhostgeneric'>55</div>";	
	echo "<div class='vmhostgeneric'>" . $row['CPU'] . "</div>";
	echo "<div class='vmhostgeneric'>" . $row['RAM'] . " GB</div>";	
	$number = $row['RAM Used'] /$row['RAM'];
	$usage = $number * 100;
	$usage = round($usage); 
	$percent = $usage . "%";
	echo "<div class='vmhostgeneric'>" . $percent . "</div>";	
	echo "<div class='statbox'>";
		if ($usage > 85) 
		echo "<div class='statlabel' style='width:" . $percent . "; background: -webkit-linear-gradient(left, white, red 75%);'>&nbsp;</div>";
		if ($usage > 75 && $usage < 86) 
		echo "<div class='statlabel' style='width:" . $percent . "; background:-webkit-linear-gradient(left, white, orange 75%)'>&nbsp;</div>";
		if ($usage < 76) 
		echo "<div class='statlabel' style='width:" . $percent . "; background:-webkit-linear-gradient(left, white, green 75%)'>&nbsp;</div>";		
		echo "</div>";		
echo "</div>";
	}
echo "</center>";
	




?>
</body>
</head>
</html>