<?php
session_start();
echo "<head>";
echo "<link rel='stylesheet' type='text/css' href='style.css'>";
echo "<link rel='stylesheet' href='https://pro.fontawesome.com/releases/v5.5.0/css/all.css' integrity='sha384-j8y0ITrvFafF4EkV1mPW0BKm6dp3c+J9Fky22Man50Ofxo2wNe5pT1oZejDH9/Dt' crossorigin='anonymous'>";
echo "<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>";
echo "<link href='https://fonts.googleapis.com/css?family=Rubik' rel='stylesheet'>";
echo "<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>"; 
echo "<link href='https://fonts.googleapis.com/css?family=Biryani:200|Cabin' rel='stylesheet'> ";
?>
<title>Cloud</title>
<script type="text/javascript">
function showForm (paraone, type) {
	if (type === "Power") {
	document.getElementById("power").style.display = "block";
	document.getElementById("reboot").style.display = "none";
	document.getElementById("snapshot").style.display = "none";				
	document.getElementById("hostname").value = paraone;		
	document.getElementById("hostnamepow").innerHTML = paraone;	
	}
	if (type === "Reboot") {
	document.getElementById("power").style.display = "none";
	document.getElementById("reboot").style.display = "block";
	document.getElementById("snapshot").style.display = "none";	
	document.getElementById("hostname").value = paraone;		
	document.getElementById("hostnamereb").innerHTML = paraone;		
	}
	if (type === "Snapshot") {
	document.getElementById("power").style.display = "none";
	document.getElementById("reboot").style.display = "none";
	document.getElementById("snapshot").style.display = "block";
	document.getElementById("hostname").value = paraone;		
	document.getElementById("hostnamesnap").innerHTML = paraone;		
	}	
}	

</script>
<body>
<?php include ("header.php"); ?>
<p>
<center>
<?php
if (isset($_POST['search'])) $searchreq = $_POST['search'];
else $searchreq = NULL;
if (isset($_POST['hostname'])) $hostname = $_POST['hostname'];
else $hostname = NULL;

if (isset($_POST['type'])) {
	$type = $_POST['type'];
	if ($type == 'power') $msg = $hostname . " has been powered on!";
	if ($type == 'reboot') $msg = $hostname . " is rebooting!";	
	if ($type == 'snapshot') $msg = $hostname . " is taking a snapshot!";				
}

$date = date("Y/m/d");
echo "<div class='vmlistheadcontainer'>";
if (isset($_SESSION['SESS_NAME'])) {
	echo "<div class='vmlistheadbig'>" . $_SESSION['SESS_NAME'] . "</div>";
	echo "<div class='vmlistheadsmall'>" . $_SESSION['SESS_EMAIL'] . " - " . $date . " - Other Info</div>";	
}
else {
	echo "<div class='vmlistheadbig'>&nbsp;</div>";
	echo "<div class='vmlistheadsmall'>&nbsp;</div>";
}
echo "</div>";
if (isset($_POST['type'])) echo "<div class='msgbar'>" . $msg . "</div>";
echo "<p>";
if (isset($searchreq)) {
	$query = "SELECT v.ID, v.Hostname, h.Host, l.Name, v.Status, v.IP, v.OS, v.Platform FROM vm as v
			INNER JOIN hosts as h on v.Host = h.ID
			INNER JOIN logins as l on v.Owner = l.ID
			WHERE v.Hostname LIKE '%$searchreq%'
			ORDER BY v.Hostname ASC";
	$request = mysqli_query($con, $query) or die("Could not connect : " . mysqli_error()); ;
	$searchflag = 1;
	$fetchrows = mysqli_num_rows($request);
	if ($searchflag == 1 && $fetchrows == 0) echo "No Results Found.  Please try again";
	}
if (!isset($searchreq)) {
	$query = "SELECT v.ID, v.Hostname, h.Host, l.Name, v.Status, v.IP, v.OS, v.Platform FROM vm as v
			INNER JOIN hosts as h on v.Host = h.ID
			INNER JOIN logins as l on v.Owner = l.ID
			ORDER BY v.Hostname ASC";
	$request = mysqli_query($con, $query) or die("Could not connect: " . mysqli_error()); ;
}
	while($row = mysqli_fetch_array($request)) {
		$hostname = $row['Hostname'];
		$id = $row['ID'];
echo "<div class='entrycontainer'>";
	echo "<div class='entryhostname'>";
		echo "<div class='entryhostnamehead'>";
			echo "Server";
		echo "</div>";
		echo "<div class='entryhostnameinfo'>";
			if ($row['Status'] == "On") echo "<img src='green.png' class='coloricon'>&nbsp;";
			if ($row['Status'] == "Suspended") echo "<img src='yellow.png' class='coloricon'>&nbsp;";
			if ($row['Status'] == "Off") echo "<img src='red.png' class='coloricon'>&nbsp;";		
			echo "<form id='server' method='post' action='vm.php'>";
			echo "<input type='hidden' name='vmid' value='" . $id ."'>";
			echo "<a href='javascript:;'' onclick='this.parentNode.submit().submit'>" . $row['Hostname'] . ".rontoe.com</a></form>";
		echo "</div>";				
	echo "</div>";
	echo "<div class='entryhostserver'>";	
		echo "<div class='entryhostserverhead'>";
			echo "Host";
		echo "</div>";		
		echo "<div class='entryhostserverinfo'>";
				echo $row['Host'];
		echo "</div>";	
	echo "</div>";
	echo "<div class='entryhostserver'>";	
		echo "<div class='entryhostserverhead'>";
			echo "IP";
		echo "</div>";		
		echo "<div class='entryhostserverinfo'>";
				echo $row['IP'];
		echo "</div>";	
	echo "</div>";	
	echo "<div class='entryhostserver'>";	
		echo "<div class='entryhostserverhead'>";
			echo "OS";
		echo "</div>";		
		echo "<div class='entryhostserverinfo'>";
		if ($row['Platform'] == "Windows") 	echo "Win " . $row['OS'] . "<img src='windows.png' height=15px>";
		if ($row['Platform'] == "Linux") 	echo $row['OS'] . "<img src='linux.png' height=15px>";		
		echo "</div>";	
	echo "</div>";		
	echo "<div class='entryhostserver'>";	
		echo "<div class='entryhostserverhead'>";
			echo "Owner";
		echo "</div>";		
		echo "<div class='entryhostserverinfo' style='border-right: 0px;'>";
				echo $row['Name'];
		echo "</div>";	
	echo "</div>";	
	echo "<div class='icon'><a href='#' onclick=\"showForm('$hostname', 'Reboot')\"><img src='reboot.png' title='Reboot'></a></div>";
	echo "<div class='icon'><a href='#' onclick=\"showForm('$hostname', 'Snapshot')\"><img src='snapshot.png' title='Take Snapshot'></a></div>";
	echo "<div class='icon'><a href='#' onclick=\"showForm('$hostname', 'Power')\"><img src='power.png' title='Power On/Off'></a></div>";		
			
echo "</div>";
	}

/* ORIGINAL	
echo "<div id='power' class='popupbox'>";
	echo "<form class='popup-content-dialog animate' name='power' method='POST' action='vmlist.php' onsubmit='return showForm(this)'>";
	echo "<div class='popup-content-title'>";
		echo "<div class='popup-title-header'>Are you sure you want to power on/off <span id='hostnamepow' class='dialog-head'></span>?</div>";
		echo "<div class='closeimage'>";
		echo "<img src='redx.png' height=25px onclick=\"document.getElementById('power').style.display='none'\">";
		echo "</div>";	
	echo "</div>";
	echo "<input type='hidden' id='hostname' name='hostname' value='" . $hostname . "'>";
	echo "<input type='hidden' name='type' value='power'>";			
	echo "<button type='submit' class='yes' value='YES'><img src='greencheck.png'>&nbsp;&nbsp;<span>YES</span></button>";
	echo "<button type='reset' class='no' onclick=\"document.getElementById('power').style.display='none'\"><img src='redx.png'>&nbsp;&nbsp;NO</button>";	
echo "</form></div>";	
*/

echo "<div id='power' class='popupbox'>";
	echo "<form class='popupvm-content-dialog animate' name='power' method='POST' action='' onsubmit='return showForm(this)'>";
	echo "<div class='popupvm-content-title'>";
		echo "<div class='popupvm-content-title-left'>Confirm Power On</div>";
		echo "<div class='popupvm-content-title-right'><span id='hostnamepow' class='dialog-head'></span></div>";
	echo "</div>";
	echo "<div class='popupvm-content-details'><img src='exclamation.png'>Are you sure you want to power on this virtual server?</div>";	
	echo "<div class='popupvm-content-yesno'>";	
	echo "<input type='hidden' id='hostname' name='hostname' value='" . $hostname . "'>";
	echo "<input type='hidden' name='type' value='power'>";	
	echo "<input type='hidden' name='vmid' value='" . $vmid . "'>";			
	echo "<button type='submit' class='yes' value='YES'><span>YES</span></button>";
	echo "<button type='reset' class='no' onclick=\"document.getElementById('power').style.display='none'\">NO</button>";
	echo "</div>";	
echo "</form></div>";

/*
ORIGINAL
echo "<div id='reboot' class='popupbox'>";
	echo "<form class='popup-content-dialog animate' name='power' method='POST' action='vmlist.php' onsubmit='return showForm(this)'>";
	echo "<div class='popup-content-title'>";
		echo "<div class='popup-title-header'>Are you sure you want to reboot <span id='hostnamereb' class='dialog-head'></span>?</div>";
		echo "<div class='closeimage'>";
		echo "<img src='redx.png' height=25px onclick=\"document.getElementById('reboot').style.display='none'\">";
		echo "</div>";	
	echo "</div>";
	echo "<input type='hidden' id='hostname' name='hostname' value='" . $hostname . "'>";
	echo "<input type='hidden' name='type' value='reboot'>";			
	echo "<button type='submit' class='yes' value='YES'><img src='greencheck.png'>&nbsp;&nbsp;<span>YES</span></button>";
	echo "<button type='reset' class='no' onclick=\"document.getElementById('reboot').style.display='none'\"><img src='redx.png'>&nbsp;&nbsp;NO</button>";	
echo "</form></div>";
*/

echo "<div id='reboot' class='popupbox'>";
	echo "<form class='popupvm-content-dialog animate' name='reboot' method='POST' action='' onsubmit='return showForm(this)'>";
	echo "<div class='popupvm-content-title'>";
		echo "<div class='popupvm-content-title-left'>Confirm Reboot</div>";
		echo "<div class='popupvm-content-title-right'><span id='hostnamereb' class='dialog-head'></span></div>";
	echo "</div>";
	echo "<div class='popupvm-content-details'><img src='exclamation.png'>Are you sure you want to reboot this virtual server?</div>";	
	echo "<div class='popupvm-content-yesno'>";	
	echo "<input type='hidden' id='hostname' name='hostname' value='" . $hostname . "'>";
	echo "<input type='hidden' name='type' value='reboot'>";	
	echo "<input type='hidden' name='vmid' value='" . $vmid . "'>";			
	echo "<button type='submit' class='yes' value='YES'><span>YES</span></button>";
	echo "<button type='reset' class='no' onclick=\"document.getElementById('reboot').style.display='none'\">NO</button>";
	echo "</div>";	
echo "</form></div>";

/*
ORIGINAL
echo "<div id='snapshot' class='popupbox'>";
	echo "<form class='popup-content-dialog animate' name='power' method='POST' action='vmlist.php' onsubmit='return showForm(this)'>";
	echo "<div class='popup-content-title'>";
		echo "<div class='popup-title-header'>Are you sure you want to take a snapshot for <span id='hostnamesnap' class='dialog-head'></span>?</div>";
		echo "<div class='closeimage'>";
		echo "<img src='redx.png' height=25px onclick=\"document.getElementById('snapshot').style.display='none'\">";
		echo "</div>";	
	echo "</div>";
	echo "<input type='hidden' id='hostname' name='hostname' value='" . $hostname . "'>";
	echo "<input type='hidden' name='type' value='snapshot'>";			
	echo "<button type='submit' class='yes' value='YES'><img src='greencheck.png'>&nbsp;&nbsp;<span>YES</span></button>";
	echo "<button type='reset' class='no' onclick=\"document.getElementById('snapshot').style.display='none'\"><img src='redx.png'>&nbsp;&nbsp;NO</button>";	
echo "</form></div>";
*/
		
echo "<div id='snapshot' class='popupbox'>";
echo "<form class='popupvm-content-dialog animate' name='snapshot' method='POST' action='' onsubmit='return showForm(this)'>";
	echo "<div class='popupvm-content-title'>";
		echo "<div class='popupvm-content-title-left'>Confirm Take Snapshot</div>";
		echo "<div class='popupvm-content-title-right'><span id='hostnamesnap' class='dialog-head'></span></div>";
	echo "</div>";
	echo "<div class='popupvm-content-details'><img src='exclamation.png'>Are you sure you want to take a snapshot of this virtual server?</div>";	
	echo "<div class='popupvm-content-yesno'>";	
	echo "<input type='hidden' id='hostname' name='hostname' value='" . $hostname . "'>";
	echo "<input type='hidden' name='type' value='snapshot'>";	
	echo "<input type='hidden' name='vmid' value='" . $vmid . "'>";			
	echo "<button type='submit' class='yes' value='YES'><span>YES</span></button>";
	echo "<button type='reset' class='no' onclick=\"document.getElementById('snapshot').style.display='none'\">NO</button>";
	echo "</div>";	
echo "</form></div>";		
?>
</center>
</body>
</head>
</html>