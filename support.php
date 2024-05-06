<?php
session_start();
echo "<head>";
echo "<link rel='stylesheet' type='text/css' href='style.css'>";
echo "<link rel='stylesheet' href='https://pro.fontawesome.com/releases/v5.5.0/css/all.css' integrity='sha384-j8y0ITrvFafF4EkV1mPW0BKm6dp3c+J9Fky22Man50Ofxo2wNe5pT1oZejDH9/Dt' crossorigin='anonymous'>";
echo "<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>";
echo "<link href='https://fonts.googleapis.com/css?family=Rubik' rel='stylesheet'>";
echo "<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>"; 
echo "<link href='https://fonts.googleapis.com/css?family=Biryani:200|Cabin' rel='stylesheet'> ";
 echo "<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'> ";
?>
<title>Cloud</title>
<body>
<?php include ("header.php");
echo "<center>";
if (isset($_SESSION['SESS_NAME'])) {
echo "<div class='vmlistheadbig'>" . $_SESSION['SESS_NAME'] . "</div>";
echo "<div class='vmlistheadsmall'>" . $_SESSION['SESS_EMAIL'] . "</div>";
}	
else echo "<div class='vmlistheadbig' style='color=red'>You must login before submitting a ticket.</div>";
?>
<div class="supportcontainer">
	<div class="supportleft">
	<form method="POST" name="support">
	What System<br>
		<input type="text" name="server"><p>
	What kind of issue <br>
		<select name='type'>
		<option value='1'>OS Issue</option>
		<option value='2'>VM Boot Problem </option>
		<option value='3'>Networking</option>
		<option value='4'>Access</option>
		</select><p>		
	Subject <br>
		<input type="text" name="subject"><p>
	Your Issue <br>
		<textarea name="issue" form="support"></textarea><p>	
	<? if (isset($_SESSION['SESS_NAME'])) echo "<input type='submit' value='Submit Ticket'>"; ?>
		</form>
	</div>
	<div class="supportright">
		<p class="question">What is this programmed in?</p>
		<p class="answer">PHP, HTML, CSS, and Javascript</p>
		<p class="question">Does this website submit/e-mail tickets?</p>
		<p class="answer">No, it just uses dummy accounts.  No e-mails are actually sent.</p>		
	</div>	
</div>



</center>
</body>
</head>
</html>