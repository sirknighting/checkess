<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register</title>
</head>
<style>

#box{
	padding: 10px;
	border-radius: 10px;
	background-color: #BBBBBB;
	width: 230px;
	
	}
.right-aligned{
	text-align: right;
}
span{
	display:inline-block;
}
label
		{ 
		display:inline-block;
		padding-top:3px;
		padding-bottom:3px;
		}
</style>
<body>
<?php
	include('checkesslatest.php');
	session_start();
	if(!isset($_SESSION['boardtest'])){
		$_SESSION['boardtest']=new GameBoard();
	}
	if(isset($_POST['fsend']))$move=$_POST['fsend'];
	else $move='    ';
	if(strlen($move)!=4){
		echo('move string length is incorrect');
		echo '<br/>';
		exit;
	}
	$board=&$_SESSION['boardtest'];
	$success=$board->executeMove($move);
	if(!$success){
		echo 'MOVE FAILED';
		echo '<br/>';
	}
	else echo('TRUE');
	$_SESSION['boardtest']=$board;
	session_write_close();
?>
<form id="box" method="POST" action="test2.php">

<span>
<input type="text" name="username"/><br/>
<input type="text" name="fsend" /><br/>
</span>   
<div class="right-aligned"><input type="submit" /> </div>
</form> 
</body>
</html>
