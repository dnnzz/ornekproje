<?php
	session_start();
	if(isset($_SESSION['user']))
		$uid=$_SESSION['user'];
	else{
		header('location:login.php');
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Wizard</title>
	<link rel="stylesheet" href="bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="jquery.js"></script>
</head>
<body>
<?php
include 'header.html';
?>
<div id="cnt">
	
	<div id="rel">
		<h3 style="text-align: center;font-weight: bold;">Notification</h3>
		<br><br><br>
		<div id="qnss">
			<h4 style="text-align:center; padding: 10px;">No New Notification</h4>
		</div>
	</div>
</div>
<hr style="border: 1px solid black;">
	<br><br>
</body>
<script src="jquery.js"></script>
<script src="bootstrap.min.js"></script>
<script>

</script>
</html>
