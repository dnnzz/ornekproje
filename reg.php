<?php
	if (isset($_POST['sub'])) {
		include_once('dbcon.php');
		$name=$_POST['name'];
		$email=$_POST['email'];
		$username=$_POST['username'];
		$type=mime_content_type($_FILES["file"]["tmp_name"]);
		$contents=file_get_contents($_FILES["file"]["tmp_name"]);
		$encoded= 'data:'.$type.';base64,'.base64_encode($contents);
		$pas1=$_POST['ps1'];
		$sql=mysql_query("insert into user(name,email,username,photo,password) values('$name','$email','$username','$encoded','$pas1')");
		if ($sql) {
			echo "<script>alert('success')</script>";
			header('location:login.php');
		}
		else
			echo "<script>alert('Error')</script>";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
		<link rel="stylesheet" href="bootstrap.min.css">
	<link rel="stylesheet" href="style.css">

	<style type="text/css">
	body{
		background:url('img/bg.jpg');
		background-repeat: no-repeat;
	}
		#main{
			background-color: #333;
			width: 600px;
			border-radius: 30px;
			opacity: 0.7;
			margin:0 auto;
			margin-top: 160px;
			padding-bottom: 20px;
		}
		h1{
			color: white;
			background-color: black;
			border-top-right-radius: 30px;
			border-top-left-radius: 30px;
		}
		.ipfr{
			width: 250px;
			margin-left: 150px;
			font-weight: bold;
			color: black;
		}
		hr{
			width: 250px;
			margin-top: 0px !important;
		}
	</style>
</head>
<body>
		<div id="header" class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-header">	
                <span><h2 style="font-weight: bolder;"><a style="text-decoration:none;" href="index.php">Wizard</a></h2></span>
            </div>
        </div>
			<div id="main">
			<h1 style="text-align: center;">Registration</h1><br>
			<form method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
					<input class="form-control ipfr" name="name" placeholder="name" required type="text" autocomplete="off"><br>
				<input class="form-control ipfr" name="email" placeholder="email" type="email" required autocomplete="off"><br>
		<input placeholder="username" name="username" class="form-control ipfr" type="text" required autocomplete="off"><br>
		<div class="form-group" style="margin-left: 150px;">
        <br>
          <input type="file" style="width: 100px;height: 100px;z-index: 0; opacity: 0; position: relative;" id="s_file" name="file"  accept="image/*" onchange="imag(this);">
          <img style="margin-top: -130px; width: 100px;height: 100px;border-radius: 50%;" src="img/user.png" id="imgsource">
      </div>
      <input class="form-control ipfr" name="ps1" id="ps1" placeholder="Password" required type="password" autocomplete="off"><br>
		<input class="form-control ipfr" name="ps2" id="ps2" placeholder="Confirm Password" type="password" autocomplete="off" required><br>
		<button class="form-control ipfr btn-primary" name="sub" type="submit">Submit</button><br>
			</form>
			<br>
			<center><a style="font-weight: bold;color:white;" href="login.php">Already Have an Account</a></center>
		</div>
		<br><br>
</body>
<script src="jquery.js"></script>
<script>
	function validateForm() {
 	p1=$('#ps1').val();
 	p2=$('#ps2').val();
 	if(p1==p2)
 		return true;
 	else{
 		alert('Password not Matching');
 		return false;
 	}
  }
  	function imag(a) {
  		var file=a.files[0];
  		var type=file["type"];
  		var size=file["size"];
  		var valid=["image/png","image/jpg","image/jpeg"];
  		if ($.inArray(type,valid) < 0) {
  			alert("invalid");
  		}
  		else{
           			$('#imgsource').attr('src', window.URL.createObjectURL(file));
  		}
  }
</script>
</html>