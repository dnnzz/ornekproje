<?php
	session_start();
	include_once'dbcon.php';
	if(isset($_SESSION['user']))
		$user=$_SESSION['user'];
	else{
		header('location:login.php');
		exit();
	}
if (!isset($_GET['id'])) {
	header("location:index.php");	
}
else{
	$id=$_GET['id'];
	$sql=mysql_query("select * from qn where id=$id");
	$row=mysql_fetch_array($sql);
	$qid=$row['id'];
	$uid=$row['frm'];
	$qnansrd=$row['ansrd'];
	$sqlu=mysql_query("select * from user where id=$uid");
	$rowu=mysql_fetch_array($sqlu);
	if ($row['catg']!=-1) {
			$c=$row['catg'];
			$sqls=mysql_query("select cat_name from cat where id=$c");
			$rows=mysql_fetch_array($sqls);
			$catg=$rows[0];
		}
		else
			$catg="Un-Catogorized";
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
<div id="contnt">
	<div id="qndets">
		<div class="row" style="display: flex;">
			<div class="col-md-3 uprof">
				<span class="prsp"><img class="profimg" src=<?php echo $rowu['photo'] ?> ></span><br><br>
				<span class="prsp" style="font-weight: bold"><?php echo $rowu['name'] ?></span><br>
				<span class="prsp"><?php echo $rowu['email'] ?></span><br>
			</div>
			<div class="col-md-9 uqns">
				<div id="qnhd">
					<a style="text-decoration: none;" href="#"><?php echo $catg ?></a>
				</div>
				<hr style="border:1px dashed #aaa;">
				<div id="qnbx">
					<?php echo $row['qn'] ?>
				</div>
				<hr style="border:1px dashed #aaa;">
				<div id="ftr">
				<a onclick="like(1,<?php echo $qid ?>,'likeqn');"><span style="color: green;" class="glyphicon glyphicon-thumbs-up"> </span> (<span id="likeqn"><?php echo $row['lke'] ?></span>)</a> <a onclick="dis(1,<?php echo $qid ?>,'disqn');"><span class="glyphicon glyphicon-thumbs-down" style="color: red;"> </span> (<span id="disqn"><?php echo $row['dis'] ?></span>)</a> <a  style=" margin-top: -10px; float:right;">Answers : <?php echo $row['ans_count'] ?></a>
				</div>
			</div>
		</div>
	</div>
	<hr style="border:1px solid #aaa;">
	<div id="ansdet" style="background: #ddd">
		<?php
			$sqla=mysql_query("select * from ans where fr=$id");
			if (mysql_num_rows($sqla) > 0) 
			{
				while($rowa=mysql_fetch_array($sqla)){
				$aid=$rowa['id'];
				$lk="lkan".$aid;
				$dlk="dlkan".$aid;
				$auid=$rowa['frm'];
				$sqlb=mysql_query("select * from user where id=$auid");
				$rowb=mysql_fetch_array($sqlb);
				$mark=$rowa['mark'];
				if ($qnansrd && $mark) {
					$str="<a style='text-decoration:none'><img style='width:20px;height:20px;' style src='img/ys.png'>&nbsp;Marked as Answer</a>";
				}
				else if($qnansrd && !$mark){
					$str="<a></a>";
				}
				else if(!$qnansrd){
					if($user==$uid){
						$str="<div class='checkbox'><label><input type='checkbox' id=$aid onchange='chkans($aid,$qid);'>Mark As Answer</label></div>";
					}
					else{
						$str="<a></a>";
					}
				}

			?>
			<div class="row" style="display: flex;background: white;padding: 10px;">
			<div class="col-md-3 uprof">
				<span class="prsp"><img class="profimg" src=<?php echo $rowb['photo'] ?> ></span><br><br>
				<span class="prsp" style="font-weight: bold"><?php echo $rowb['name'] ?></span><br>
				<span class="prsp"><?php echo $rowb['email'] ?></span><br>
			</div>
			<div class="col-md-9 uqns">
				<div id="qnhd">
					<?php echo $str ?>
				</div>
				<hr style="border:1px dashed #aaa;">
				<div id="qnbx">
					<?php echo $rowa['ans'] ?>
				</div>
				<hr style="border:1px dashed #aaa;">
				<div id="ftr">
				<a onclick="like(2,<?php echo $aid ?>,'<?php echo $lk ?>');"><span style="color: green;" class="glyphicon glyphicon-thumbs-up"> </span> (<span id=<?php echo $lk ?> > <?php echo $rowa['lke'] ?></span>)</a> <a onclick="dis(2,<?php echo $aid ?>,'<?php echo $dlk ?>');"><span class="glyphicon glyphicon-thumbs-down" style="color: red;"> </span> (<span id=<?php echo $dlk ?> ><?php echo $rowa['dis'] ?></span>)</a>
				</div>
			</div>
		</div>
		<br>
		<?php
		
		}
	}
		else{
			?>
			<div class="row" style="display: flex;">
			<div class="col-md-12 uqns" style="text-align: center;">
				<hr style="border:1px dashed #aaa;">
				<div id="qnbx">
					<h3>No Answers</h3>
				</div>
				<hr style="border:1px dashed #aaa;">
				</div>
		</div>
		<?php
		}
?>
	</div>
		<hr style="border:1px solid #aaa;">
	<div id="ansqns">
		<h3 style="text-align: center;">Know The Answer?</h3>
		<textarea class="form-control" style="overflow-y: auto !important; resize: none;" rows="8" cols="50" id="ans" placeholder="Enter Your Answer"></textarea><br>
			<Button class="form-control btn-primary" onclick="subasw()">Submit</Button>
	</div>
</div>
<br><br>
</body>
<script src="jquery.js"></script>
<script src="bootstrap.min.js"></script>
<script>
	function like(tar,id,upid) {
		if(tar==1){
			$.post('action.php',{likeqn:id},function(data)
            {
            	$('#'+upid).html(data);
            });
		}
		else{
			$.post('action.php',{likeans:id},function(data)
            {
            	$('#'+upid).html(data);
            });
		}
	}
	function dis(tar,id,upid) {
		if(tar==1){
			$.post('action.php',{disqn:id},function(data)
            {
            	$('#'+upid).html(data);
            });
		}
		else
		{
			$.post('action.php',{disans:id},function(data)
            {
            	$('#'+upid).html(data);
            });
		}
	}
	function chkans(val,qid) {
		if ($('#'+val).prop('checked')==true) {
			var r = confirm("Do You want to add this as Answer?");
			if (r == true) {
    			$.post('action.php',{addans:qid,ans:val},function(data)
            	{
            		alert('success');
            		location.reload();

           	 	});
			}
		}
	}
	function subasw() {
		ans=$('#ans').val();
		frm=<?php echo $user ?>;
		fr=<?php echo $qid ?>;
		if (ans!="") {
			$.post('action.php',{from:frm,for:fr,addanw:ans},function(data)
            	{
            		alert('success');
            		location.reload();

           	 	});
		}
	}
</script>
</html>
