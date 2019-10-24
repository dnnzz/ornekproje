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
<body onload="updt();">
<?php
include 'header.html';
?>
<div id="cnt">
	<div id="qn" class="row">
			<h3 style="font-weight: bold;">Have A Question?</h3>
			<textarea class="form-control" style="overflow-y: auto !important; resize: none;" rows="8" cols="50" id="qns" placeholder="Enter Your Question"></textarea><br>
			<div id="sortbx2">
			</div><br>
			<Button class="form-control btn-primary" onclick="subqns()">Submit</Button>
	</div>
	<hr style="border: 1px solid black;">
	<div id="rel">
		<h3 style="text-align: center;font-weight: bold;">Questions for You</h3>
		<div id="sortbx">
		</div>
		<br><br><br>
		<div id="qnss">
			
		</div>
	</div>
</div>
	
</body>
<script src="jquery.js"></script>
<script src="bootstrap.min.js"></script>
<script>
	function subqns() {
		ans=$('#qns').val();
		ca=$('#sort2').val();
		if(ans!=""){
			 $.post('action.php',{answr : ans,uid:<?php echo $uid ?>,cat:ca},function(data)
            {
               if (data==1){
               		alert("Success");
               		$('#qns').val("");
               		$('#sort2').val(-1);
               		updt();
               }
               else
               	alert("Something Went Wrong");

            });
		}
		else
			alert("Please Enter Qn");
	}
	function updt() {
		$.post('action.php',{up : 0},function(data)
            {
            	$('#qnss').html(data);
            });

	}
	$(function(){
		$.post('action.php',{srt : 0},function(data)
            {
            	$('#sortbx').html(data);
            });
		$.post('action.php',{srt2 : 0},function(data)
            {
            	$('#sortbx2').html(data);
            });

	});
	function updattwo() {
		ca=$('#sort').val();
		if (ca>0) {
			$.post('action.php',{up :0,cat: ca},function(data)
            {
            	$('#qnss').html(data);
            });
		}
		else
			updt();
	}
</script>
</html>
