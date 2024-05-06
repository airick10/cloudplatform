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

<script type="text/javascript">
$(document).ready(function(){
	$('button#toggleVMs').click(function(){
		$('#hostvms').toggle();
	});
	$('button.actionboxleft,button.actionboxright').click(function(){
		var trueid = (this.id);
		var btnval = $(this).val();
		var btnary = btnval.split(",");
		$('#hostname').val(btnary[0]);
		$('#status').val(btnary[1]);
		if (trueid == "btnpower") {
			$('#power').show();
			$('#hostnamepow').text(btnary[0]);
		}
		else if (trueid == "btnreboot") {
			$('#reboot').show();
			$('#hostnamereb').text(btnary[0]);
		}	
		else if (trueid == "btnram") {
			$('#ram').show();
			$('#hostnameram').text(btnary[0]);
		}
		else if (trueid == "btncpu") {
			$('#cpu').show();
			$('#hostnamecpu').text(btnary[0]);
		}	
		else if (trueid == "btnmigrate") {
			$('#migrate').show();
			$('#hostnamemig').text(btnary[0]);
		}
		else if (trueid == "btndelete") {
			$('#delete').show();
			$(')#hostnamedel').text(btnary[0]);
		}
		else {
			$('.popupbox').hide();
		}
	});
	$('a#snapshotlink').click(function(){
			$('#snapshotsid').toggle();
		});
});

</script>
<body>
<?php include ("header.php"); 
if (isset($_POST['vmid'])) $vmid = $_POST['vmid'];
else $vmid = NULL;
if (isset($_POST['hostname'])) $hostname = $_POST['hostname'];
else $hostname = NULL;
if (isset($_POST['snapshotselect'])) $snapshot = $_POST['snapshotselect'];

if (isset($_POST['type'])) {
	$type = $_POST['type'];
	if ($type == 'power') $msg = $hostname . " has been powered on!";
	if ($type == 'reboot') $msg = $hostname . " is rebooting!";	
	if ($type == 'cpu') $msg = $hostname . " is adjusting its CPU!";		
	if ($type == 'ram') $msg = $hostname . " is adjusting its RAM!";	
	if ($type == 'migrate') $msg = $hostname . " is migrating!";	
	if ($type == 'delete') $msg = $hostname . " is being deleted!";	
	if ($type == 'snapshot') $msg = $hostname . " is being reverted to the " . $snapshot . " snapshot.";			
}

$date = date("Y/m/d");
echo "<p>";
echo "<center>";
$query = "SELECT v.ID, v.Hostname, h.Host, l.Name, v.Status, v.IP, v.OS, v.Platform FROM vm as v
			INNER JOIN hosts as h on v.Host = h.ID
			INNER JOIN logins as l on v.Owner = l.ID
			WHERE v.ID = '$vmid'
			ORDER BY v.Hostname ASC";
$request = mysqli_query($con, $query) or die("Could not connect: " . mysqli_error()); ;
	while($row = mysqli_fetch_array($request)) {
		$hostname = $row['Hostname'];
		$status = $row['Status'];
		$cpu = $row['CPU'];
		$ram = $row['RAM'];
		$host = $row['Host'];
echo "<div class='vmlistheadcontainer'>";
if (isset($_POST['type'])) echo "<div class='msgbar'>" . $msg . "</div>";
echo "<div class='vmlistheadbig'>" . strtoupper($row['Hostname']) . "</div>";
if (isset($_SESSION['SESS_NAME'])) echo "<div class='vmlistheadsmall'>" . $_SESSION['SESS_NAME'] . " - " . $date . " - " . $_SESSION['SESS_EMAIL'] . "</div>";
echo "</div>";
echo "<div class='individualvmcontainer'>";
	echo "<div class='individualvmleft'>";
		echo "<div class='individualline'>";
			echo "<div class='individualnamelabel'>Hostname:</div>";
			echo "<div class='individualnamevalue'>" . $row['Hostname'] . "</div>";
		echo "</div>";
		echo "<div class='individualline'>";
			echo "<div class='individualnamelabel'>Status:</div>";
			echo "<div class='individualnamevalue'>Powered On</div>";
		echo "</div>";		
		echo "<div class='individualline'>";
			echo "<div class='individualnamelabel'>Host Server:</div>";
			echo "<div class='individualnamevalue'>" . $row['Host'] . "</div>";
		echo "</div>";		
		echo "<div class='individualline'>";
			echo "<div class='individualnamelabel'>Folder:</div>";
			echo "<div class='individualnamevalue'>". $row['Folder'] . "</div>";
		echo "</div>";	
		echo "<div class='individualline'>";
			echo "<div class='individualnamelabel'>IP:</div>";
			echo "<div class='individualnamevalue'>" . $row['IP'] . "</div>";
		echo "</div>";	
		echo "<div class='individualline'>";
			echo "<div class='individualnamelabel'>CPU:</div>";
			echo "<div class='individualnamevalue'>" . $row['CPU'] . "</div>";
		echo "</div>";
		echo "<div class='individualline'>";
			echo "<div class='individualnamelabel'>RAM:</div>";
			echo "<div class='individualnamevalue'>" . $row['RAM'] . " GB</div>";
		echo "</div>";				
		echo "<div class='individualline'>";
			echo "<div class='individualnamelabel'>Operating System:</div>";
			echo "<div class='individualnamevalue'>" . $row['Platform'] . " " . $row['OS'] . "</div>";
		echo "</div>";	
		echo "<div class='individualline'>";
			echo "<div class='individualnamelabel'>Created:</div>";
			echo "<div class='individualnamevalue'>" . $row['Created'] . "</div>";
		echo "</div>";		
		echo "<div class='individualline'>";
			echo "<div class='individualnamelabel'>Owner:</div>";
			echo "<div class='individualnamevalue'>" . $row['Name'] . "</div>";
		echo "</div>";
		$rows = getRows($vmid, $con);
		echo "<div class='individualline'>";
			echo "<div class='individualnamelabel'>Snapshots:</div>";
			echo "<div class='individualnamevalue'><a href='javascript:;'' id='snapshotlink'>" . $rows . "</a></div>";
		echo "</div>";								
	echo "</div>";

	echo "<div class='individualvmright'>";
		echo "<button class='actionboxleft' id='btnpower' value='" . $hostname . "," . $status ."'><img src='power.png'><p>POWER ON</button>";
		echo "<button class='actionboxright' id='btnreboot' value='" . $hostname . "," . $status ."'><img src='reboot.png'><p>REBOOT</button>";
		echo "<button class='actionboxleft' id='btncpu' value='" . $hostname . "," . $cpu ."'><img src='cpu.png'><p>ADJUST CPU</button>";
		echo "<button class='actionboxright' id='btnram' value='" . $hostname . "," . $ram ."'><img src='ram.png'><p>ADJUST RAM</button>";		
		echo "<button class='actionboxleft' id='btnmigrate' value='" . $hostname . "," . $host ."'><img src='sync.png'><p>MIGRATE</button>";					
		echo "<button class='actionboxright' id='btndelete' value='" . $hostname . "," . $delete ."'><img src='delete.png'><p>DELETE</button>";			
	echo "</div>";
echo "</div>";
	}
echo "<p>";

//Snapshot Box
echo "<div class='snapshotcontainer' id='snapshotsid'>";
	echo "<form id='snapshot' method='POST' action=''>";
	echo "<div class='snapshotheader'>";
		echo "<div class='snapshotdateheader'>DATE</div>";
		echo "<div class='snapshotnameheader'>NAME</div>";
		echo "<div class='snapshotdescriptionheader'>DESCRIPTION</div>";
		echo "<div class='snapshotdeleteheader'><img src='redx.png' height=25px onclick=\"document.getElementById('snapshotsid').style.display='none'\"></div>";		
	echo "</div>";
$query = "SELECT s.ID, v.ID, s.Date, s.Name, s.Description FROM snapshots as s
				INNER JOIN vm as v on s.VMID = v.ID
				WHERE s.VMID = '$vmid'
				ORDER BY s.Date ASC";
$request = mysqli_query($con, $query) or die("Could not connect: " . mysqli_error()); ;
	while($row = mysqli_fetch_array($request)) {	
	echo "<div class='snapshotentry'>";
		echo "<div class='snapshotdate'><input type=radio name='snapshotselect' value='1'>&nbsp;" . $row['Date'] . "</div>";
		echo "<div class='snapshotname'>" . $row['Name'] . "</div>";
		echo "<div class='snapshotdescription'>" . $row['Description'] . "</div>";
		echo "<div class='snapshotdelete'><img src='delete.png' class='snapshottrash'></div>";		
	echo "</div>";
	}
	echo "<input type='hidden' name='type' value='snapshot'>";
	echo "<input type='hidden' name='vmid' value='" . $vmid . "'>";
	echo "<input type='hidden' id='hostname' name='hostname' value='" . $hostname . "'>";	
	echo "<button type='submit' class='snapshotgo' form='snapshot'>Go To Snapshot</button></form>";
echo "</div>";

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

echo "<div id='cpu' class='popupbox'>";
echo "<form class='popupvm-content-dialog animate' name='cpu' method='POST' action='' onsubmit='return showForm(this)'>";
	echo "<div class='popupvm-content-title'>";
		echo "<div class='popupvm-content-title-left'>Confirm CPU Adjustment</div>";
		echo "<div class='popupvm-content-title-right'><span id='hostnamecpu' class='dialog-head'></span></div>";
	echo "</div>";
	echo "<div class='popupvm-content-details'><img src='exclamation.png'>Are you sure you want to adjust the CPU?</div>";	
	echo "<div class='popupvm-content-yesno'>";	
	echo "<input type='hidden' id='hostname' name='hostname' value='" . $hostname . "'>";
	echo "<input type='hidden' name='type' value='cpu'>";	
	echo "<input type='hidden' name='vmid' value='" . $vmid . "'>";			
	echo "<button type='submit' class='yes' value='YES'><span>YES</span></button>";
	echo "<button type='reset' class='no' onclick=\"document.getElementById('cpu').style.display='none'\">NO</button>";
	echo "</div>";	
echo "</form></div>";


echo "<div id='ram' class='popupbox'>";
echo "<form class='popupvm-content-dialog animate' name='ram' method='POST' action='' onsubmit='return showForm(this)'>";
	echo "<div class='popupvm-content-title'>";
		echo "<div class='popupvm-content-title-left'>Confirm RAM Adjustment</div>";
		echo "<div class='popupvm-content-title-right'><span id='hostnameram' class='dialog-head'></span></div>";
	echo "</div>";
	echo "<div class='popupvm-content-details'><img src='exclamation.png'>Are you sure you want to adjust the RAM?</div>";	
	echo "<div class='popupvm-content-yesno'>";	
	echo "<input type='hidden' id='hostname' name='hostname' value='" . $hostname . "'>";
	echo "<input type='hidden' name='type' value='ram'>";	
	echo "<input type='hidden' name='vmid' value='" . $vmid . "'>";			
	echo "<button type='submit' class='yes' value='YES'><span>YES</span></button>";
	echo "<button type='reset' class='no' onclick=\"document.getElementById('ram').style.display='none'\">NO</button>";
	echo "</div>";	
echo "</form></div>";	


echo "<div id='migrate' class='popupbox'>";
echo "<form class='popupvm-content-dialog animate' name='migrate' method='POST' action='' onsubmit='return showForm(this)'>";
	echo "<div class='popupvm-content-title'>";
		echo "<div class='popupvm-content-title-left'>Confirm Migration</div>";
		echo "<div class='popupvm-content-title-right'><span id='hostnamemig' class='dialog-head'></span></div>";
	echo "</div>";
	echo "<div class='popupvm-content-details'><img src='exclamation.png'>Are you sure you want to migrate the virtual machine?</div>";	
	echo "<div class='popupvm-content-yesno'>";	
	echo "<input type='hidden' id='hostname' name='hostname' value='" . $hostname . "'>";
	echo "<input type='hidden' name='type' value='migrate'>";	
	echo "<input type='hidden' name='vmid' value='" . $vmid . "'>";			
	echo "<button type='submit' class='yes' value='YES'><span>YES</span></button>";
	echo "<button type='reset' class='no' onclick=\"document.getElementById('migrate').style.display='none'\">NO</button>";
	echo "</div>";	
echo "</form></div>";


echo "<div id='delete' class='popupbox'>";
echo "<form class='popupvm-content-dialog animate' name='delete' method='POST' action='' onsubmit='return showForm(this)'>";
	echo "<div class='popupvm-content-title'>";
		echo "<div class='popupvm-content-title-left'>Confirm Delete VM</div>";
		echo "<div class='popupvm-content-title-right'><span id='hostnamedel' class='dialog-head'></span></div>";
	echo "</div>";
	echo "<div class='popupvm-content-details'><img src='exclamation.png'>Are you sure you want to delete this virtual server?</div>";	
	echo "<div class='popupvm-content-yesno'>";	
	echo "<input type='hidden' id='hostname' name='hostname' value='" . $hostname . "'>";
	echo "<input type='hidden' name='type' value='delete'>";	
	echo "<input type='hidden' name='vmid' value='" . $vmid . "'>";			
	echo "<button type='submit' class='yes' value='YES'><span>YES</span></button>";
	echo "<button type='reset' class='no' onclick=\"document.getElementById('delete').style.display='none'\">NO</button>";
	echo "</div>";	
echo "</form></div>";


echo "<div id='removesnap' class='popupbox'>";
	echo "<form class='popupvm-content-dialog animate' name='removesnap' method='POST' action='' onsubmit='return showForm(this)'>";
	echo "<div class='popupvm-content-title'>";
		echo "<div class='popupvm-content-title-left'>Confirm Delete</div>";
		echo "<div class='popupvm-content-title-right'><span id='hostnamesnap' class='dialog-head'></span></div>";
	echo "</div>";
	echo "<div class='popup-title-details'>Are you sure you want to delete this VM from the cloud?</div>";	
	echo "<div class='popup-title-yesno'>";	
	echo "<input type='hidden' id='hostname' name='hostname' value='" . $hostname . "'>";
	echo "<input type='hidden' name='type' value='delete'>";	
	echo "<input type='hidden' name='vmid' value='" . $vmid . "'>";			
	echo "<button type='submit' class='yes' value='YES'><img src='greencheck.png'>&nbsp;&nbsp;<span>YES</span></button>";
	echo "<button type='reset' class='no' onclick=\"document.getElementById('removesnap').style.display='none'\"><img src='redx.png'>&nbsp;&nbsp;NO</button>";
	echo "</div>";	
echo "</form></div>";

echo "</center>";

function getRows ($vmid, $con) {
$query = "SELECT ID FROM snapshots WHERE VMID = '$vmid'";
$request = mysqli_query($con, $query) or die("Could not connect: " . mysqli_error());
$rows = mysqli_num_rows($request);	
return $rows;	
}
?>
</body>
</head>
</html>