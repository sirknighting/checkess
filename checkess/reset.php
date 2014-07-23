<?php
	include("checkesslatest.php");
	session_start();
	
	unset($_SESSION['board']);
	$_SESSION['board']=new GameBoard();
	
?>
