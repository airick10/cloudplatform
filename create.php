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
<script type="text/javascript">
function showValue (type,value) {
	if (type === "cpu") {
		if (value === "1") {
			value = "1 Core"
		}
		else {
			value = value += " Cores"
		}
		document.getElementById("cpuright").innerHTML = value;	
	}
	if (type === "ram") {
		value = value += " GB"
		document.getElementById("ramright").innerHTML = value;	
	}
	if (type === "storage") {
		value = value += " GB"
		document.getElementById("storageright").innerHTML = value;	
	}	
	if (type === "host") {
		document.getElementById("hostright").innerHTML = value;	
	}
	if (type === "os") {
		document.getElementById("osright").innerHTML = value;	
		document.getElementById("osval").value = value;
		document.getElementById("osright").style.color = "#133453"
		document.getElementById("windows").style.border = "1px solid #6C8196";
		document.getElementById("linux").style.border = "1px solid #6C8196";					
	}					
}

function validateForm() {
	var ossel = document.forms["createvm"]["os"].value;
	var sname = document.forms["createvm"]["servername"].value;	
	if (sname == "") {
		document.getElementById("servername").style.border = "1px solid red";		
		return false;
	}	
	if (ossel == "Empty") {
		document.getElementById("windows").style.border = "1px solid red";
		document.getElementById("linux").style.border = "1px solid red";	
		document.getElementById("osright").innerHTML = "Please select an OS";		
		document.getElementById("osright").style.color = "red";			
		return false;
	}
}
</script>
<body>
<?php include ("header.php"); ?>
<p>
<center>
<form name="create" id="createvm" method="POST" action="createengine.php" onsubmit="return validateForm()">
<div class="createcontainer">
	<div class="createname">
		Choose a server name: <input type="text" name="name" placeholder="Type in a server name" id='servername'>
	</div>
	<div class="createboxcontainer">
		<div class="createboxleft">
			<div class="createboxleftlabel">How many CPU Cores?</div>
			<div class="createboxleftchoices">		
			<div class='opt'>1<input type=radio name="cpu" value="1" onclick="showValue('cpu', '1')" required></div>
			<div class='opt'>2 <input type=radio name="cpu" value="2" onclick="showValue('cpu', '2')" required></div>
			<div class='opt'>4 <input type=radio name="cpu" value="4" onclick="showValue('cpu', '4')" required></div>
			</div>	
		</div>
		<div class="createboxright" id="cpuresult"><span id='cpuright'></span>
		</div>
	</div>
	<div class="createboxcontainer">
		<div class="createboxleft">
			<div class="createboxleftlabel">How much RAM?</div>
			<div class="createboxleftchoices">
			<div class='opt'>1 GB <input type=radio name="ram" value="1" onclick="showValue('ram', '1')" required></div>
			<div class='opt'>2 GB<input type=radio name="ram" value="2" onclick="showValue('ram', '2')" required></div>
			<div class='opt'>4 GB<input type=radio name="ram" value="4" onclick="showValue('ram', '4')" required></div>
			<div class='opt'>8 GB<input type=radio name="ram" value="8" onclick="showValue('ram', '8')" required></div>
			</div>	
		</div>
		<div class="createboxright" id="ramresult"><span id='ramright'></span>
		</div>		
	</div>	
	<div class="createboxcontainer">
		<div class="createboxleft">
			<div class="createboxleftlabel">How much storage space?</div>
			<div class="createboxleftchoices">
			<div class='opt'>20 GB <input type=radio name="storage" value="20" onclick="showValue('storage', '20')" required></div>
			<div class='opt'>80 GB<input type=radio name="storage" value="80" onclick="showValue('storage', '80')" required></div>	
			<div class='opt'>100 GB<input type=radio name="storage" value="100" onclick="showValue('storage', '100')" required></div>
			<div class='opt'>200 GB<input type=radio name="storage" value="200" onclick="showValue('storage', '200')" required></div>
			</div>	
		</div>
		<div class="createboxright" id="storageresult"><span id='storageright'></span>  
		</div>		
	</div>
	<div class="createboxcontainer">
		<div class="createboxleft">
			<div class="createboxleftlabel">Which host do you want this on?</div>
			<div class="createboxleftchoices">
			<select name="host" onchange="showValue('host', this.value)" required>
			<option selected disabled>Select Host</option>				
			<option value="Boston">Boston</option>
			<option value="Newyork">Newyork</option>
			<option value="Chicago">Chicago</option>
			<option value="Losangeles">Losangeles</option>
			<option value="Houston">Houston</option>	
			<option value="Dallas">Dallas</option>	
			<option value="Sanfrancisco">Sanfrancisco</option>	
			<option value="Washington">Washington</option>	
			<option value="Philadelphia">Philadelphia</option>		
			<option value="Toronto">Toronto</option>		
			</select>
			</div>	
		</div>
		<div class="createboxright" id="hostresult"><span id='hostright'></span>
		</div>		
	</div>
	<div class="createboxcontainer">
		<div class="createboxleft">
			<div class="createboxleftlabel">Operating System?</div>
			<div class="createboxleftchoices">
				<div class="createosimgdivwin" id="windows"><img src="windows.png"><img src='downarrow.png' style="height: 15px; width: 15px;"></div>
				<div class="createosmenuwin">
					<ul>
						<li onclick="showValue('os', 'Win2008')">Windows 2008</li>
						<li onclick="showValue('os', 'Win2012')">Windows 2012</li>
						<li onclick="showValue('os', 'Win2018')">Windows 2018</li>
					</ul>
				</div>
				<div class="createosimgdivlin" id="linux"><img src="linux.png"><img src='downarrow.png' style="height: 15px; width: 15px;"></div>
				<div class="createosmenulin">
					<ul>
						<li onclick="showValue('os', 'CentOS')">CentOS</li>
						<li onclick="showValue('os', 'RedHat')">Red Hat</li>
						<li onclick="showValue('os', 'Ubuntu')">Ubuntu</li>
					</ul>
				</div>
			</div>
		</div>			
		<div class="createboxright" id="osresult"><span id='osright'></span>
		</div>		
	</div>										
<!--			<div class="createoption">
				<img src="windows.png"><br>
				<div class="createdropwin" onmouseover="showBox('win')">Select Version <img src='downarrow.png' style='height: 15px; width: 15px;'></div>
				<div class='createdropcontentwin' id='win' onmouseout="hideList('win')">
				<ul style="padding:0">
					<li onclick="osShow('Win2003')">Windows 2003</li>
					<li onclick="osShow('Win2008')">Windows 2008</li>		
					<li onclick="osShow('Win2012')">Windows 2012</li>	
					<li onclick="osShow('Win2018')">Windows 2018</li>												
				<select>
				<option selected disabled>Select Version</option>				
				<option>TEST</option>
				</select>

				</ul>
				</div>
				
			</div>
		</div>
-->		
	<input type="hidden" id="osval" name="os" value="Empty">
	<button id="createvm" class="createsubmit">Create Server</button>	
</div>
<span id='osdisplay'></span>

</center>
</body>
</head>
</html>