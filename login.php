<!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>
		<link rel="stylesheet" href="bootstrap.min.css">
	<link rel="stylesheet" href="style.css">

	<style type="text/css">
	body{
		background:url('img/bg.jpg');
		background-repeat: no-repeat;
	}
		#main{
			margin-top: 160px;
			background-color: #333;
			width: 600px;
			height: 300px;
			border-radius: 30px;
			opacity: 0.7;
		}
		h1{
			color: white;
			background-color: black;
			border-top-right-radius: 30px;
			border-top-left-radius: 30px;
		}
		.text{
			background-color: #333;
			color: white;
			width: 250px;
			font-weight: bold;
			font-size: 20px;
			border:none;
			text-align: center;
		}
		.text:focus{
			outline: none;
		}
		hr{
			width: 250px;
			margin-top: 0px !important;
		}
		#sub{
			width:250px;
			height: 30px;
			background-color: #5f5;
			border:none;
		}
	</style>
</head>
<body>
		<div id="header" class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-header">	
                <span><h2 style="font-weight: bolder;"><a style="text-decoration:none;" href="index.php">Wizard</a></h2></span>
            </div>
        </div>
		<center>
			<div id="main">
			<h1>LOGIN</h1>
			<form method="POST">
				<input type="text" name="username" class="text" autocomplete="off" required placeholder="username"><br><hr><br>
				<input type="password" name="password" class="text" required placeholder="password"><br><hr><br>
				<input type="Submit" name="submit" id="sub">
			</form>
			<br>
			<a style="font-weight: bold;color:white;" href="reg.php">Create Account</a>
		</div>
		</center>
</body>
</html>

<?php
include_once('dbcon.php');

	if (isset($_POST['submit'])) {
		$un=$_POST['username'];
		$pw=$_POST['password'];
		$sql=mysql_query("select id,password from user where username='$un'");
		if ($row=mysql_fetch_array($sql)) {
			if ($pw==$row['password']) {
				session_start();
				$_SESSION['user']=$row['id'];
				header("location:index.php");
				exit();
			}
			else
				echo "<script>alert('Invalid Password')</script>";	
		}
		else
			echo "<script>alert('Invalid Username')</script>";
	}
?>