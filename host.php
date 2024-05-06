<?php
session_start();
echo "<head>";
echo "<script src='jquery-3.4.1.min.js'></script>";
echo "<link rel='stylesheet' type='text/css' href='style.css'>";
echo "<link rel='stylesheet' href='https://pro.fontawesome.com/releases/v5.5.0/css/all.css' integrity='sha384-j8y0ITrvFafF4EkV1mPW0BKm6dp3c+J9Fky22Man50Ofxo2wNe5pT1oZejDH9/Dt' crossorigin='anonymous'>";
echo "<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>";
echo "<link href='https://fonts.googleapis.com/css?family=Rubik' rel='stylesheet'>";
echo "<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>"; 
echo "<link href='https://fonts.googleapis.com/css?family=Biryani:200|Cabin' rel='stylesheet'> ";
?>
<title>Cloud</title>
<script language="javascript">
$(document).ready(function(){
	$('button#toggleVMs').click(function(){
		$('#hostvms').toggle();
	});
	$('button.hostbutton').click(function(){
		var trueid = (this.id);
		var btnval = $(this).val();
		//$('.popupbox').hide();
		$('#hostname').val(btnval);
		$('#hostnamepow').val(btnval);
		if (trueid == "btnpower") {
			$('#power').show();
		}
		else if (trueid == "btnmaintenance") {
			$('#maint').show();
		}	
		else if (trueid == "btnrecycle") {
			$('#recycle').show();
		}
		else if (trueid == "btndelete") {
			$('#delete').show();
		}
		else {
			$('.popupbox').hide();
		}
	});
});

function showForm (paraone, type) {
	//if (type === "Power") {
	//document.getElementById("power").style.display = "block";
	//document.getElementById("maint").style.display = "none";
	//document.getElementById("recycle").style.display = "none";
	//document.getElementById("delete").style.display = "none";				
	//document.getElementById("hostname").value = paraone;		
	//document.getElementById("hostnamepow").innerHTML = paraone;		
	//}
	if (type === "Maintenance") {
	document.getElementById("power").style.display = "none";
	document.getElementById("maint").style.display = "block";
	document.getElementById("recycle").style.display = "none";
	document.getElementById("delete").style.display = "none";	
	document.getElementById("hostname").value = paraone;		
	document.getElementById("hostnamemain").innerHTML = paraone;	
	}
	if (type === "Recycle") {
	document.getElementById("power").style.display = "none";
	document.getElementById("maint").style.display = "none";
	document.getElementById("recycle").style.display = "block";
	document.getElementById("delete").style.display = "none";	
	document.getElementById("hostname").value = paraone;		
	document.getElementById("hostnamerec").innerHTML = paraone;	
	}
	if (type === "Delete") {
	document.getElementById("power").style.display = "none";
	document.getElementById("maint").style.display = "none";
	document.getElementById("recycle").style.display = "none";
	document.getElementById("delete").style.display = "block";
	document.getElementById("hostname").value = paraone;		
	document.getElementById("hostnamedel").innerHTML = paraone;		
	}				
}	

function load() {
	document.getElementById("loading").style.display = "block";
	document.getElementById("loadpic").style.display = "block";
	setTimeout(stopspin, 3000);
}
function stopspin() {
	document.getElementById("loading").style.display = "none";
	document.getElementById("loadpic").style.display = "none";
}
</script>
<body>
<?php include ("header.php"); ?>
<p>
<center>
<?php
if (isset($_POST['strhost'])) $hostname = $_POST['strhost'];
else $hostname = NULL;
if (isset($_POST['hostname'])) $id = $_POST['hostname'];
else $id = NULL;
if (isset($_POST['type'])) {
	$type = $_POST['type'];
	if ($type == 'power') $msg = $hostname . " has been powered on!";
	if ($type == 'maint') $msg = $hostname . " is being set into Maintenance Mode!";	
	if ($type == 'recycle') $msg = $hostname . " services are being recycled!";		
	if ($type == 'delete') $msg = $hostname . " is being deleted!";		
}




$date = date("Y/m/d");
if (isset($_POST['type'])) echo "<center><div class='msgbar'>" . $msg . "</div></center>";
echo "<div class='hostentrycontainer'>";
$query = "SELECT * FROM hosts WHERE ID ='$id'";
$request = mysqli_query($con, $query) or die("Could not connect : " . mysqli_error()); ;
	while($row = mysqli_fetch_array($request)) {
		$hostname = $row['Host'];
	echo "<div class='hostleft'>";
		echo "<button class='hostbutton' id='btnpower' value='" . $hostname . "'><img src='power.png' title='Power On/Off'></button>";
		echo "<button class='hostbutton' id='btnmaintenance' value='" . $hostname . "'><img src='oil.png' title='Maintanance'></button>";
		echo "<button class='hostbutton' id='btnrecycle' value='" . $hostname . "'><img src='gear.png' title='Restart Services'></button>";
		echo "<button class='hostbutton' id='btndelete' value='" . $hostname . "'><img src='delete.png' title='Remove Host'></button>";
		//echo "<button class='hostbutton' onclick=\"showForm('$hostname', 'Maintenance')\"><img src='oil.png' title='Maintanance Mode'></button>";
		//echo "<button class='hostbutton' onclick=\"showForm('$hostname', 'Recycle')\"><img src='gear.png' title='Restart Services'></button>";
		//echo "<button class='hostbutton' onclick=\"showForm('$hostname', 'Delete')\"><img src='delete.png' title='Remove Host'></button>";						
	echo "</div>";
	echo "<div class='hostright'>";
		echo "<div class='hostdetails'>";
			echo $row['Host'] . "<p>";
			echo "<div class='hostdetailslineleft'>Status:</div><div class='hostdetailslineright'>" . $row['Status'] . "</div>";	
			echo "<div class='hostdetailslineleft'>Version:</div><div class='hostdetailslineright'>" . $row['Version'] . "</div>";
			echo "<div class='hostdetailslineleft'>IP Address:</div><div class='hostdetailslineright'>" . $row['IP'] . "</div>";	
			echo "<div class='hostdetailslineleft'>Num of VMs:</div><div class='hostdetailslineright'>12</div>";					
		echo "</div>";
		echo "<div class='hostspecs'>";
			echo "Specifications<p>";
			echo "<div class='hostdetailslineleft'>CPU:</div><div class='hostdetailslineright'>" . $row['CPU'] . "</div>";	
			echo "<div class='hostdetailslineleft'>RAM:</div><div class='hostdetailslineright'>" . $row['RAM'] . " GB</div>";
			echo "<div class='hostdetailslineleft'>RAM Used:</div><div class='hostdetailslineright'>" . $row['RAM Used'] . " GB</div>";		
		echo "</div>";		
	echo "</div>";
}
echo "</div>";
echo "<p>";

echo "<button id='toggleVMs'>Show VMs</button><p>";
echo "</center><p><p>";
echo "<center>";
echo "<div class='hostvms' id='hostvms'>";
$queryb = "SELECT v.Hostname, v.Status, v.IP, v.Platform FROM vm as v
			INNER JOIN hosts as h on v.Host = h.ID 
			WHERE v.Host = '$id' ORDER BY v.Hostname ASC";
$request = mysqli_query($con, $queryb) or die("Could not connect : " . mysqli_error()); ;
	while($row = mysqli_fetch_array($request)) {

	echo "<div class='hostpagevmwrap'>";
		echo "<div class='hostpagevmsection'>" . $row['Hostname'] . "</div>";
		echo "<div class='hostpagevmsection'>" . $row['Status'] . "</div>";				
		echo "<div class='hostpagevmsection'>" . $row['IP'] . "</div>";
		echo "<div class='hostpagevmsection'>" . $row['Platform'] . " " . $row['OS'] . "</div>";	
		echo "<div class='hostpagevmbtn'><img src='reboot.png' title='Reboot'></div>";			
		echo "<div class='hostpagevmbtn'><img src='power.png' title='Power On/Off'></div>";	
	echo "</div>";	
	}	
echo "</div>";

echo "<div id='power' class='popupbox'>";
	echo "<form class='popupvm-content-dialog animate' name='power' method='POST' action='host.php' onsubmit='return showForm(this)'>";
	echo "<div class='popupvm-content-title'>";
		echo "<div class='popupvm-content-title-left'>Confirm Power On</div>";
		echo "<div class='popupvm-content-title-right'><span id='hostnamepow' class='dialog-head'></span></div>";
	echo "</div>";	
	echo "<div class='popupvm-content-details'><img src='exclamation.png'>Are you sure you want to power on this host?</div>";	
	echo "<div class='popupvm-content-yesno'>";		
	echo "<input type='hidden' id='hostname' name='hostname' value='" . $id . "'>";
	echo "<input type='hidden' name='type' value='power'>";	
	echo "<input type='hidden' name='strhost' value='" . $hostname . "'>";			
	echo "<button type='submit' class='yes' onclick='load()'><span>YES</span></button>";
	echo "<button type='reset' class='no' onclick=\"document.getElementById('power').style.display='none'\">NO</button>";
	echo "</div>";	
echo "</form></div>";	


echo "<div id='maint' class='popupbox'>";
	echo "<form class='popupvm-content-dialog animate' name='maint' method='POST' action='host.php' onsubmit='return showForm(this)'>";
	echo "<div class='popupvm-content-title'>";
		echo "<div class='popupvm-content-title-left'>Confirm Maintanance Mode</div>";
		echo "<div class='popupvm-content-title-right'><span id='hostnamemain' class='dialog-head'></span></div>";
	echo "</div>";
	echo "<div class='popupvm-content-details'><img src='exclamation.png'>Are you sure you want to set this to maintanance mode?</div>";			
	echo "<div class='popupvm-content-yesno'>";		
	echo "<input type='hidden' id='hostname' name='hostname' value='" . $id . "'>";
	echo "<input type='hidden' name='type' value='maint'>";
	echo "<input type='hidden' name='strhost' value='" . $hostname . "'>";				
	echo "<button type='submit' class='yes' onclick='load()'><span>YES</span></button>";
	echo "<button type='reset' class='no' onclick=\"document.getElementById('maint').style.display='none'\">NO</button>";
	echo "</div>";	
echo "</form></div>";		

echo "<div id='recycle' class='popupbox'>";
	echo "<form class='popupvm-content-dialog animate' name='recycle' id='recycleform' method='POST' action='host.php' onsubmit='return showForm(this)'>";
	echo "<div class='popupvm-content-title'>";
		echo "<div class='popupvm-content-title-left'>Confirm Recycle Services</div>";
		echo "<div class='popupvm-content-title-right'><span id='hostnamerec' class='dialog-head'></span></div>";
	echo "</div>";
	echo "<div class='popupvm-content-details'><img src='exclamation.png'>Are you sure you want to recycle the services?</div>";		
	echo "<div class='popupvm-content-yesno'>";		
	echo "<input type='hidden' id='hostname' name='hostname' value='" . $id . "'>";
	echo "<input type='hidden' name='type' value='recycle'>";	
	echo "<input type='hidden' name='strhost' value='" . $hostname . "'>";				
	echo "<button type='submit' class='yes' onclick='load()'><span>YES</span></button>";
	echo "<button type='reset' class='no' onclick=\"document.getElementById('recycle').style.display='none'\">NO</button>";
	echo "</div>";
echo "</form></div>";

echo "<div id='delete' class='popupbox'>";
	echo "<form class='popupvm-content-dialog animate' name='delete' method='POST' action='host.php' onsubmit='return showForm(this)'>";
	echo "<div class='popupvm-content-title'>";
		echo "<div class='popupvm-content-title-left'>Confirm Delete</div>";
		echo "<div class='popupvm-content-title-right'><span id='hostnamedel' class='dialog-head'></span></div>";
	echo "</div>";
	echo "<div class='popupvm-content-details'><img src='exclamation.png'>Are you sure you want to delete this host?</div>";		
	echo "<div class='popupvm-content-yesno'>";		
	echo "<input type='hidden' id='hostname' name='hostname' value='" . $id . "'>";
	echo "<input type='hidden' name='type' value='delete'>";	
	echo "<input type='hidden' name='strhost' value='" . $hostname . "'>";			
	echo "<button type='submit' class='yes' onclick='load()'><span>YES</span></button>";
	echo "<button type='reset' class='no' onclick=\"document.getElementById('delete').style.display='none'\">NO</button>";
	echo "</div>";
echo "</form></div>";
echo "<div class='loading' id='loading'><span class='spinner' id='loadpic'></span></div>";
echo "</center>";
?>
</center>
</body>
</head>
</html>