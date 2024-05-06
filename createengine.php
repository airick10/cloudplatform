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
if(isset($_POST['name'])) $name = $_POST['name'];
else $name = "N/A";
if(isset($_POST['cpu'])) $cpu = $_POST['cpu'];
else $cpu = "N/A";
if(isset($_POST['ram'])) $ram = $_POST['ram'];
else $ram = "N/A";
if(isset($_POST['storage'])) $storage = $_POST['storage'];
else $storage = "N/A";
if(isset($_POST['host'])) $host = $_POST['host'];
else $host = "N/A";
if(isset($_POST['os'])) $os = $_POST['os'];
else $os = "N/A";
echo "<p>";
echo "<center>";
echo "Name - " . $name . "<br>";
echo "CPU - " . $cpu . "<br>";
echo "RAM - " . $ram . "<br>";
echo "HDD - " . $storage . "<br>";
echo "Host - " . $host . "<br>";
echo "OS - " . $os . "<br>";
$date = date("Y-m-d");
$query = "SELECT ID, IP from vm ORDER BY ID DESC LIMIT 1";
$request = mysqli_query($con, $query) or die("Could not grab last ID: " . mysqli_error()); ;
	while($row = mysqli_fetch_array($request)) {
		$newid = $row['ID'] + 1;
		$ipaddy = explode(".", $row['IP']);
		$ipfourth = $ipaddy[3] + 1;
		$ip = "192.168.1." . $ipfourth;
	}
	//$user = $_SESSION['SESS_NAME'];
	
$hostreq = "SELECT h.ID, v.Host, h.Host FROM hosts as h
	INNER JOIN vm as v ON v.Host = h.ID
	WHERE h.Host = '$host'
	LIMIT 1";
$request = mysqli_query($con, $hostreq) or die("Could grab host ID: " . mysqli_error($con));
	while($row = mysqli_fetch_array($request)) {
		$hostid = $row['ID'];
	}
$insert = "INSERT INTO vm (ID, Hostname, Status, Host, Folder, IP, CPU, RAM, Platform, OS, Created, Owner) VALUES ('$newid', '$name', 'Off', '$hostid', 'East', '$ip', '$cpu', '$ram', 'Windows', '$os', '$date', 'User')";
$request = mysqli_query($con, $insert) or die("Could not insert: " . mysqli_error($con));
?>
<p>

</center>
</body>
</head>
</html>