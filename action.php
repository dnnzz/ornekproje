<?php 
include_once'dbcon.php';
if (isset($_POST['answr'])) {
	$ans=$_POST['answr'];
	$uid=$_POST['uid'];
	$ca=$_POST['cat'];
	$sql=mysql_query("insert into qn(frm,qn,catg) values($uid,'$ans',$ca)");
	if ($sql)
		echo "1";
	else
		echo "0";

}
if (isset($_POST['gtimg'])) {
	session_start();
	$id=$_SESSION['user'];
	$sql=mysql_query("select photo from user where id=$id");
	$row=mysql_fetch_array($sql);
	echo $row[0];
}

if (isset($_POST['up'])) {
	if (isset($_POST['cat'])) {
		$cat=$_POST['cat'];
		$op="where catg=$cat";
	}
	else
		$op="";
	$sql=mysql_query("select * from qn $op order by date_added DESC");
	if (mysql_num_rows($sql) > 0) {
		while($row=mysql_fetch_array($sql)){
			$qusrid=$row['frm'];
			$sqla=mysql_query("select name from user where id=$qusrid");
			$rowa=mysql_fetch_array($sqla);
			$name=$rowa[0];
			$qid=$row['id'];
			$sqla=mysql_query("select * from ans where fr=$qid");
			$cnt=mysql_num_rows($sqla);
		if ($row['catg']!=-1) {
			$c=$row['catg'];
			$sqls=mysql_query("select cat_name from cat where id=$c");
			$rows=mysql_fetch_array($sqls);
			$catg="[ ".$rows[0]." ]&nbsp;";
		}
		else
			$catg="[ Un-Catogorized ]";
		if ($row['ansrd']!=1)
			$img="img/nt.png";
		else
			$img="img/ys.png";
		?>
		<div class="divqn" >
			<span class="spnqn"><div class="dvqn"><a href="show.php?id=<?php echo $row['id'] ?>"><font class="cat"><?php echo $catg ?></font>&nbsp;<?php echo $row['qn'] ?></a></div><img class="qnimg" src=<?php echo $img ?> ></span>
				<br>
				<span class="spnqndet"><font class="qnath">BY : <?php echo $name ?></font>&nbsp;&nbsp;<?php echo $row['date_added']; ?>&nbsp;&nbsp; <font class="lk">Like [<?php echo $row['lke']; ?>]</font>&nbsp;<font class="dlk">Dis-like[<?php echo $row['dis'] ?>]</font> &nbsp;&nbsp;--&nbsp;[<?php echo $cnt ?> &nbsp; Answers]</span>
		</div>
		<hr>
		<?php
	}
	}
	else{ ?>
		<div class="divqn" >
			<h3 style="padding: 10px;text-align: center; color:red;">No Data Found</h3>
		</div>
		<hr>
		<?php
	}
}
if (isset($_POST['likeqn'])) {
	$id=$_POST['likeqn'];
	$sql=mysql_query("select lke from qn where id=$id");
	$row=mysql_fetch_array($sql);
	$cnt=1+$row[0];
	$sql=mysql_query("update qn set lke=$cnt where id=$id");
	echo $cnt;
}
if (isset($_POST['disqn'])) {
	$id=$_POST['disqn'];
	$sql=mysql_query("select dis from qn where id=$id");
	$row=mysql_fetch_array($sql);
	$cnt=1+$row[0];
	$sql=mysql_query("update qn set dis=$cnt where id=$id");
	echo $cnt;
}
if (isset($_POST['likeans'])) {
	$id=$_POST['likeans'];
	$sql=mysql_query("select lke from ans where id=$id");
	$row=mysql_fetch_array($sql);
	$cnt=1+$row[0];
	$sql=mysql_query("update ans set lke=$cnt where id=$id");
	echo $cnt;
}
if (isset($_POST['disans'])) {
	$id=$_POST['disans'];
	$sql=mysql_query("select dis from ans where id=$id");
	$row=mysql_fetch_array($sql);
	$cnt=1+$row[0];
	$sql=mysql_query("update ans set dis=$cnt where id=$id");
	echo $cnt;
}
if (isset($_POST['addans'])) {
	$id=$_POST['addans'];
	$ans=$_POST['ans'];
	$sql=mysql_query("update qn set ansrd=1 where id=$id");
	$sql=mysql_query("update ans set mark=1 where id=$ans");
		
}
if (isset($_POST['addanw']) && isset($_POST['from']) && isset($_POST['for'])) {
	$qid=$_POST['for'];
	$ans=$_POST['addanw'];
	$uid=$_POST['from'];
	$sql=mysql_query("insert into ans(frm,fr,ans) values($uid,$qid,'$ans')");
	$sql=mysql_query("select ans_count from qn where id=$qid");
	$row=mysql_fetch_array($sql);
	$cnt=1+$row[0];
	$sql=mysql_query("update qn set ans_count=$cnt where id=$qid");
}
if (isset($_POST['srt'])) {
	?>
	<select id="sort" class="form-control" onchange="updattwo();">
		<option value="0" selected>Sort</option>
	<?php
	$sql=mysql_query("select * from cat");

	if (mysql_num_rows($sql) > 0){
		while ($row=mysql_fetch_array($sql)) {
			echo "<option value=".$row['id']." > ".$row['cat_name']." </option>";
		}
	} 
	echo "</select>";

}
if (isset($_POST['upd'])) {
	$uid=$_POST['uid'];
	$sqlc=mysql_query("select DISTINCT fr from ans where frm=$uid");
	if (mysql_num_rows($sqlc) > 0) {
		while ($rowc=mysql_fetch_array($sqlc)) {
			$qid=$rowc['fr'];
			$sql=mysql_query("select * from qn where id=$qid order by date_added DESC");
			$row=mysql_fetch_array($sql);
			$sqla=mysql_query("select * from ans where fr=$qid");
			$cnt=mysql_num_rows($sqla);
			if ($row['catg']!=-1) {
				$c=$row['catg'];
				$sqls=mysql_query("select cat_name from cat where id=$c");
				$rows=mysql_fetch_array($sqls);
				$catg="[ ".$rows[0]." ]&nbsp;";
			}
			else
				$catg="[ Un-Catogorized ]";
			if ($row['ansrd']!=1)
				$img="img/nt.png";
			else
				$img="img/ys.png";
			?>
			<div class="divqn" >
				<span class="spnqn"><div class="dvqn"><a href="show.php?id=<?php echo $row['id'] ?>"><font class="cat"><?php echo $catg ?></font>&nbsp;<?php echo $row['qn'] ?></a></div><img class="qnimg" src=<?php echo $img ?> ></span>
					<br>
					<span class="spnqndet"><font class="qnath">BY : NAme</font>&nbsp;&nbsp;<?php echo $row['date_added']; ?>&nbsp;&nbsp; <font class="lk">Like [<?php echo $row['lke']; ?>]</font>&nbsp;<font class="dlk">Dis-like[<?php echo $row['dis'] ?>]</font> &nbsp;&nbsp;--&nbsp;[<?php echo $cnt ?> &nbsp; Answers]</span>
			</div>
			<hr>
		<?php
		}
	}
	else{ ?>
		<div class="divqn" >
			<h3 style="padding: 10px;text-align: center; color:red;">No Data Found</h3>
		</div>
		<hr>
		<?php
	}
}
if (isset($_POST['updte'])) {
	$uid=$_POST['uid'];
	$sql=mysql_query("select * from qn where frm=$uid order by date_added DESC");
	if (mysql_num_rows($sql) > 0) {
		while($row=mysql_fetch_array($sql)){
		$qid=$row['id'];
			$sqla=mysql_query("select * from ans where fr=$qid");
			$cnt=mysql_num_rows($sqla);
		if ($row['catg']!=-1) {
			$c=$row['catg'];
			$sqls=mysql_query("select cat_name from cat where id=$c");
			$rows=mysql_fetch_array($sqls);
			$catg="[ ".$rows[0]." ]&nbsp;";
		}
		else
			$catg="[ Un-Catogorized ]";
		if ($row['ansrd']!=1)
			$img="img/nt.png";
		else
			$img="img/ys.png";
		?>
		<div class="divqn" >
			<span class="spnqn"><div class="dvqn"><a href="show.php?id=<?php echo $row['id'] ?>"><font class="cat"><?php echo $catg ?></font>&nbsp;<?php echo $row['qn'] ?></a></div><img class="qnimg" src=<?php echo $img ?> ></span>
				<br>
				<span class="spnqndet"><font class="qnath">BY : NAme</font>&nbsp;&nbsp;<?php echo $row['date_added']; ?>&nbsp;&nbsp; <font class="lk">Like [<?php echo $row['lke']; ?>]</font>&nbsp;<font class="dlk">Dis-like[<?php echo $row['dis'] ?>]</font> &nbsp;&nbsp;--&nbsp;[<?php echo $cnt ?> &nbsp; Answers]</span>
		</div>
		<hr>
		<?php
	}
	}
	else{ ?>
		<div class="divqn" >
			<h3 style="padding: 10px;text-align: center; color:red;">No Data Found</h3>
		</div>
		<hr>
		<?php
	}
}
if (isset($_POST['srt2'])) {
	?>
	<select id="sort2" class="form-control">
		<option value="-1" selected>Select Catagory</option>
	<?php
	$sql=mysql_query("select * from cat");

	if (mysql_num_rows($sql) > 0){
		while ($row=mysql_fetch_array($sql)) {
			echo "<option value=".$row['id']." > ".$row['cat_name']." </option>";
		}
	} 
	echo "</select>";

}
if (isset($_POST['getprof'])) {
	
}


?>
			