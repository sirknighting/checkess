<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Board</title>
 
    
</head>
<?php
	include('checkesslatest.php');
	session_start();
	
	if(!isset($_SESSION['board'])){
		$_SESSION['board']=new GameBoard();
	}
	$move=catchParseInput();
	if(strlen($move)!=4){
		echo('move string length is incorrect');
		echo '<br/>';
	}
	else{
		$board=&$_SESSION['board'];
		$success=$board->executeMove($move);
		if(!$success){
			echo 'MOVE FAILED';
			echo '<br/>';
		}
		else echo('TRUE');
	}
	$_SESSION['board']=$board;
	session_write_close();
?>
<body onload="init();">

<canvas id="myBoard" width="720" height="680" style = 'border:1px solid black' >No canvas support in browser</canvas>
<p id = "jsDump"></p>
<p id='output'></p>
<script type="text/javascript" src="js/dragDrop.js">
<!--<script> // JavaScript for drag and drop code-->
</script>
<form id='reset' method="POST" action="reset.php">
	<input type="submit" value="reset" name="reset"/>
</form>
</body>

</html>