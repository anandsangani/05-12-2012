<?php
	echo 'hello';
	if(empty($_GET))
	{
		exit;
	}

	$link = mysql_connect("localhost","root","") or die("Failed to connect with user.");
	mysql_select_db("zend",$link) or die("Failed to connect with Database.");
	
	$q = "select * from user where username= '".$_GET['s']."'";
	
	$res = mysql_query($q,$link) or die("Wrong query executed");
	
	
	$row = mysql_fetch_assoc($res);
	if(!empty($row))
	{		
		echo '<script type="text/javascript"> alert("Username already exists. Please try a different one."); return false;</script>';
	}
	else
	{
		//do nothing.
	}
	

?>