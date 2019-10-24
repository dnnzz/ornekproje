<?php
	session_start();
	if(isset($_SESSION['user']))
		$uid=$_SESSION['user'];
	else{
		header('location:login.php');
		exit();
	}
include_once('dbcon.php');
if (isset($_POST['sub'])) {
	$name=$_POST['name'];
	$email=$_POST['email'];
	$username=$_POST['username'];
	$cat=$_POST['cat'];
	$type=mime_content_type($_FILES["file"]["tmp_name"]);
	$contents=file_get_contents($_FILES["file"]["tmp_name"]);
	$encoded= 'data:'.$type.';base64,'.base64_encode($contents);
	$sql=mysql_query("update user set name='$name',email='$email',username='$username',cats='$cat',photo='$encoded' where id=$uid");
}
if (isset($_POST['sub2'])) {
	$pas1=$_POST['ps1'];
	$sql=mysql_query("update user set password='$pas1' where id=$uid");
}

$sql=mysql_query("select * from user where id=$uid");
$row=mysql_fetch_array($sql);
if ($row['cats']=='') 
	$cat='No Catagory';
else
	$cat=$row['cats'];
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
<div id="profl">
	<div id="cover_img">
		<img id="cvrimg" src="img/cover.jpg">
		<div id="proimg">
			<img id="proimg" src="<?php echo $row['photo']; ?>">
		</div>
	</div>
	<div id="prodet">
		Name : <span id="name"><?php echo $row['name'] ?></span> <a class='lnk' onclick="edit(1);">Edit</a><br><br>
		Email :<span id="email"><?php echo $row['email'] ?></span>    <br><br>
		Username : <span id="un"><?php echo $row['username'] ?></span>  <br><br>
		catagories : <span id="cat"><?php echo $cat ?></span>  <br><br>
		<a class='lnk' onclick="edit(6);">Change Password</a><br><br>
	</div>
</div>
<br><br><br>
<div id="hdn" style="z-index: 999!important;">
	<form method="POST" enctype="multipart/form-data">
		<a onclick="clse();"><div id="close" ><img style="width: 20px;height: 20px;position: absolute;" src="img/close.png"></div></a>
		<h2 style="text-align: center;">Edit Profile</h2>
		<div class="form-group">
        <br>
          <input type="file" style="width: 100px;height: 100px;z-index: 0; opacity: 0; position: relative;" id="s_file" name="file"  accept="image/*" onchange="imag(this);">
          <img style="margin-top: -130px; width: 100px;height: 100px;border-radius: 50%;" src="<?php echo $row['photo']; ?>" id="imgsource">
      </div>
		<input class="form-control ipfr" name="name" placeholder="name" required value=<?php echo $row['name'] ?> type="text" autocomplete="off"><br>
		<input class="form-control ipfr" name="email" placeholder="email" value=<?php echo $row['email'] ?> type="email" required autocomplete="off"><br>
		<input placeholder="username" name="username" class="form-control ipfr" value=<?php echo $row['username'] ?> type="text" required autocomplete="off"><br>
		<textarea placeholder="Catagory" name="cat" class="form-control ipfr"><?php echo $row['cats'] ?></textarea><br>
		<button class="form-control btn-primary" name="sub" type="submit">Submit</button><br>
	</form>
</div>
<div id="hdn2" style="z-index: 999!important;">
	<form method="POST" onsubmit="return validateForm()"> 
		<a onclick="clse();"><div id="close" ><img style="width: 20px;height: 20px;position: absolute;" src="img/close.png"></div></a>
		<h2 style="text-align: center;">Change Password</h2>
		<input class="form-control ipfr" name="ps1" id="ps1" placeholder="Password" required type="password"><br>
		<input class="form-control ipfr" name="ps2" id="ps2" placeholder="Confirm Password" type="password" required><br>
		<button class="form-control btn-primary" name="sub2" type="submit">Submit</button><br>
	</form>
</div>
<div id="bgblr"></div>
</body>
<script src="jquery.js"></script>
<script src="bootstrap.min.js"></script>
<script>
function edit (ar) {
	if (ar==1) {
		$('#bgblr').css('visibility','visible');
		$('#bgblr').css('display','block');
		$('#hdn').css('visibility','visible');
		$('#hdn').css('display','block');
		$('body').css('overflow-y','hidden');
		window.scrollTo(0,0);
	}
	else{
		$('#bgblr').css('visibility','visible');
		$('#bgblr').css('display','block');
		$('#hdn2').css('visibility','visible');
		$('#hdn2').css('display','block');
		$('body').css('overflow-y','hidden');
		window.scrollTo(0,0);
	}
}
function clse() {
	$('#bgblr').css('visibility','hidden');
		$('#bgblr').css('display','none');
		$('#hdn').css('visibility','hidden');
		$('#hdn').css('display','none');
		$('#hdn2').css('visibility','hidden');
		$('#hdn2').css('display','none');
		$('body').css('overflow-y','auto');
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
</script>
</html>
