
<?php
include("tabs.php");
include ("code.inc");
$con = mysql_connect($serverhost,$account,$key);
if (!$con)
    {  die('Could not connect: ' . mysql_error());
    }
mysql_select_db("vm_schema", $con);
echo "<p class='addspace'><p class='addspace'>";

echo "<center>";
echo "<p>";		
echo "<div id='vmhostcontainer'>";
$vcenter = "";
$totalvms = 0;
//$array = mysql_query("SELECT * FROM svlhosts WHERE vCenter = '$vcenter'");	
$query = "SELECT Host, Status, IP, Version, CPU, RAM, RAM Used FROM hosts
		ORDER BY v.Hostname ASC";
$request = mysqli_query($con, $query) or die("Could not connect: " . mysqli_error()); ;		
	while ($row = mysqli_fetch_array($request)) {
		if ($row['vCenter'] != $vcenter) {
			$vcenter = $row['vCenter'];
			echo "<div id='scontainervm' style='width:90%'>";
			echo "<span id='hostlabel'  style='width:15%'>" . $vcenter . "</span>";
			echo "<span id='hostlabel'  style='width:15%'>Status</span>";
			echo "<span id='hostlabel'>Version</span>";
			echo "<span id='hostlabel'>CPU</span>";
			echo "<span id='hostlabel'>RAM Total</span>";
			echo "<span id='hostlabel'>RAM Used</span>";
			echo "<span id='hostlabel'>Status</span>";			
			echo "<span id='hostlabel'>VMs</span>";	
			echo "</div>";					
		}
		$hostname = $row['Host'];
		$cpu = $row['NumCPU'];
		$memtotalgb = $row['MemoryTotalGB'];
		$memusagegb = $row['MemoryUsageGB'];
		$version = $row['Version'];
		$state = $row['ConnectionState'];		
		$result = mysqli_query("SELECT * FROM vm WHERE Host = '$hostname'");	
		$num_vms = mysqli_num_rows($result);
		$number = $memusagegb / $memtotalgb;
		$realnumber = $number * 100;
		$ram = round($memtotalgb);
		$percent = round($realnumber);
		$colorperc = round($realnumber);
		$percent = $percent . "%";
		$totalvms = $totalvms + $num_vms;

	echo "<form class='vm' method='post' action='vmhost.php''>";
	echo "<button class='vm'>";
	echo "<span id='hostlabel' style='width:15%'>" . $hostname . "</span>";
	echo "<input type='hidden' name='host' value='" . $hostname . "'>";		
	if ($row['ConnectionState'] == "Connected") echo "<span id='hostlabel' style='width:15%; color:green; font-weight:bold'>Connected</span>";
	if ($row['ConnectionState'] == "NotResponding") echo "<span id='hostlabel' style='width:15%; color:red; font-weight:bold'>Not Responding</span>";
	if ($row['ConnectionState'] == "Maintenance") echo "<span id='hostlabel' style='width:15%; color:brown; font-weight:bold'>Maintenance</span>";	
	echo "<span id='hostlabel'>" . $version . "</span>";
	echo "<span id='hostlabel'>" . $cpu . "</span>";
	echo "<span id='hostlabel'>" . $ram . "</span>";
	echo "<b>" . $percent . "</b><div class='statbox'>";
	if ($colorperc > 85) echo "<div class='statlabel' style='width:" . $percent . "; background-color:red'>&nbsp;</div>";
	if ($colorperc > 75 && $colorperc < 86) echo "<div class='statlabel' style='width:" . $percent . "; background-color:orange'>&nbsp;</div>";
	if ($colorperc < 76) echo "<div class='statlabel' style='width:" . $percent . "; background-color:green'>&nbsp;</div>";		
	echo "</div>";
	echo "<span id='hostlabel'>" . $num_vms . "</span>";			
	echo "</form>";
	echo "</button>";
}
echo "</div>";
echo "<p>";	
echo "</center>";	